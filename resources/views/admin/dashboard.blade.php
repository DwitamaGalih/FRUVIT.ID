@extends('layouts.admin')

@section('title', 'Dashboard Pengelola - FRUVIT.ID')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Welcome Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Dashboard Pengelola FRUVIT.ID</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau penjualan, verifikasi pembayaran masuk, dan kelola pesanan pelanggan.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.index') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition">
                    Lihat Semua Pesanan
                </a>
                <a href="{{ route('admin.products.create') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition">
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
                <div class="text-[10px] text-slate-500 mt-1">Siap disiapkan di stand</div>
            </div>

        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <h2 class="text-base font-extrabold text-slate-900">Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua &rarr;</a>
            </div>

            @if($recentOrders->isEmpty())
                <div class="text-center py-8 text-xs text-slate-400">
                    Belum ada pesanan yang masuk.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px]">
                            <tr>
                                <th class="py-3 px-4 rounded-l-xl">Order ID</th>
                                <th class="py-3 px-4">Pemesan</th>
                                <th class="py-3 px-4">Metode</th>
                                <th class="py-3 px-4">Total</th>
                                <th class="py-3 px-4">Bayar</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 rounded-r-xl text-right">Aksi</th>
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
            <div class="pb-4 border-b border-slate-100 mb-6">
                <h2 class="text-base font-extrabold text-slate-900">Pengaturan Toko & Kontak</h2>
                <p class="text-xs text-slate-500 mt-0.5">Kelola informasi rekening, nomor WhatsApp admin, dan status operasional stand.</p>
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

                    <div class="sm:col-span-2 lg:col-span-3">
                        <label for="store_address" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Lokasi Stand</label>
                        <input type="text" id="store_address" name="store_address" value="{{ $settings['store_address'] }}" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-300" required>
                    </div>

                    <!-- Bank Accounts -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Rekening BCA</label>
                        <input type="text" name="bank_bca_number" value="{{ $settings['bank_bca_number'] }}" placeholder="Nomor Rekening" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-300 mb-1.5">
                        <input type="text" name="bank_bca_name" value="{{ $settings['bank_bca_name'] }}" placeholder="Atas Nama" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-300">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Rekening Mandiri</label>
                        <input type="text" name="bank_mandiri_number" value="{{ $settings['bank_mandiri_number'] }}" placeholder="Nomor Rekening" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-300 mb-1.5">
                        <input type="text" name="bank_mandiri_name" value="{{ $settings['bank_mandiri_name'] }}" placeholder="Atas Nama" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-300">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Rekening BRI</label>
                        <input type="text" name="bank_bri_number" value="{{ $settings['bank_bri_number'] }}" placeholder="Nomor Rekening" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-300 mb-1.5">
                        <input type="text" name="bank_bri_name" value="{{ $settings['bank_bri_name'] }}" placeholder="Atas Nama" class="w-full text-xs px-3 py-2 rounded-xl border border-slate-300">
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
