@extends('layouts.app')

@section('title', 'FRUVIT.ID - Segar Buahnya, Nikmat Rasanya | Pesan Salad Buah & Susu Jelly')

@section('content')
<!-- Hero Section (Mobile-First Sleek App Layout) -->
<section class="relative bg-gradient-to-b from-emerald-50/70 via-white to-slate-50 pt-3 pb-6 sm:pt-10 sm:pb-16 border-b border-emerald-100/50">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <!-- Mobile Quick Search & Greeting Bar (Dense & App-like) -->
        <div class="md:hidden mb-3.5 space-y-2.5">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-[11px] font-bold text-slate-400">Selamat Datang di</div>
                    <div class="text-lg font-black text-slate-900 tracking-tight">FRUVIT<span class="text-emerald-600">.ID</span> 🍓</div>
                </div>
                <div class="flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black uppercase">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                    <span>Stand Buka</span>
                </div>
            </div>

            <!-- Mobile Quick Search Input -->
            <form action="{{ route('menu.index') }}" method="GET" class="relative">
                <input type="text" 
                       name="cari" 
                       placeholder="Cari salad buah, susu jelly pisang, melon..." 
                       class="w-full bg-white border border-slate-200/90 rounded-2xl py-2.5 pl-10 pr-20 text-xs font-medium shadow-xs focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <button type="submit" class="absolute right-1.5 top-1.5 bg-emerald-600 text-white font-bold text-[10px] px-3 py-1.5 rounded-xl">
                    Cari
                </button>
            </form>
        </div>

        <!-- Hero Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-12 items-center">
            
            <!-- Left Hero Content (Desktop & Tablet) -->
            <div class="lg:col-span-7 space-y-4 sm:space-y-6 text-left">
                <div class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-emerald-100/80 border border-emerald-300 text-emerald-800 text-xs font-black uppercase tracking-wider shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Kewirausahaan Mahasiswa • Fresh Daily</span>
                </div>

                <h1 class="hidden sm:block text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-[1.15]">
                    Pesan Camilan Sehat & Segar <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 via-green-600 to-lime-600">FRUVIT.ID</span>
                </h1>

                <p class="hidden sm:block text-base sm:text-lg text-slate-600 max-w-xl font-medium leading-relaxed">
                    Nikmati sensasi kelezatan <span class="text-emerald-700 font-bold">Salad Buah Creamy Cheese</span>, minuman <span class="text-amber-600 font-bold">Susu Jelly segar</span>, dan <span class="text-rose-600 font-bold">Buah Potong dingin higienis</span>. Pesan cepat tanpa ribet!
                </p>

                <!-- Desktop Action CTA Buttons -->
                <div class="hidden sm:flex items-center gap-3.5 pt-2">
                    <a href="{{ route('menu.index') }}" 
                       class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-black text-base px-8 py-4 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 cursor-pointer">
                        <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span>Pesan Menu Sekarang</span>
                    </a>
                    
                    <a href="{{ route('order.track') }}" 
                       class="inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border-2 border-slate-200 font-bold text-base px-6 py-4 rounded-2xl shadow-xs transition hover:border-emerald-400">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span>Cek Status Pesanan</span>
                    </a>
                </div>

                <!-- Trust Badges Desktop -->
                <div class="hidden sm:grid grid-cols-3 gap-4 pt-6 border-t border-slate-200/80 max-w-lg">
                    <div>
                        <div class="text-xl font-black text-slate-900">100%</div>
                        <div class="text-xs text-slate-500 font-semibold">Buah Segar Pilihan</div>
                    </div>
                    <div>
                        <div class="text-xl font-black text-slate-900">Rp 10k+</div>
                        <div class="text-xs text-slate-500 font-semibold">Harga Mahasiswa</div>
                    </div>
                    <div>
                        <div class="text-xl font-black text-slate-900">QRIS / COD</div>
                        <div class="text-xs text-slate-500 font-semibold">Metode Bayar Lengkap</div>
                    </div>
                </div>
            </div>

            <!-- Right Hero Promo Banner Card (Compact aspect ratio on mobile) -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto w-full">
                    
                    <div class="relative bg-white rounded-2xl sm:rounded-3xl p-2 sm:p-3 shadow-md sm:shadow-2xl border-2 sm:border-4 border-white ring-1 ring-slate-200/80 overflow-hidden">
                        <div class="relative rounded-xl sm:rounded-2xl overflow-hidden aspect-[16/8] sm:aspect-square">
                            <img src="{{ asset('images/banner-promo.jpg') }}" alt="FRUVIT.ID Open Order" class="w-full h-full object-cover">
                            
                            <!-- Floating Tag Badge -->
                            <div class="absolute top-2.5 left-2.5 sm:top-4 sm:left-4 bg-emerald-600/95 backdrop-blur-md text-white text-[10px] sm:text-xs font-black px-2.5 py-1 sm:px-3.5 sm:py-1.5 rounded-full shadow-lg flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-yellow-300"></span>
                                <span>OPEN ORDER HARI INI</span>
                            </div>

                            <div class="absolute bottom-2 inset-x-2 sm:bottom-4 sm:inset-x-4 bg-slate-900/85 backdrop-blur-md rounded-xl sm:rounded-2xl p-2 sm:p-3 text-white flex items-center justify-between gap-2">
                                <div class="truncate">
                                    <div class="text-[9px] sm:text-[11px] text-yellow-300 font-black uppercase tracking-wider">Promo Spesial</div>
                                    <div class="text-[11px] sm:text-xs font-extrabold truncate">Salad Buah • Susu Jelly • Buah Potong</div>
                                </div>
                                <a href="{{ route('menu.index') }}" class="bg-yellow-400 hover:bg-yellow-300 text-slate-950 font-black text-[10px] sm:text-xs px-2.5 py-1.5 sm:px-3 sm:py-1.5 rounded-lg sm:rounded-xl shrink-0 transition">
                                    Pesan
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Mobile Quick Features Strip (Ultra Compact) -->
        <div class="sm:hidden grid grid-cols-3 gap-2 mt-3 pt-3 border-t border-slate-200/60 text-center">
            <div class="bg-white/80 p-2 rounded-xl border border-slate-200/60 shadow-2xs">
                <div class="text-xs">🍓</div>
                <div class="text-[10px] font-black text-slate-800 mt-0.5">100% Segar</div>
                <div class="text-[9px] text-slate-400">Buah pilihan</div>
            </div>
            <div class="bg-white/80 p-2 rounded-xl border border-slate-200/60 shadow-2xs">
                <div class="text-xs">💰</div>
                <div class="text-[10px] font-black text-slate-800 mt-0.5">Mulai 10 Ribu</div>
                <div class="text-[9px] text-slate-400">Hemat & kenyang</div>
            </div>
            <div class="bg-white/80 p-2 rounded-xl border border-slate-200/60 shadow-2xs">
                <div class="text-xs">📲</div>
                <div class="text-[10px] font-black text-slate-800 mt-0.5">QRIS & Cash</div>
                <div class="text-[9px] text-slate-400">Pickup & delivery</div>
            </div>
        </div>

    </div>
