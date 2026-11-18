@extends('layouts.admin')

@section('title', 'Dashboard Pengelola - FRUVIT.ID')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Welcome Header & Quick Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Dashboard Pengelola FRUVIT.ID</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau omset penjualan, verifikasi pembayaran QRIS & Tunai, dan unduh laporan Excel.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('admin.reports.excel') }}" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs px-4 py-2.5 rounded-xl shadow-xs hover:shadow-md transition">
                    <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Cetak Laporan Excel</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition">
                    Lihat Semua Pesanan
                </a>
                <a href="{{ route('admin.products.create') }}" class="bg-yellow-400 hover:bg-yellow-500 text-emerald-950 font-black text-xs px-4 py-2.5 rounded-xl shadow-xs transition">
                    + Tambah Produk
                </a>
            </div>
        </div>

        <!-- Metric Cards Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            
            <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Omset Lunas</div>
                <div class="text-xl sm:text-2xl font-black text-emerald-600 mt-1.5">
                    Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                </div>
                <div class="text-[10px] text-slate-500 mt-1">Hari ini: Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pesanan</div>
                <div class="text-xl sm:text-2xl font-black text-slate-900 mt-1.5">
                    {{ $stats['total_orders'] }}
                </div>
                <div class="text-[10px] text-emerald-600 font-bold mt-1">{{ $stats['today_orders'] }} pesanan hari ini</div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Verifikasi Bukti</div>
                <div class="text-xl sm:text-2xl font-black text-amber-600 mt-1.5">
                    {{ $stats['pending_verifications'] }}
                </div>
                <div class="text-[10px] text-slate-500 mt-1">Perlu dicek admin</div>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs">
                <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sedang Diproses</div>
                <div class="text-xl sm:text-2xl font-black text-blue-600 mt-1.5">
                    {{ $stats['processing_orders'] }}
                </div>
                <div class="text-[10px] text-slate-500 mt-1">Total produk aktif: {{ $stats['total_products'] }}</div>
            </div>

        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Pesanan Masuk Terbaru</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar transaksi pesanan terakhir di stand FRUVIT.ID</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                    Buka Semua &rarr;
                </a>
            </div>

            @if($recentOrders->isEmpty())
                <div class="text-center py-8 text-slate-400 text-xs">
                    Belum ada pesanan masuk.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead>
                            <tr class="text-slate-400 uppercase tracking-wider border-b border-slate-100">
                                <th class="pb-3 px-4">No. Order</th>
                                <th class="pb-3 px-4">Pelanggan</th>
                                <th class="pb-3 px-4">Metode</th>
                                <th class="pb-3 px-4">Total</th>
                                <th class="pb-3 px-4">Bayar</th>
                                <th class="pb-3 px-4">Status Pesanan</th>
                                <th class="pb-3 px-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentOrders as $order)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <td class="py-3 px-4 font-mono font-bold text-slate-900">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="text-emerald-600 hover:underline">
                                            {{ $order->order_number }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-bold text-slate-800">{{ $order->customer_name }}</div>
                                        <div class="text-slate-400 text-[10px]">{{ $order->customer_phone }}</div>
                                    </td>
                                    <td class="py-3 px-4 font-medium text-slate-600">
                                        {{ $order->delivery_method === 'delivery' ? '🛵 Delivery' : '🏪 Pickup' }}
                                    </td>
                                    <td class="py-3 px-4 font-black text-slate-900">
                                        {{ $order->formatted_total }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $order->payment_status_color }}">
                                            {{ $order->payment_status_label }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $order->order_status_color }}">
                                            {{ $order->order_status_label }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-2.5 py-1.5 rounded-lg transition">
                                            Kelola
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Store Configuration / Settings Form -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs">
            <div class="pb-4 border-b border-slate-100 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Pengaturan Stand & Pembayaran</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Kelola nomor WhatsApp admin, tarif ongkir, dan status operasional stand FRUVIT.ID.</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-600">Metode Aktif:</span>
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300">QRIS</span>
                    <span class="px-2 py-0.5 rounded-md text-[10px] font-black bg-blue-100 text-blue-800 border border-blue-300">TUNAI / CASH</span>
                </div>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div>
                        <label for="store_status" class="block text-xs font-bold text-slate-700 mb-1.5">Status Stand</label>
                        <select id="store_status" name="store_status" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-300">
                            <option value="open" {{ $settings['store_status'] === 'open' ? 'selected' : '' }}>🟢 Buka (Menerima Pesanan)</option>
                            <option value="closed" {{ $settings['store_status'] === 'closed' ? 'selected' : '' }}>🔴 Tutup / Istirahat</option>
                        </select>
                    </div>

                    <div>
                        <label for="wa_admin" class="block text-xs font-bold text-slate-700 mb-1.5">No. WhatsApp Admin Toko</label>
                        <input type="text" id="wa_admin" name="wa_admin" value="{{ $settings['wa_admin'] }}" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-300" required>
                    </div>

                    <div>
                        <label for="delivery_fee" class="block text-xs font-bold text-slate-700 mb-1.5">Ongkos Kirim Delivery (Rp)</label>
                        <input type="number" id="delivery_fee" name="delivery_fee" value="{{ $settings['delivery_fee'] }}" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-300" required>
                    </div>

                    <div class="sm:col-span-2 lg:col-span-2">
                        <label for="store_address" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lokasi Stand (Pickup)</label>
                        <input type="text" id="store_address" name="store_address" value="{{ $settings['store_address'] }}" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-300" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Preview QRIS Stand</label>
                        <div class="flex items-center gap-3 p-2 bg-slate-50 rounded-xl border border-slate-200">
                            <img src="{{ asset($settings['qris_image']) }}" alt="QRIS" class="w-12 h-12 rounded-lg object-contain bg-white border border-slate-200">
                            <div class="text-[11px]">
                                <div class="font-extrabold text-slate-800">QRIS FRUVIT.ID</div>
                                <div class="text-slate-400 text-[10px]">Aktif untuk semua e-wallet & m-banking</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs px-5 py-3 rounded-xl transition cursor-pointer">
                        Simpan Perubahan Pengaturan
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
