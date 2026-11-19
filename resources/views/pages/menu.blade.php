@extends('layouts.app')

@section('title', 'Our Menu - FRUVIT.ID')

@section('content')
<div class="py-4 sm:py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <!-- Header & Search Banner -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-7 border border-slate-200/80 shadow-2xs mb-5 sm:mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 sm:gap-6">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] sm:text-xs font-bold border border-blue-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                            <span>Fresh Everyday</span>
                        </span>
                        <span class="text-xs text-slate-400 font-medium">({{ $products->count() }} Pilihan Menu)</span>
                    </div>
                    <h1 class="text-xl sm:text-3xl font-extrabold text-slate-900 mt-1.5 tracking-tight">Our Menu</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Pilihan salad buah segar, susu jelly manis creamy, dan buah potong dingin.</p>
                </div>

                <!-- Search Input Form -->
                <form action="{{ route('menu.index') }}" method="GET" class="w-full md:max-w-md">
                    @if($selectedCategory)
                        <input type="hidden" name="kategori" value="{{ $selectedCategory }}">
                    @endif
                    <div class="relative">
                        <input type="text" 
                               name="cari" 
                               value="{{ $search ?? '' }}" 
                               placeholder="Cari salad, susu jelly, buah potong..." 
                               class="w-full bg-slate-50 border border-slate-200 rounded-xl sm:rounded-2xl py-2.5 sm:py-3 pl-10 pr-20 text-xs sm:text-sm font-medium focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3.5 top-3.5 sm:top-4 text-xs"></i>
                        
                        <div class="absolute right-1.5 top-1.5 flex items-center gap-1">
                            @if(!empty($search))
                                <a href="{{ route('menu.index', ['kategori' => $selectedCategory]) }}" class="px-2 py-1 text-xs text-slate-400 hover:text-slate-600 font-bold cursor-pointer">
                                    <i class="fa-solid fa-xmark"></i>
                                </a>
                            @endif
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg sm:rounded-xl transition cursor-pointer">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Category Filter Tabs -->
            <div class="mt-4 sm:mt-6 pt-3 sm:pt-4 border-t border-slate-100 flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
                <a href="{{ route('menu.index', ['cari' => $search]) }}" 
                   class="shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold transition {{ empty($selectedCategory) || $selectedCategory === 'semua' ? 'bg-blue-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                    Semua Menu
                </a>
                
                @foreach($categories as $category)
                    <a href="{{ route('menu.index', ['kategori' => $category->slug, 'cari' => $search]) }}" 
                       class="shrink-0 px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $selectedCategory === $category->slug ? 'bg-blue-600 text-white shadow-2xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                        <span>{{ $category->icon ?? '🥗' }}</span>
                        <span>{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Products Grid (2-Column Mobile, 3-4 Desktop) -->
        @if($products->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl sm:rounded-3xl border border-slate-200 p-8 max-w-md mx-auto">
                <div class="w-16 h-16 mx-auto mb-3 flex items-center justify-center rounded-2xl bg-blue-50 text-blue-600 text-2xl">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900">Menu Tidak Ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">Coba kata kunci pencarian lain atau pilih kategori menu di atas.</p>
                <a href="{{ route('menu.index') }}" class="mt-4 inline-flex items-center gap-2 bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-xl hover:bg-blue-700 transition">
                    <i class="fa-solid fa-rotate-left text-xs"></i>
                    <span>Reset Filter</span>
                </a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                @foreach($products as $product)
                    @php
                        $isSoldOut = $product->is_sold_out;
                    @endphp
                    <div class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-2xs transition-all duration-200 flex flex-col justify-between group {{ $isSoldOut ? 'opacity-85' : 'hover:border-blue-200 hover:shadow-md' }}">
                        
                        <!-- Top Image Area -->
                        <div class="relative aspect-square bg-slate-50 overflow-hidden {{ $isSoldOut ? 'cursor-not-allowed' : 'cursor-pointer' }}" 
                             @if(! $isSoldOut) @click="openProductDetail({{ $product->id }})" @endif>
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover {{ $isSoldOut ? 'grayscale contrast-75 brightness-95' : 'group-hover:scale-105 transition-transform duration-300' }}">
                            
                            <!-- Badges -->
                            @if($isSoldOut)
                                <div class="absolute inset-0 bg-slate-950/25 backdrop-blur-[1.5px] flex items-center justify-center p-2 text-center">
                                    <span class="inline-flex items-center gap-1.5 bg-rose-600/95 text-white font-black text-[10px] sm:text-xs px-2.5 sm:px-3 py-1 rounded-full shadow-md tracking-wider uppercase">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                        <span>Habis</span>
                                    </span>
                                </div>
                            @elseif($product->badge)
                                <span class="absolute top-2.5 left-2.5 bg-yellow-400 text-slate-900 font-bold text-[9px] sm:text-[10px] px-2 py-0.5 rounded-md shadow-xs">
                                    {{ $product->badge }}
                                </span>
                            @endif

                            <span class="absolute top-2.5 right-2.5 bg-white/90 backdrop-blur-xs text-slate-700 font-semibold text-[9px] sm:text-[10px] px-2 py-0.5 rounded-md shadow-2xs border border-slate-100">
                                {{ $product->category?->name ?? 'Menu' }}
                            </span>
                        </div>

                        <!-- Details Area -->
                        <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-start justify-between gap-1">
                                    <h3 class="text-xs sm:text-sm font-bold {{ $isSoldOut ? 'text-slate-500' : 'text-slate-900 group-hover:text-blue-600 cursor-pointer' }} line-clamp-2 leading-snug"
                                        @if(! $isSoldOut) @click="openProductDetail({{ $product->id }})" @endif>
                                        {{ $product->name }}
                                    </h3>
                                </div>
                                <p class="text-[10px] sm:text-xs text-slate-400 mt-1 line-clamp-1 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                                
                                <!-- Sisa Stok Badge di Katalog -->
                                <div class="mt-2 flex items-center gap-1.5">
                                    @if($isSoldOut)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-rose-50 text-rose-700 font-bold text-[9px] sm:text-[10px] border border-rose-200">
                                            <span>✕ Stok Habis</span>
                                        </span>
                                    @elseif($product->stock <= 5)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 text-amber-700 font-bold text-[9px] sm:text-[10px] border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            <span>Sisa {{ $product->stock }} porsi</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-medium text-[9px] sm:text-[10px] border border-slate-200">
                                            <span>Stok: {{ $product->stock }}</span>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Price & Order Button Row -->
                            <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between gap-1.5">
                                <div class="truncate">
                                    <span class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider hidden sm:block">Harga</span>
                                    <span class="text-xs sm:text-sm font-black {{ $isSoldOut ? 'text-slate-400' : 'text-blue-600' }} block truncate">{{ $product->formatted_price }}</span>
                                </div>

                                @if($isSoldOut)
                                    <button type="button"
                                            disabled
                                            class="h-7 px-2.5 sm:h-8 sm:px-3 rounded-lg sm:rounded-xl bg-slate-100 text-slate-400 font-bold text-xs flex items-center justify-center gap-1.5 cursor-not-allowed select-none"
                                            title="Stok menu saat ini sedang habis">
                                        <i class="fa-solid fa-ban text-[11px]"></i>
                                        <span>Habis</span>
                                    </button>
                                @else
                                    <button type="button"
                                            @click="openProductDetail({{ $product->id }})"
                                            class="h-7 px-2.5 sm:h-8 sm:px-3 rounded-lg sm:rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs flex items-center justify-center gap-1.5 shadow-2xs transition active:scale-95 cursor-pointer"
                                            title="Pilih & Atur Menu">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                        <span class="hidden sm:inline">Pesan</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection