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
            'bank_bca_number' => Setting::get('bank_bca_number', '8420198821'),
            'bank_bca_name' => Setting::get('bank_bca_name', 'FRUVIT ID - ACHMAD'),
            'bank_mandiri_number' => Setting::get('bank_mandiri_number', '1370019283741'),
            'bank_mandiri_name' => Setting::get('bank_mandiri_name', 'FRUVIT ID - ACHMAD'),
            'bank_bri_number' => Setting::get('bank_bri_number', '002101839201509'),
            'bank_bri_name' => Setting::get('bank_bri_name', 'FRUVIT ID - ACHMAD'),
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
            'bank_bca_number' => 'nullable|string',
            'bank_bca_name' => 'nullable|string',
            'bank_mandiri_number' => 'nullable|string',
            'bank_mandiri_name' => 'nullable|string',
            'bank_bri_number' => 'nullable|string',
            'bank_bri_name' => 'nullable|string',
        ]);

        foreach ($validated as $key => $val) {
            Setting::set($key, $val);
        }

        return redirect()->back()->with('success', 'Pengaturan toko berhasil diperbarui!');
    }
}
