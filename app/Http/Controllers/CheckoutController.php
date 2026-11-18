<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $order = DB::transaction(function () use ($validated, $orderNumber, $subtotal, $deliveryFee, $totalAmount, $initialPaymentStatus, $cart) {
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
                ]);
            }

            return $order;
        });

        // Clear cart
        $this->cartService->clear();

        return redirect()->route('order.show', $order->order_number)
            ->with('success', 'Pesanan Anda berhasil dibuat! Silakan selesaikan pembayaran.');
    }
}
