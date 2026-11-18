<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');

        $query = Order::with('items')->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            if (in_array($status, ['unpaid', 'pending_verification', 'paid'])) {
                $query->where('payment_status', $status);
            } else {
                $query->where('order_status', $status);
            }
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $counts = [
            'all' => Order::count(),
            'pending_verification' => Order::where('payment_status', 'pending_verification')->count(),
            'unpaid' => Order::where('payment_status', 'unpaid')->count(),
            'processing' => Order::where('order_status', 'processing')->count(),
            'ready' => Order::where('order_status', 'ready')->count(),
            'completed' => Order::where('order_status', 'completed')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'status', 'search', 'counts'));
    }

    public function show(Order $order): View
    {
        $order->load('items');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'payment_status' => 'nullable|in:unpaid,pending_verification,paid,cancelled',
            'order_status' => 'nullable|in:new,processing,ready,completed,cancelled',
        ]);

        if (isset($validated['payment_status'])) {
            $order->payment_status = $validated['payment_status'];
            if ($validated['payment_status'] === 'paid' && ! $order->payment_confirmed_at) {
                $order->payment_confirmed_at = now();
            }
        }

        if (isset($validated['order_status'])) {
            $order->order_status = $validated['order_status'];
        }

        $order->save();

        return redirect()->back()->with('success', "Status pesanan {$order->order_number} berhasil diperbarui.");
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
