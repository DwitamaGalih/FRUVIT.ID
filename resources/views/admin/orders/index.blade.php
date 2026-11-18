@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Admin FRUVIT.ID')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Kelola Pesanan Pelanggan</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau pesanan masuk, verifikasi bukti transfer, dan perbarui proses pengiriman.</p>
            </div>
        </div>

        <!-- Filter Tabs & Search Bar -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs space-y-4">
            
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none text-xs font-bold">
                <a href="{{ route('admin.orders.index', ['status' => 'all', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition flex-shrink-0 {{ $status === 'all' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    Semua ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'pending_verification', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition flex-shrink-0 {{ $status === 'pending_verification' ? 'bg-amber-600 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}">
                    Perlu Verifikasi Bukti ({{ $counts['pending_verification'] }})
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'unpaid', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition flex-shrink-0 {{ $status === 'unpaid' ? 'bg-rose-600 text-white' : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                    Belum Bayar ({{ $counts['unpaid'] }})
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'processing', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition flex-shrink-0 {{ $status === 'processing' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-700 hover:bg-blue-100' }}">
                    Sedang Diproses ({{ $counts['processing'] }})
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'ready', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition flex-shrink-0 {{ $status === 'ready' ? 'bg-purple-600 text-white' : 'bg-purple-50 text-purple-700 hover:bg-purple-100' }}">
                    Siap / Dikirim ({{ $counts['ready'] }})
                </a>
                <a href="{{ route('admin.orders.index', ['status' => 'completed', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition flex-shrink-0 {{ $status === 'completed' ? 'bg-emerald-600 text-white' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                    Selesai ({{ $counts['completed'] }})
                </a>
            </div>

            <form action="{{ route('admin.orders.index') }}" method="GET" class="relative max-w-md">
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Cari Order ID, Nama Pembeli, atau No WA..." 
                       class="w-full text-xs px-4 py-2.5 pl-10 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs">
            @if($orders->isEmpty())
                <div class="text-center py-12 text-slate-400 text-xs">
                    Tidak ada data pesanan pada filter ini.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px]">
                            <tr>
                                <th class="py-3 px-4 rounded-l-xl">Order ID & Waktu</th>
                                <th class="py-3 px-4">Pelanggan</th>
                                <th class="py-3 px-4">Item Pesanan</th>
                                <th class="py-3 px-4">Metode</th>
                                <th class="py-3 px-4">Total</th>
                                <th class="py-3 px-4">Bayar</th>
                                <th class="py-3 px-4">Status</th>
                                <th class="py-3 px-4 rounded-r-xl text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($orders as $order)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4">
                                        <div class="font-mono font-bold text-slate-900">{{ $order->order_number }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-bold text-slate-800">{{ $order->customer_name }}</div>
                                        <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $order->customer_phone)) }}" 
                                           target="_blank" 
                                           class="text-emerald-600 hover:underline text-[10px] flex items-center gap-1 font-semibold">
                                            <span>💬 {{ $order->customer_phone }}</span>
                                        </a>
                                    </td>
                                    <td class="py-3 px-4 max-w-xs">
                                        <div class="text-slate-600 truncate">
                                            {{ $order->items->pluck('product_name')->join(', ') }}
                                        </div>
                                        <div class="text-[10px] text-slate-400">{{ $order->items->sum('quantity') }} porsi</div>
                                    </td>
                                    <td class="py-3 px-4 text-slate-600 font-medium">
                                        <div>{{ $order->delivery_method === 'delivery' ? '🛵 Delivery' : '🏪 Pickup' }}</div>
                                        <div class="text-[10px] text-slate-400 uppercase">{{ $order->payment_method }}</div>
                                    </td>
                                    <td class="py-3 px-4 font-black text-slate-900">
                                        {{ $order->formatted_total }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $order->payment_status_color }}">
                                            {{ $order->payment_status_label }}
                                        </span>
                                        @if($order->payment_proof)
                                            <span class="block text-[9px] text-blue-600 font-bold mt-0.5">Ada Bukti Foto</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold border {{ $order->order_status_color }}">
                                            {{ $order->order_status_label }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right space-x-2">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-2.5 py-1.5 rounded-lg transition inline-block">
                                            Kelola
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
