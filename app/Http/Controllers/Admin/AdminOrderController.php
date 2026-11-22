<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminOrderController extends Controller
{
    public function exportExcel(Request $request): StreamedResponse
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');
        $startDate = $request->query('from');
        $endDate = $request->query('to');
        $po = $request->query('po', 'all');

        $query = Order::with('items')->orderBy('created_at', 'desc');

        if ($status !== 'all' && ! empty($status)) {
            if (in_array($status, ['unpaid', 'pending_verification', 'paid'])) {
                $query->where('payment_status', $status);
            } else {
                $query->where('order_status', $status);
            }
        }

        if ($po !== 'all' && ! empty($po)) {
            if ($po === 'none') {
                $query->where(function ($q) {
                    $q->whereNull('po_batch')->orWhere('po_batch', '');
                });
            } else {
                $query->where('po_batch', $po);
            }
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('po_batch', 'like', "%{$search}%");
            });
        }

        if (! empty($startDate)) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if (! empty($endDate)) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $orders = $query->get();

        $filename = 'Laporan_Penjualan_FRUVIT_'.now()->format('Ymd_His').'.xls';

        return response()->streamDownload(function () use ($orders) {
            echo view('admin.exports.orders-excel', compact('orders'))->render();
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control' => 'max-age=0',
        ]);
    }

    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search', '');
        $po = $request->query('po', 'all');

        $query = Order::with('items')->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            if (in_array($status, ['unpaid', 'pending_verification', 'paid'])) {
                $query->where('payment_status', $status);
            } else {
                $query->where('order_status', $status);
            }
        }

        if ($po !== 'all' && ! empty($po)) {
            if ($po === 'none') {
                $query->where(function ($q) {
                    $q->whereNull('po_batch')->orWhere('po_batch', '');
                });
            } else {
                $query->where('po_batch', $po);
            }
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_phone', 'like', "%{$search}%")
                    ->orWhere('po_batch', 'like', "%{$search}%");
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

        $availablePos = [];
        try {
            if (Schema::hasColumn('orders', 'po_batch')) {
                $availablePos = Order::whereNotNull('po_batch')
                    ->where('po_batch', '!=', '')
                    ->distinct()
                    ->pluck('po_batch')
                    ->sort()
                    ->values();
            }
        } catch (\Throwable $e) {
        }

        return view('admin.orders.index', compact('orders', 'status', 'search', 'counts', 'po', 'availablePos'));
    }

    public function show(Order $order): View
    {
        $order->load('items');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        try {
            if (! Schema::hasColumn('orders', 'po_batch')) {
                DB::statement('ALTER TABLE orders ADD COLUMN po_batch VARCHAR(50) NULL AFTER order_status');
            }
        } catch (\Throwable $e) {
        }

        $validated = $request->validate([
            'payment_status' => 'nullable|in:unpaid,pending_verification,paid,cancelled',
            'order_status' => 'nullable|in:new,processing,ready,completed,cancelled',
            'po_batch' => 'nullable|string|max:50',
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

        if ($request->has('po_batch')) {
            $poValue = trim((string) $request->input('po_batch', ''));
            $order->po_batch = $poValue !== '' ? $poValue : null;
        }

        $order->save();

        return redirect()->back()->with('success', "Status dan kelompok PO pesanan {$order->order_number} berhasil diperbarui.");
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
