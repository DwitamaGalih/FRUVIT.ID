@extends('layouts.app')

@section('title', 'FRUVIT.ID - Fresh Fruit, Better Mood! | Pesan Salad Buah & Susu Jelly')

@section('content')
<!-- Hero Section (Fresh Blue Minimalist) -->
<section class="relative bg-gradient-to-b from-blue-50/70 via-white to-slate-50 pt-5 pb-8 sm:pt-14 sm:pb-20 border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-12 items-center">
            
            <!-- Hero Content -->
            <div class="lg:col-span-7 flex flex-col text-left space-y-3.5 sm:space-y-5">
                
                <!-- Badge -->
                <div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 border border-blue-200/80 text-blue-700 text-[11px] sm:text-xs font-bold tracking-wide">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                        <span>100% Buah Segar • Fresh Fruit, Better Mood!</span>
                    </span>
                </div>

                <!-- Headline & Subtitle -->
                <div class="space-y-1.5 sm:space-y-3">
                    <h1 class="text-2xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight sm:leading-[1.15]">
                        Fresh Fruit,<br class="hidden sm:inline">
                        <span class="text-blue-600">Better Mood!</span>
                    </h1>

                    <p class="text-xs sm:text-base text-slate-600 max-w-xl font-normal leading-relaxed">
                        Nikmati kelezatan <strong>Salad Buah Creamy Cheese</strong> keju melimpah, kesegaran <strong>Susu Jelly</strong> dingin nikmat, dan <strong>Buah Potong</strong> segar higienis. Pesan praktis, cepat, dan higienis.
                    </p>
                </div>

                <!-- Action CTA Buttons -->
                <div class="flex items-center gap-2.5 pt-1">
                    <a href="{{ route('menu.index') }}" 
                       class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm px-5 py-3 sm:py-3.5 rounded-xl shadow-xs hover:shadow-md transition active:scale-95 cursor-pointer">
                        <span>Lihat Menu</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    
                    <a href="{{ route('order.track') }}" 
                       class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-2 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 font-bold text-xs sm:text-sm px-4 py-3 sm:py-3.5 rounded-xl transition hover:border-blue-300">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        <span>Cek Pesanan</span>
                    </a>
                </div>

                <!-- Value Highlights / Trust Card (Di bawah CTA, di atas Open Order Card) -->
                <div class="bg-white rounded-xl sm:rounded-2xl border border-slate-200/80 p-2.5 sm:p-4 shadow-2xs">
                    <div class="grid grid-cols-3 divide-x divide-slate-100 text-center items-center">
                        <div class="px-1.5 sm:px-3">
                            <span class="block text-xs sm:text-lg font-black text-slate-900 tracking-tight">100%</span>
                            <span class="block text-[9px] sm:text-xs text-slate-500 font-semibold leading-tight mt-0.5">Buah Segar Pilihan</span>
                        </div>
                        <div class="px-1.5 sm:px-3">
                            <span class="block text-xs sm:text-lg font-black text-slate-900 tracking-tight">Mulai 10k</span>
                            <span class="block text-[9px] sm:text-xs text-slate-500 font-semibold leading-tight mt-0.5">Harga Bersahabat</span>
                        </div>
                        <div class="px-1.5 sm:px-3">
                            <span class="block text-xs sm:text-lg font-black text-blue-600 tracking-tight">QRIS / Cash</span>
                            <span class="block text-[9px] sm:text-xs text-slate-500 font-semibold leading-tight mt-0.5">Pickup & Delivery</span>
                        </div>
                    </div>
                </div>

                <!-- Visual Promo Banner for Mobile (Open Order Card) -->
                <div class="block lg:hidden">
                    <div class="relative bg-white rounded-2xl p-2 shadow-xs border border-slate-200/80 overflow-hidden">
                        <!-- OPEN ORDER Badge -->
                        <div class="absolute top-4 left-4 z-10">
                            <span class="inline-flex items-center gap-1.5 bg-blue-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                                OPEN ORDER
                            </span>
                        </div>
                        <div class="relative rounded-xl overflow-hidden aspect-square bg-slate-50 flex items-center justify-center">
                            <img src="{{ asset('images/banner-promo.jpg') }}" alt="FRUVIT.ID Open Order" class="w-full h-full object-contain rounded-lg">
                        </div>
                        <!-- Menu Spesial Footer -->
                        <div class="flex items-center justify-between px-1 pt-2 pb-0.5">
                            <div>
                                <span class="block text-[9px] text-blue-600 font-bold uppercase tracking-wider">Menu Spesial</span>
                                <span class="block text-xs font-bold text-slate-800 leading-tight">Salad Buah • Susu Jelly • Buah Potong</span>
                            </div>
                            <a href="{{ route('menu.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg transition active:scale-95 shrink-0">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Hero Visual Promo Card (Desktop Only - Fit to Card, Tidak Terpotong) -->
            <div class="hidden lg:block lg:col-span-5 relative">
                <div class="relative bg-white rounded-3xl p-3 shadow-md border border-slate-200/80 overflow-hidden">
                    <div class="relative rounded-2xl overflow-hidden aspect-square bg-slate-50 flex items-center justify-center">
                        <img src="{{ asset('images/banner-promo.jpg') }}" alt="FRUVIT.ID Open Order" class="w-full h-full object-contain rounded-xl">
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Keunggulan Produk Section (Value Propositions - 3 Grid Ke Samping di Mobile & Desktop) -->
<section class="py-8 sm:py-14 bg-white border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <div class="text-center max-w-xl mx-auto mb-6 sm:mb-10">
            <span class="text-[11px] sm:text-xs font-bold text-blue-600 uppercase tracking-wider">Kenapa Memilih Kami</span>
            <h2 class="text-lg sm:text-3xl font-extrabold text-slate-900 mt-1">Keunggulan FRUVIT.ID</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Kualitas terbaik dengan bahan segar dan proses higienis untuk pengalaman terbaik Anda.</p>
        </div>

        <!-- 3 Grid ke Samping -->
        <div class="grid grid-cols-3 gap-2 sm:gap-6">
            
            <div class="p-3 sm:p-6 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-200 hover:bg-blue-50/30 transition text-center sm:text-left flex flex-col items-center sm:items-start justify-between">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg sm:text-2xl font-bold mb-2 sm:mb-3 shrink-0">
                    🍓
                </div>
                <div>
                    <h3 class="text-xs sm:text-base font-bold text-slate-900 leading-tight">100% Alami</h3>
                    <p class="text-[10px] sm:text-sm text-slate-500 mt-1 sm:mt-1.5 leading-tight sm:leading-relaxed hidden sm:block">
                        Dipilih dari buah segar berkualitas setiap hari tanpa bahan pengawet berbahaya.
                    </p>
                    <p class="text-[10px] text-slate-500 mt-1 leading-tight sm:hidden">
                        Buah segar pilihan tanpa pengawet.
                    </p>
                </div>
            </div>

            <div class="p-3 sm:p-6 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-200 hover:bg-blue-50/30 transition text-center sm:text-left flex flex-col items-center sm:items-start justify-between">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg sm:text-2xl font-bold mb-2 sm:mb-3 shrink-0">
                    ❄️
                </div>
                <div>
                    <h3 class="text-xs sm:text-base font-bold text-slate-900 leading-tight">Selalu Fresh</h3>
                    <p class="text-[10px] sm:text-sm text-slate-500 mt-1 sm:mt-1.5 leading-tight sm:leading-relaxed hidden sm:block">
                        Disimpan dalam suhu dingin higienis agar rasa renyah, manis alami, dan kesegarannya terjaga.
                    </p>
                    <p class="text-[10px] text-slate-500 mt-1 leading-tight sm:hidden">
                        Dingin higienis & terjaga.
                    </p>
                </div>
            </div>

            <div class="p-3 sm:p-6 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200/80 hover:border-blue-200 hover:bg-blue-50/30 transition text-center sm:text-left flex flex-col items-center sm:items-start justify-between">
                <div class="w-9 h-9 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-lg sm:text-2xl font-bold mb-2 sm:mb-3 shrink-0">
                    🛵
                </div>
                <div>
                    <h3 class="text-xs sm:text-base font-bold text-slate-900 leading-tight">Pesan Praktis</h3>
                    <p class="text-[10px] sm:text-sm text-slate-500 mt-1 sm:mt-1.5 leading-tight sm:leading-relaxed hidden sm:block">
                        Pesan lewat web, bayar QRIS/Cash, bisa Pickup stand atau Delivery kos/kampus.
                    </p>
                    <p class="text-[10px] text-slate-500 mt-1 leading-tight sm:hidden">
                        Pickup stand atau Delivery.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- Best Seller Section (Product Cards - Clean 2 Grid on Mobile, 4 Grid on Desktop) -->
