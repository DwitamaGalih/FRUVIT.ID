@extends('layouts.app')

@section('title', 'Lacak Status Pesanan - FRUVIT.ID')

@section('content')
<div class="py-5 sm:py-10 bg-slate-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <div class="text-center mb-5 sm:mb-8">
            <div class="w-14 h-14 sm:w-16 sm:h-16 mx-auto mb-3 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl sm:text-3xl border border-blue-100 shadow-2xs">
                🔍
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">Lacak Status Pesanan</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                Ketik Nomor Pesanan (<span class="font-mono font-bold text-slate-700">FRV-XXXX</span>) atau No. WhatsApp saat memesan.
            </p>
        </div>

        <!-- Search Form Card -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs mb-5 sm:mb-8">
            <form action="{{ route('order.track') }}" method="GET" class="space-y-3">
                <div class="relative">
                    <input type="text" 
                           id="q" 
                           name="q" 
                           value="{{ $keyword }}" 
                           required
                           placeholder="Contoh: FRV-261117-0012 atau 081234567890" 
                           class="w-full text-xs sm:text-sm px-4 py-3 pl-10 rounded-xl sm:rounded-2xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm py-3 px-4 rounded-xl sm:rounded-2xl shadow-xs hover:shadow-md transition cursor-pointer flex items-center justify-center gap-2 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span>Cari & Lacak Pesanan</span>
                </button>
            </form>
        </div>

        <!-- Search Results -->
        @if(!empty($keyword))
            @if($orders->isEmpty())
                <div class="text-center py-10 bg-white rounded-2xl sm:rounded-3xl border border-slate-200 p-6">
                    <div class="text-3xl mb-2">📦❌</div>
                    <h3 class="text-sm font-bold text-slate-800">Pesanan Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">
                        Tidak ada data pesanan dengan kata kunci "<span class="font-bold text-slate-700">{{ $keyword }}</span>".
                    </p>
                </div>
            @else
                <div class="space-y-3">
                    <h2 class="text-xs font-bold uppercase text-slate-400 tracking-wider">
                        Hasil Pencarian ({{ $orders->count() }} Pesanan)
                    </h2>

                    @foreach($orders as $order)
                        <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5 shadow-2xs hover:border-blue-200 transition">
                            <div class="flex items-center justify-between gap-2 pb-3 border-b border-slate-100">
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-xs font-mono font-bold text-slate-900">{{ $order->order_number }}</span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-md {{ $order->payment_status_color }} border">
                                            {{ $order->payment_status_label }}
                                        </span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 rounded-md {{ $order->order_status_color }} border">
                                            {{ $order->order_status_label }}
                                        </span>
                                    </div>
                                    <div class="text-[10px] text-slate-400 mt-1">
                                        {{ $order->created_at->format('d M Y, H:i') }} WIB • {{ $order->customer_name }}
                                    </div>
                                </div>

                                <div class="text-right shrink-0">
                                    <div class="text-xs sm:text-sm font-black text-blue-600">{{ $order->formatted_total }}</div>
                                </div>
                            </div>

                            <div class="pt-3 flex items-center justify-between gap-2">
                                <div class="text-xs text-slate-500 truncate max-w-[200px] sm:max-w-xs">
                                    {{ $order->items->pluck('product_name')->join(', ') }}
                                </div>
                                
                                <a href="{{ route('order.show', $order->order_number) }}" class="inline-flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3.5 py-1.5 rounded-xl transition shrink-0 active:scale-95">
                                    <span>Detail</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif

    </div>
</div>
@endsection