</section>

<!-- Categories Section (Horizontal Scroll on Mobile to Save Vertical Space) -->
<section class="py-4 sm:py-10 bg-white border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-2.5 sm:mb-6">
            <div>
                <span class="text-[10px] sm:text-xs font-black text-emerald-600 uppercase tracking-widest">Kategori Pilihan</span>
                <h2 class="text-base sm:text-2xl font-black text-slate-900 leading-tight">Pilihan Menu Favorit</h2>
            </div>
            <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-sm font-bold text-emerald-600 hover:text-emerald-700 transition">
                <span>Semua</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <!-- Horizontal Scrollable Categories on Mobile, Grid on Tablet/Desktop -->
        <div class="flex sm:grid sm:grid-cols-4 gap-2.5 sm:gap-6 overflow-x-auto pb-1 sm:pb-0 scrollbar-none">
            @foreach($categories as $category)
                <a href="{{ route('menu.index', ['kategori' => $category->slug]) }}" 
                   class="shrink-0 w-28 sm:w-auto bg-slate-50 hover:bg-emerald-50/70 border border-slate-200/80 hover:border-emerald-300 rounded-2xl sm:rounded-3xl p-2.5 sm:p-5 transition-all flex flex-col justify-between hover:shadow-xs group">
                    <div class="flex items-center justify-between">
                        <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-white shadow-2xs border border-slate-200/80 flex items-center justify-center text-lg sm:text-2xl group-hover:scale-110 transition-transform">
                            {{ $category->icon ?? '🥗' }}
                        </div>
                        <span class="text-[9px] sm:text-xs font-extrabold text-slate-500 bg-white px-1.5 py-0.5 rounded-full border border-slate-200 group-hover:bg-emerald-600 group-hover:text-white transition">
                            {{ $category->products_count }}
                        </span>
                    </div>
                    <div class="mt-2.5">
                        <h3 class="text-xs sm:text-base font-extrabold text-slate-900 group-hover:text-emerald-700 transition truncate">
                            {{ $category->name }}
                        </h3>
                        <p class="hidden sm:block text-xs text-slate-500 mt-1 line-clamp-1 leading-relaxed">
                            {{ $category->description }}
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>

