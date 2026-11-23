<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $today = now()->startOfDay();
        $po = $request->query('po', 'all');

        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'today_revenue' => Order::where('payment_status', 'paid')->where('created_at', '>=', $today)->sum('total_amount'),
            'total_orders' => Order::count(),
            'today_orders' => Order::where('created_at', '>=', $today)->count(),
            'pending_verifications' => Order::where('payment_status', 'pending_verification')->count(),
            'processing_orders' => Order::where('order_status', 'processing')->count(),
            'total_products' => Product::count(),
        ];

        // Query pesanan masuk terbaru di dashboard dengan opsi filter PO
        $ordersQuery = Order::with('items')->orderBy('created_at', 'desc');

        if ($po !== 'all' && ! empty($po)) {
            if ($po === 'none') {
                $ordersQuery->where(function ($q) {
                    $q->whereNull('po_batch')->orWhere('po_batch', '');
                });
            } else {
                $ordersQuery->where('po_batch', $po);
            }
        }

        $recentOrders = $ordersQuery->take(10)->get();

        // Rekap ringkas jika sedang memfilter PO tertentu
        $poSummary = null;
        if ($po !== 'all' && ! empty($po)) {
            $sumQuery = Order::query();
            if ($po === 'none') {
                $sumQuery->where(function ($q) {
                    $q->whereNull('po_batch')->orWhere('po_batch', '');
                });
            } else {
                $sumQuery->where('po_batch', $po);
            }

            $orderIds = (clone $sumQuery)->pluck('id');
            $totalItems = OrderItem::whereIn('order_id', $orderIds)->sum('quantity');

            $poSummary = [
                'count' => $sumQuery->count(),
                'total_items' => (int) $totalItems,
                'total' => $sumQuery->sum('total_amount'),
            ];
        }

        // Daftar kelompok PO yang tersedia untuk dropdown
        $allPos = collect(['PO 1', 'PO 2', 'PO 3', 'PO 4', 'PO 5']);
        try {
            if (Schema::hasColumn('orders', 'po_batch')) {
                $existingPos = Order::whereNotNull('po_batch')
                    ->where('po_batch', '!=', '')
                    ->distinct()
                    ->pluck('po_batch');
                $allPos = $allPos->merge($existingPos)->unique()->sort()->values();
            }
        } catch (\Throwable $e) {
        }

        $settings = [
            'store_status' => Setting::get('store_status', 'open'),
            'wa_admin' => Setting::get('wa_admin', '081234567890'),
            'delivery_fee' => Setting::get('delivery_fee', 5000),
            'store_address' => Setting::get('store_address', 'Stand Kewirausahaan FRUVIT.ID'),
            'qris_image' => Setting::get('qris_image', 'images/qris-fruvit.jpg'),
        ];

        return view('admin.dashboard', compact('stats', 'recentOrders', 'settings', 'po', 'allPos', 'poSummary'));
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_status' => 'required|in:open,closed',
            'wa_admin' => 'required|string',
            'delivery_fee' => 'required|numeric|min:0',
            'store_address' => 'required|string',
        ]);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val);
        }

        return redirect()->back()->with('success', 'Pengaturan toko berhasil diperbarui!');
    }
}
