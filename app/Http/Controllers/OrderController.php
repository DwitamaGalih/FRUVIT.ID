<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function show(string $orderNumber): View
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();

        $qrisImage = Setting::get('qris_image', 'images/qris-fruvit.jpg');
        $waAdmin = Setting::get('wa_admin', '081234567890');
        $storeAddress = Setting::get('store_address', 'Stand Kewirausahaan FRUVIT.ID');

        return view('pages.order-status', compact('order', 'qrisImage', 'waAdmin', 'storeAddress'));
    }

    public function uploadProof(Request $request, string $orderNumber): RedirectResponse
    {
        @ini_set('memory_limit', '256M');

        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ], [
            'payment_proof.required' => 'File bukti pembayaran wajib dipilih.',
            'payment_proof.image' => 'File harus berupa foto / gambar.',
            'payment_proof.max' => 'Ukuran file bukti pembayaran maksimal 10MB.',
        ]);

        try {
            if ($request->hasFile('payment_proof')) {
                $base64Image = $this->processUploadedImage($request->file('payment_proof'));

                $order->update([
                    'payment_proof' => $base64Image,
                    'payment_status' => 'pending_verification',
                    'order_status' => 'processing',
                ]);
            }

            return redirect()->route('order.show', $order->order_number)
                ->with('success', 'Bukti pembayaran berhasil diunggah! Pesanan Anda kini sedang diverifikasi oleh admin.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Upload payment proof error: '.$e->getMessage());

            return redirect()->route('order.show', $order->order_number)
                ->with('error', 'Gagal memproses bukti pembayaran karena jaringan sibuk. Silakan coba lagi atau kirim langsung ke WhatsApp admin.');
        }
    }

    /**
     * Convert and optimize uploaded image to Base64 Data URI for serverless cloud persistence
     */
    private function processUploadedImage(UploadedFile $file, int $maxWidth = 1200): string
    {
        $mime = $file->getMimeType() ?: 'image/jpeg';
        $realPath = $file->getRealPath();
        $imageData = null;

        if (extension_loaded('gd') && function_exists('imagecreatefromstring')) {
            try {
                $raw = file_get_contents($realPath);
                $src = @imagecreatefromstring($raw);
                if ($src !== false) {
                    $width = imagesx($src);
                    $height = imagesy($src);

                    if ($width > $maxWidth) {
                        $newWidth = $maxWidth;
                        $newHeight = (int) ($height * ($maxWidth / $width));
                        $dst = imagecreatetruecolor($newWidth, $newHeight);

                        imagealphablending($dst, false);
                        imagesavealpha($dst, true);

                        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                        imagedestroy($src);
                        $src = $dst;
                    }

                    ob_start();
                    imagejpeg($src, null, 80);
                    $imageData = ob_get_clean();
                    imagedestroy($src);
                    $mime = 'image/jpeg';
                }
            } catch (\Throwable $e) {
                $imageData = null;
            }
        }

        if (! $imageData) {
            $imageData = file_get_contents($realPath);
        }

        return "data:{$mime};base64,".base64_encode($imageData);
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