<section class="py-10 sm:py-16 bg-slate-50 border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-6 sm:mb-10">
            <div>
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Paling Laris</span>
                <h2 class="text-xl sm:text-3xl font-extrabold text-slate-900 mt-0.5">Produk Unggulan (Best Seller)</h2>
            </div>
            <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-1 text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 transition">
                <span>Lihat Semua</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>

        <!-- 2 Grid on Mobile, 4 Grid on Desktop -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
            @foreach($bestSellers as $product)
                <div class="bg-white rounded-2xl border border-slate-200/80 hover:border-blue-300 hover:shadow-md transition-all duration-200 flex flex-col justify-between overflow-hidden group">
                    
                    <!-- Product Image -->
                    <div class="relative aspect-square bg-slate-100 overflow-hidden cursor-pointer" 
                         @click="openProductDetail({{ $product->id }})">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        
                        @if($product->badge)
                            <span class="absolute top-2 left-2 bg-yellow-400 text-slate-900 font-bold text-[9px] sm:text-[10px] px-2 py-0.5 rounded-md shadow-2xs">
                                {{ $product->badge }}
                            </span>
                        @endif

                        <span class="absolute top-2 right-2 bg-white/95 backdrop-blur-xs text-slate-600 font-semibold text-[9px] sm:text-[10px] px-2 py-0.5 rounded-md shadow-2xs">
                            {{ $product->category?->name ?? 'Menu' }}
                        </span>
                    </div>

                    <!-- Details Area -->
                    <div class="p-3 sm:p-4 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition cursor-pointer line-clamp-2 leading-snug"
                                @click="openProductDetail({{ $product->id }})">
                                {{ $product->name }}
                            </h3>
                            <p class="text-[11px] text-slate-400 mt-1 line-clamp-1 leading-relaxed">
                                {{ $product->description }}
                            </p>
                        </div>

                        <!-- Price & Order Action Button -->
                        <div class="mt-3 pt-2.5 border-t border-slate-100 flex items-center justify-between gap-1.5">
                            <div>
                                <span class="text-[10px] text-slate-400 block font-medium">Harga</span>
                                <span class="text-xs sm:text-sm font-black text-blue-600 block">{{ $product->formatted_price }}</span>
                            </div>

                            <button type="button"
                                    @click="openProductDetail({{ $product->id }})"
                                    class="w-7 h-7 sm:w-auto sm:h-auto sm:px-3 sm:py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs flex items-center justify-center gap-1 shadow-2xs transition active:scale-95 cursor-pointer"
                                    title="Pilih & Atur Menu">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                <span class="hidden sm:inline">Pesan</span>
                            </button>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('menu.index') }}" 
               class="inline-flex items-center gap-2 bg-white hover:bg-blue-50 text-blue-600 border border-blue-300 font-bold text-xs sm:text-sm px-6 py-3 rounded-xl transition shadow-2xs">
                <span>Buka Seluruh Katalog Menu</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

    </div>
</section>

<!-- Tentang Kami Section (Clean Minimalist Identity) -->
<section id="tentang" class="py-12 sm:py-16 bg-white border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto text-center space-y-4">
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold">
                <span>🍓 Tentang FRUVIT.ID</span>
            </div>
            <h2 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Kesegaran Alami untuk Harimu yang Lebih Baik
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                FRUVIT.ID adalah brand produk kewirausahaan mahasiswa yang berkomitmen menghadirkan kreasi makanan dan minuman berbasis buah segar alami. Dengan racikan istimewa saus creamy salad buah dan kombinasi susu segar serta jelly lembut, kami menyajikan camilan sehat yang lezat, segar, dan ramah di kantong mahasiswa.
            </p>
        </div>
    </div>
</section>
@endsection
