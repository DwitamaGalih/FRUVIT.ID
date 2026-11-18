<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function show(string $orderNumber): View
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        $bankAccounts = [
            'bca' => [
                'bank' => 'Bank BCA',
                'number' => Setting::get('bank_bca_number', '8420198821'),
                'holder' => Setting::get('bank_bca_name', 'FRUVIT ID - ACHMAD'),
                'color' => 'from-blue-600 to-blue-800',
            ],
            'mandiri' => [
                'bank' => 'Bank Mandiri',
                'number' => Setting::get('bank_mandiri_number', '1370019283741'),
                'holder' => Setting::get('bank_mandiri_name', 'FRUVIT ID - ACHMAD'),
                'color' => 'from-amber-600 to-yellow-800',
            ],
            'bri' => [
                'bank' => 'Bank BRI',
                'number' => Setting::get('bank_bri_number', '002101839201509'),
                'holder' => Setting::get('bank_bri_name', 'FRUVIT ID - ACHMAD'),
                'color' => 'from-sky-700 to-blue-900',
            ],
        ];

        $qrisImage = Setting::get('qris_image', 'images/qris-fruvit.svg');
        $waAdmin = Setting::get('wa_admin', '081234567890');
        $storeAddress = Setting::get('store_address', 'Stand Kewirausahaan FRUVIT.ID');

        return view('pages.order-status', compact('order', 'bankAccounts', 'qrisImage', 'waAdmin', 'storeAddress'));
    }

    public function uploadProof(Request $request, string $orderNumber): RedirectResponse
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'payment_proof.required' => 'File bukti pembayaran wajib dipilih.',
            'payment_proof.image' => 'File harus berupa foto / gambar.',
            'payment_proof.max' => 'Ukuran file bukti pembayaran maksimal 5MB.',
        ]);

        if ($request->hasFile('payment_proof')) {
            // Delete old proof if exists
            if ($order->payment_proof && Storage::disk('public')->exists($order->payment_proof)) {
                Storage::disk('public')->delete($order->payment_proof);
            }

            $path = $request->file('payment_proof')->store('proofs', 'public');

            $order->update([
                'payment_proof' => $path,
                'payment_status' => 'pending_verification',
            ]);
        }

        return redirect()->route('order.show', $order->order_number)
            ->with('success', 'Bukti pembayaran berhasil diunggah! Admin akan segera memverifikasi pesanan Anda.');
    }

    public function track(Request $request): View
    {
        $keyword = trim($request->query('q', ''));
        $orders = collect();

        if (! empty($keyword)) {
            $orders = Order::with('items')
                ->where('order_number', 'like', "%{$keyword}%")
                ->orWhere('customer_phone', 'like', "%{$keyword}%")
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        }

        return view('pages.track', compact('keyword', 'orders'));
    }
}