<!-- Best Seller Section (2-GRID MOBILE CATALOG AS REQUESTED!) -->
<section class="py-5 sm:py-14 bg-slate-50">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <div class="flex items-end justify-between mb-3.5 sm:mb-8">
            <div>
                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-yellow-400 text-emerald-950 text-[10px] sm:text-xs font-black uppercase tracking-wider mb-1">
                    <span>🔥</span>
                    <span>Paling Laris</span>
                </span>
                <h2 class="text-lg sm:text-3xl font-black text-slate-900">Produk Unggulan</h2>
            </div>
            <a href="{{ route('menu.index') }}" class="text-[11px] sm:text-sm font-bold text-emerald-700 hover:text-emerald-800">
                Lihat Semua &rarr;
            </a>
        </div>

        <!-- 2 GRID CATALOG LAYOUT ON MOBILE (grid-cols-2) -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2.5 sm:gap-5">
            @foreach($bestSellers as $product)
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
                                        class="hidden sm:inline-flex p-2 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 transition text-xs"
                                        title="Detail Produk">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </button>
                                
                                <button type="button"
                                        @click="quickAddToCart({{ $product->id }})"
                                        class="w-7 h-7 sm:w-auto sm:h-auto sm:px-3 sm:py-2 rounded-xl bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-extrabold text-xs flex items-center justify-center gap-1 shadow-xs hover:shadow-md transition active:scale-90 cursor-pointer"
                                        title="Tambah ke Keranjang">
                                    <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                    <span class="hidden sm:inline">Tambah</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('menu.index') }}" 
               class="inline-flex items-center gap-1.5 bg-white hover:bg-emerald-50 text-emerald-700 border border-emerald-400 font-extrabold text-xs sm:text-sm px-5 py-2.5 sm:px-6 sm:py-3.5 rounded-xl sm:rounded-2xl transition shadow-xs">
                <span>Buka Seluruh Katalog Menu &rarr;</span>
            </a>
        </div>
    </div>
</section>

<!-- Compact Ordering Steps Section -->
<section class="py-6 sm:py-12 bg-white border-t border-slate-200/70">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-4 sm:mb-8">
            <span class="text-[10px] sm:text-xs font-black text-emerald-600 uppercase tracking-widest">Praktis & Cepat</span>
            <h2 class="text-base sm:text-2xl font-black text-slate-900 mt-0.5">Alur Pemesanan Mudah</h2>
        </div>

        <!-- 2x2 grid on mobile for compact layout -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-2.5 sm:gap-5 text-center">
            <div class="bg-slate-50 rounded-2xl p-3 sm:p-5 border border-slate-200/80">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-600 text-white rounded-xl flex items-center justify-center font-black text-xs sm:text-sm mx-auto mb-2 shadow-xs">
                    1
                </div>
                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Pilih Menu</h3>
                <p class="text-[10px] sm:text-xs text-slate-500 mt-1 line-clamp-2">Pilih salad buah atau minuman segar.</p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-3 sm:p-5 border border-slate-200/80">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-600 text-white rounded-xl flex items-center justify-center font-black text-xs sm:text-sm mx-auto mb-2 shadow-xs">
                    2
                </div>
                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Keranjang</h3>
                <p class="text-[10px] sm:text-xs text-slate-500 mt-1 line-clamp-2">Tentukan jumlah & catatan khusus.</p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-3 sm:p-5 border border-slate-200/80">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-emerald-600 text-white rounded-xl flex items-center justify-center font-black text-xs sm:text-sm mx-auto mb-2 shadow-xs">
                    3
                </div>
                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Checkout</h3>
                <p class="text-[10px] sm:text-xs text-slate-500 mt-1 line-clamp-2">Pilih Pickup atau Delivery kampus.</p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-3 sm:p-5 border border-slate-200/80">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-yellow-400 text-emerald-950 rounded-xl flex items-center justify-center font-black text-xs sm:text-sm mx-auto mb-2 shadow-xs">
                    4
                </div>
                <h3 class="text-xs sm:text-sm font-extrabold text-slate-900">Bayar & Ambil</h3>
                <p class="text-[10px] sm:text-xs text-slate-500 mt-1 line-clamp-2">Bayar via QRIS / Cash & nikmati!</p>
            </div>
        </div>
    </div>
</section>

<!-- Banner Order Stand / Pickup Info (Compact on mobile) -->
<section class="py-6 sm:py-10 bg-gradient-to-r from-emerald-800 to-green-700 text-white">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div>
                <span class="inline-block bg-yellow-400 text-emerald-950 text-[9px] sm:text-[11px] font-black px-2 py-0.5 rounded-md uppercase mb-1">
                    Stand Kewirausahaan
                </span>
                <h2 class="text-base sm:text-2xl font-black">Pesan Online, Ambil di Stand Tanpa Antre</h2>
                <p class="text-emerald-100 text-xs sm:text-sm max-w-xl mt-0.5">
                    Buah dingin dan segar selalu siap tepat waktu untuk Anda nikmati.
                </p>
            </div>
            <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-1.5 bg-yellow-400 hover:bg-yellow-300 text-emerald-950 font-black text-xs sm:text-sm px-4 py-2.5 sm:px-6 sm:py-3.5 rounded-xl sm:rounded-2xl shadow-md transition active:scale-95 shrink-0">
                <span>Pesan Sekarang</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>
@endsection
