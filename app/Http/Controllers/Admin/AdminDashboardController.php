<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->startOfDay();

        $stats = [
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'today_revenue' => Order::where('payment_status', 'paid')->where('created_at', '>=', $today)->sum('total_amount'),
            'total_orders' => Order::count(),
            'today_orders' => Order::where('created_at', '>=', $today)->count(),
            'pending_verifications' => Order::where('payment_status', 'pending_verification')->count(),
            'processing_orders' => Order::where('order_status', 'processing')->count(),
            'total_products' => Product::count(),
        ];

        $recentOrders = Order::with('items')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $settings = [
            'store_status' => Setting::get('store_status', 'open'),
            'wa_admin' => Setting::get('wa_admin', '081234567890'),
            'delivery_fee' => Setting::get('delivery_fee', 5000),
            'store_address' => Setting::get('store_address', 'Stand Kewirausahaan FRUVIT.ID'),
            'qris_image' => Setting::get('qris_image', 'images/qris-fruvit.jpg'),
        ];

        return view('admin.dashboard', compact('stats', 'recentOrders', 'settings'));
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
