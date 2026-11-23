<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderNotification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index(): View|RedirectResponse
    {
        $cart = $this->cartService->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('menu.index')
                ->with('warning', 'Keranjang belanja Anda masih kosong. Silakan pilih menu terlebih dahulu.');
        }

        $deliveryFee = (float) Setting::get('delivery_fee', 5000);
        $storeAddress = Setting::get('store_address', 'Stand Kewirausahaan FRUVIT.ID');
        $storeStatus = Setting::get('store_status', 'open');

        return view('pages.checkout', compact('cart', 'deliveryFee', 'storeAddress', 'storeStatus'));
    }

    public function process(Request $request): RedirectResponse
    {
        $cart = $this->cartService->getCart();

        if (empty($cart['items'])) {
            return redirect()->route('menu.index')
                ->with('error', 'Keranjang belanja Anda kosong.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|min:8|max:20',
            'delivery_method' => 'required|in:pickup,delivery',
            'shipping_address' => 'nullable|required_if:delivery_method,delivery|string|max:500',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:qris,cash',
        ], [
            'customer_name.required' => 'Nama lengkap wajib diisi.',
            'customer_phone.required' => 'Nomor WhatsApp wajib diisi.',
            'shipping_address.required_if' => 'Alamat pengiriman wajib diisi untuk layanan delivery.',
            'payment_method.in' => 'Metode pembayaran yang dipilih harus QRIS atau Tunai/Cash.',
        ]);

        $deliveryFee = $validated['delivery_method'] === 'delivery'
            ? (float) Setting::get('delivery_fee', 5000)
            : 0;

        $subtotal = (float) $cart['subtotal'];
        $totalAmount = $subtotal + $deliveryFee;

        // Generate unique Order Number: FRV-YYYYMMDD-XXXX
        $dateStr = now()->format('ymd');
        $randomSuffix = strtoupper(Str::random(4));
        $orderNumber = "FRV-{$dateStr}-{$randomSuffix}";

        $initialPaymentStatus = 'unpaid';

        try {
            $order = DB::transaction(function () use ($validated, $orderNumber, $subtotal, $deliveryFee, $totalAmount, $initialPaymentStatus, $cart) {
                // Validasi & kunci stok produk dengan lockForUpdate untuk mencegah race condition
                foreach ($cart['items'] as $item) {
                    $product = Product::lockForUpdate()->find($item['id']);
                    if (! $product || ! $product->is_available || $product->stock < $item['quantity']) {
                        $sisa = $product ? max(0, $product->stock) : 0;
                        throw new \Exception("Maaf, stok {$item['name']} tidak mencukupi (sisa: {$sisa} porsi). Silakan sesuaikan jumlah pesanan Anda di keranjang.");
                    }
                }

                $order = Order::create([
                    'order_number' => $orderNumber,
                    'customer_name' => $validated['customer_name'],
                    'customer_phone' => $validated['customer_phone'],
                    'delivery_method' => $validated['delivery_method'],
                    'shipping_address' => $validated['shipping_address'] ?? null,
                    'notes' => $validated['notes'] ?? null,
                    'subtotal' => $subtotal,
                    'delivery_fee' => $deliveryFee,
                    'total_amount' => $totalAmount,
                    'payment_method' => $validated['payment_method'],
                    'payment_status' => $initialPaymentStatus,
                    'order_status' => 'new',
                ]);

                foreach ($cart['items'] as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['id'],
                        'product_name' => $item['name'],
                        'product_price' => $item['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                        'notes' => $item['notes'] ?? null,
                        'sugar_level' => $item['sugar_level'] ?? null,
                        'jelly_topping' => $item['jelly_topping'] ?? null,
                        'pickup_day' => $item['pickup_day'] ?? null,
                        'pickup_batch' => $item['pickup_batch'] ?? null,
                    ]);

                    // Kurangi stok produk secara otomatis
                    $product = Product::find($item['id']);
                    if ($product) {
                        $newStock = max(0, $product->stock - $item['quantity']);
                        $product->update([
                            'stock' => $newStock,
                            'is_available' => $newStock > 0 ? $product->is_available : false,
                        ]);
                    }
                }

                return $order;
            });
        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }

        // Clear cart
        $this->cartService->clear();

        // Kirim email notifikasi pesanan baru ke tim FRUVIT
        try {
            $adminEmail = Setting::get('admin_email', env('MAIL_ADMIN_ADDRESS', 'fruvit.id@gmail.com'));
            if (! empty($adminEmail)) {
                Mail::to($adminEmail)->send(new NewOrderNotification($order));
            }
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim notifikasi email pesanan baru: '.$e->getMessage());
        }

        return redirect()->route('order.show', $order->order_number)
            ->with('success', 'Pesanan Anda berhasil dibuat! Silakan selesaikan pembayaran.');
    }
}
