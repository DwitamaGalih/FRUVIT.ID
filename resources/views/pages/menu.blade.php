@extends('layouts.app')

@section('title', 'Daftar Menu & Pesan - FRUVIT.ID')

@section('content')
<div class="py-3 sm:py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <!-- Compact Header & Search Banner -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-3.5 sm:p-6 border border-slate-200/80 shadow-2xs mb-4 sm:mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-6">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-800 text-[10px] sm:text-xs font-black uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                            <span>Fresh Everyday</span>
                        </span>
                        <span class="text-[11px] text-slate-400 font-bold">({{ $products->count() }} Pilihan Menu)</span>
                    </div>
                    <h1 class="text-lg sm:text-2xl font-black text-slate-900 mt-1">Menu Segar FRUVIT.ID</h1>
                </div>

                <!-- Search Input Form (Compact on Mobile) -->
                <form action="{{ route('menu.index') }}" method="GET" class="w-full md:max-w-md">
                    @if($selectedCategory)
                        <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
                    @endif
                    <div class="relative">
                        <input type="text" 
                               name="cari" 
                               value="{{ $search ?? '' }}" 
                               placeholder="Cari salad, susu jelly, melon..." 
                               class="w-full bg-slate-50 border border-slate-300 rounded-xl sm:rounded-2xl py-2 sm:py-2.5 pl-9 sm:pl-10 pr-20 text-xs sm:text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5 sm:top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        
                        <div class="absolute right-1.5 top-1.5 flex items-center gap-1">
                            @if(!empty($search))
                                <a href="{{ route('menu.index', ['kategori' => $selectedCategory]) }}" class="px-1.5 py-1 text-xs text-slate-400 hover:text-slate-600 font-bold">&times;</a>
                            @endif
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] sm:text-xs font-bold px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-lg sm:rounded-xl transition cursor-pointer">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Category Filter Tabs (Horizontal Scroll on Mobile, Sticky feel) -->
            <div class="mt-3.5 sm:mt-5 pt-3 sm:pt-4 border-t border-slate-100 flex items-center gap-1.5 sm:gap-2 overflow-x-auto pb-1 scrollbar-none">
                <a href="{{ route('menu.index', ['cari' => $search]) }}" 
                   class="shrink-0 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl sm:rounded-2xl text-[11px] sm:text-xs font-extrabold transition {{ empty($selectedCategory) || $selectedCategory === 'semua' ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    ✨ Semua
                </a>
                
                @foreach($categories as $category)
                    <a href="{{ route('menu.index', ['kategori' => $category->slug, 'cari' => $search]) }}" 
                       class="shrink-0 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl sm:rounded-2xl text-[11px] sm:text-xs font-extrabold transition flex items-center gap-1.5 {{ $selectedCategory === $category->slug ? 'bg-emerald-600 text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                        <span>{{ $category->icon ?? '🥗' }}</span>
                        <span>{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Products Grid (2-GRID MOBILE CATALOG AS REQUESTED!) -->
        @if($products->isEmpty())
            <div class="text-center py-12 bg-white rounded-2xl sm:rounded-3xl border border-slate-200 p-6">
                <div class="text-4xl mb-2">🔍</div>
                <h3 class="text-sm sm:text-base font-black text-slate-800">Menu Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">Coba kata kunci lain atau pilih kategori di atas.</p>
                <a href="{{ route('menu.index') }}" class="mt-3 inline-flex items-center gap-1 bg-emerald-600 text-white text-xs font-bold px-3 py-1.5 rounded-xl hover:bg-emerald-700 transition">
                    Reset Filter
                </a>
            </div>
        @else
            <!-- grid-cols-2 for mobile, responsive columns on md/lg -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2.5 sm:gap-5">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 overflow-hidden shadow-2xs hover:shadow-lg transition-all duration-200 flex flex-col justify-between group">
                        
                        <!-- Top Image Area -->
                        <div class="relative aspect-square sm:aspect-[4/3] bg-slate-100 overflow-hidden cursor-pointer" 
                             @click="openProductDetail({{ $product->id }})">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <!-- Badges -->
                            @if($product->badge)
                                <span class="absolute top-2 left-2 bg-yellow-400 text-emerald-950 font-black text-[9px] sm:text-[10px] px-2 py-0.5 rounded-md shadow-xs">
                                    {{ $product->badge }}
                                </span>
                            @endif

                            <span class="absolute top-2 right-2 bg-white/90 backdrop-blur-xs text-slate-700 font-bold text-[9px] sm:text-[10px] px-1.5 py-0.5 rounded-md shadow-2xs">
                                {{ $product->category?->name ?? 'Menu' }}
                            </span>
                        </div>

                        <!-- Details Area (Dense & Clear on Mobile 2-Grid) -->
                        <div class="p-2.5 sm:p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900 group-hover:text-emerald-700 transition cursor-pointer line-clamp-2 leading-snug"
                                    @click="openProductDetail({{ $product->id }})">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-[10px] sm:text-xs text-slate-400 mt-1 line-clamp-1 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>

                            <!-- Price & Quick Add Button Row -->
                            <div class="mt-2.5 sm:mt-4 pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-1.5">
                                <div class="truncate">
                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider hidden sm:block">Harga</span>
                                    <span class="text-xs sm:text-base font-black text-emerald-600 block truncate">{{ $product->formatted_price }}</span>
                                </div>

                                <div class="flex items-center gap-1 shrink-0">
                                    <button type="button"
                                            @click="openProductDetail({{ $product->id }})"
                                            class="w-7 h-7 sm:w-auto sm:h-auto sm:px-3 sm:py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-extrabold text-xs flex items-center justify-center gap-1 shadow-xs hover:shadow-md transition active:scale-90 cursor-pointer"
                                            title="Pilih & Atur Menu">
                                        <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                        <span class="hidden sm:inline">Pesan</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
