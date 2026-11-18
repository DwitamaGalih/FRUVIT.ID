<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FRUVIT.ID - Segar Buahnya, Nikmat Rasanya | Pesan Online Salad Buah & Susu Jelly')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-fruvit.jpg') }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Alpine.js & Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 text-slate-800 antialiased font-sans flex flex-col"
      x-data="fruvitApp()"
      x-init="initApp()">

    <!-- Top Announcement Bar (Ultra Compact on Mobile) -->
    <div class="bg-gradient-to-r from-emerald-800 via-emerald-700 to-green-700 text-white text-[11px] py-1.5 px-3 sm:px-4 shadow-xs">
        <div class="max-w-7xl mx-auto flex items-center justify-between gap-2">
            <div class="flex items-center space-x-1.5 truncate">
                <span class="inline-flex items-center px-1.5 py-0.2 rounded-md text-[9px] font-black bg-yellow-400 text-emerald-950 uppercase tracking-wide">
                    BUKA
                </span>
                <span class="truncate font-medium text-emerald-100">🍓 100% Buah Segar Pilihan • Fresh Daily</span>
            </div>
            <div class="flex items-center space-x-3 text-emerald-200 text-[11px] shrink-0">
                <a href="{{ route('order.track') }}" class="hover:text-yellow-300 transition flex items-center gap-1 font-semibold">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span class="hidden sm:inline">Lacak Pesanan</span>
                    <span class="sm:hidden">Lacak</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar (Compact Height on Mobile) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-emerald-100/80 shadow-xs transition">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-14 sm:h-18">
                
                <!-- Brand Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-1.5 group">
                        <img src="{{ asset('images/logo-fruvit.jpg') }}" alt="FRUVIT.ID" class="h-9 sm:h-12 w-auto object-contain rounded-lg transition-transform group-hover:scale-105 duration-200">
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="{{ route('home') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ request()->routeIs('home') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-100 hover:text-emerald-700' }}">
                        Beranda
                    </a>
                    <a href="{{ route('menu.index') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ request()->routeIs('menu.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-100 hover:text-emerald-700' }}">
                        Menu Produk
                    </a>
                    <a href="{{ route('order.track') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs sm:text-sm font-bold transition {{ request()->routeIs('order.track') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-700 hover:bg-slate-100 hover:text-emerald-700' }}">
                        Cek Status Pesanan
                    </a>
                </nav>

                <!-- Header Actions: Cart & Quick Search Button -->
                <div class="flex items-center space-x-2">
                    
                    <!-- Search Shortcut on Mobile Header -->
                    <a href="{{ route('menu.index') }}" 
                       class="md:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-emerald-600 transition" 
                       title="Cari Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </a>

                    <!-- Direct Order / Cart Button -->
                    <button @click="openCartDrawer = true" 
                            type="button"
                            class="relative inline-flex items-center gap-1.5 sm:gap-2 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-bold px-3 py-1.5 sm:px-4 sm:py-2.5 rounded-xl sm:rounded-2xl shadow-xs hover:shadow-md transition-all duration-200 cursor-pointer active:scale-95">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="hidden sm:inline text-xs sm:text-sm font-extrabold">Keranjang</span>
                        <span x-text="cart.count" 
                              class="inline-flex items-center justify-center px-1.5 py-0.2 text-[10px] sm:text-xs font-black bg-yellow-400 text-emerald-950 rounded-full shadow-xs min-w-[18px]">
                            0
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Global Alerts / Flashes -->
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 mt-3 w-full">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-3 bg-emerald-50 border border-emerald-300 text-emerald-800 px-3.5 py-2.5 rounded-2xl flex items-center justify-between text-xs font-semibold shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-600 hover:text-emerald-900">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" class="mb-3 bg-rose-50 border border-rose-300 text-rose-800 px-3.5 py-2.5 rounded-2xl flex items-center justify-between text-xs font-semibold shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-rose-600 hover:text-rose-900">&times;</button>
            </div>
        @endif

        @if(session('warning'))
            <div x-data="{ show: true }" x-show="show" class="mb-3 bg-amber-50 border border-amber-300 text-amber-800 px-3.5 py-2.5 rounded-2xl flex items-center justify-between text-xs font-semibold shadow-xs">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>{{ session('warning') }}</span>
                </div>
                <button @click="show = false" class="text-amber-600 hover:text-amber-900">&times;</button>
            </div>
        @endif
    </div>

    <!-- Main Content Area with Bottom Padding for Mobile Nav -->
    <main class="grow pb-24 md:pb-8">
        @yield('content')
    </main>

    <!-- Floating Order Bar (Mie Gacoan / Food Delivery Style) - Positioned Above Mobile Bottom Nav -->
    <div x-show="cart.count > 0 && !['cart.index', 'checkout.index'].includes('{{ Route::currentRouteName() }}')" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-6"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-6"
         class="fixed bottom-18 md:bottom-5 inset-x-0 z-30 px-3 sm:px-6 pointer-events-none">
        <div class="max-w-xl mx-auto pointer-events-auto">
            <div class="bg-slate-900/95 backdrop-blur-md text-white p-2.5 sm:p-4 rounded-2xl sm:rounded-3xl shadow-2xl border border-slate-700/60 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="relative bg-emerald-500 text-white p-2 sm:p-2.5 rounded-xl sm:rounded-2xl shadow-md">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span x-text="cart.count" class="absolute -top-1.5 -right-1.5 bg-yellow-400 text-emerald-950 font-black text-[10px] sm:text-xs w-4 h-4 sm:w-5 sm:h-5 rounded-full flex items-center justify-center">1</span>
                    </div>
                    <div>
                        <div class="text-[10px] sm:text-xs text-slate-300 font-medium">Total Pesanan:</div>
                        <div class="text-sm sm:text-lg font-black text-yellow-300" x-text="cart.formatted_subtotal">Rp 0</div>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 sm:gap-2">
                    <button @click="openCartDrawer = true" 
                            type="button"
                            class="bg-slate-800 hover:bg-slate-700 text-slate-200 text-[11px] sm:text-xs font-bold px-2.5 py-2 sm:px-3 sm:py-2.5 rounded-xl transition cursor-pointer">
                        Rincian
                    </button>
                    <a href="{{ route('checkout.index') }}" 
                       class="inline-flex items-center gap-1 bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white font-black text-xs sm:text-sm px-3.5 py-2 sm:px-4 sm:py-2.5 rounded-xl shadow-md hover:shadow-lg transition cursor-pointer">
                        <span>Checkout</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom App Navigation Bar (Fixed at bottom on phones) -->
    <nav class="md:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200/80 shadow-[0_-4px_16px_rgba(0,0,0,0.06)] px-2 py-1.5">
        <div class="grid grid-cols-4 items-center text-center">
            
            <!-- Tab 1: Beranda -->
            <a href="{{ route('home') }}" 
               class="flex flex-col items-center py-1 transition {{ request()->routeIs('home') ? 'text-emerald-600 font-extrabold' : 'text-slate-500 hover:text-slate-800 font-medium' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('home') ? 'text-emerald-600' : 'text-slate-400' }}" fill="{{ request()->routeIs('home') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-[10px] mt-0.5">Beranda</span>
            </a>

            <!-- Tab 2: Menu -->
            <a href="{{ route('menu.index') }}" 
               class="flex flex-col items-center py-1 transition {{ request()->routeIs('menu.*') ? 'text-emerald-600 font-extrabold' : 'text-slate-500 hover:text-slate-800 font-medium' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('menu.*') ? 'text-emerald-600' : 'text-slate-400' }}" fill="{{ request()->routeIs('menu.*') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                <span class="text-[10px] mt-0.5">Menu</span>
            </a>

            <!-- Tab 3: Keranjang -->
            <button @click="openCartDrawer = true" 
                    type="button"
                    class="relative flex flex-col items-center py-1 transition text-slate-500 hover:text-slate-800 font-medium cursor-pointer">
                <div class="relative">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span x-show="cart.count > 0" 
                          x-text="cart.count" 
                          class="absolute -top-1.5 -right-2 bg-yellow-400 text-emerald-950 font-black text-[9px] w-4 h-4 rounded-full flex items-center justify-center">
                    </span>
                </div>
                <span class="text-[10px] mt-0.5">Keranjang</span>
            </button>

            <!-- Tab 4: Lacak -->
            <a href="{{ route('order.track') }}" 
               class="flex flex-col items-center py-1 transition {{ request()->routeIs('order.track') ? 'text-emerald-600 font-extrabold' : 'text-slate-500 hover:text-slate-800 font-medium' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('order.track') ? 'text-emerald-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <span class="text-[10px] mt-0.5">Lacak</span>
            </a>

        </div>
    </nav>

    <!-- Slide-over Cart Drawer / Native Mobile Bottom Sheet -->
    <div x-show="openCartDrawer" 
         x-cloak
         class="relative z-50" 
         aria-labelledby="slide-over-title" 
         role="dialog" 
         aria-modal="true">
        <!-- Modern Soft Blur Backdrop -->
        <div x-show="openCartDrawer"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="openCartDrawer = false"
             class="fixed inset-0 bg-slate-950/50 backdrop-blur-xs transition-opacity"></div>

        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-x-0 bottom-0 sm:inset-y-0 sm:right-0 sm:left-auto flex max-w-full">
                    <div x-show="openCartDrawer"
                         x-transition:enter="transform transition ease-out duration-300"
                         x-transition:enter-start="translate-y-full sm:translate-y-0 sm:translate-x-full"
                         x-transition:enter-end="translate-y-0 sm:translate-x-0"
                         x-transition:leave="transform transition ease-in duration-250"
                         x-transition:leave-start="translate-y-0 sm:translate-x-0"
                         x-transition:leave-end="translate-y-full sm:translate-y-0 sm:translate-x-full"
                         class="pointer-events-auto w-full sm:w-[440px] max-h-[90vh] sm:max-h-full h-auto sm:h-full flex flex-col bg-white rounded-t-[32px] sm:rounded-t-none sm:rounded-l-[32px] shadow-[0_-12px_40px_rgba(0,0,0,0.14)] sm:shadow-2xl border-t sm:border-t-0 sm:border-l border-slate-100 overflow-hidden">
                        
                        <!-- Mobile Drag Handle -->
                        <div class="sm:hidden w-12 h-1.5 bg-slate-200 rounded-full mx-auto my-2.5 shrink-0"></div>

                        <!-- Clean Modern Header -->
                        <div class="px-5 py-3.5 sm:py-4 bg-white/95 backdrop-blur-md border-b border-slate-100 flex items-center justify-between shrink-0">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-50 to-green-100 border border-emerald-200/60 flex items-center justify-center text-emerald-700 shadow-2xs">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-sm sm:text-base font-black text-slate-900 tracking-tight" id="slide-over-title">Keranjang Pesanan</h2>
                                    <span class="inline-flex items-center px-2 py-0.2 rounded-full text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200/60" x-text="`${cart.count} item dipilih`">
                                        0 item dipilih
                                    </span>
                                </div>
                            </div>
                            <button @click="openCartDrawer = false" 
                                    type="button" 
                                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition active:scale-90 cursor-pointer"
                                    title="Tutup">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>

                        <!-- Cart Items List / Clean Empty State -->
                        <div class="flex-1 overflow-y-auto p-4 sm:p-5 space-y-3">
                            
                            <!-- Empty State Card (Clean, modern, aesthetic) -->
                            <template x-if="Object.keys(cart.items).length === 0">
                                <div class="py-6 sm:py-8 px-2 flex flex-col items-center text-center">
                                    <div class="relative w-20 h-20 mb-3.5 flex items-center justify-center rounded-3xl bg-gradient-to-tr from-emerald-50 via-teal-50 to-amber-50 border border-emerald-100 shadow-sm">
                                        <span class="text-4xl">🥗</span>
                                        <span class="absolute -top-1.5 -right-1.5 w-6 h-6 rounded-full bg-yellow-400 text-emerald-950 font-black text-xs flex items-center justify-center shadow-xs">✨</span>
                                    </div>
                                    <h3 class="text-base sm:text-lg font-black text-slate-900">Keranjang Masih Kosong</h3>
                                    <p class="text-xs text-slate-500 mt-1.5 max-w-[260px] leading-relaxed">
                                        Yuk pilih salad buah segar, susu jelly manis creamy, atau buah potong dingin favoritmu!
                                    </p>
                                    
                                    <a href="{{ route('menu.index') }}" 
                                       @click="openCartDrawer = false" 
                                       class="mt-4 inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white text-xs font-black px-5 py-2.5 sm:px-6 sm:py-3 rounded-2xl shadow-md shadow-emerald-600/20 active:scale-95 transition cursor-pointer">
                                        <span>Lihat Menu FRUVIT.ID</span>
                                        <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>

                                    <!-- Quick Shortcuts / Inspirasi Menu -->
                                    <div class="mt-6 pt-5 border-t border-slate-100 w-full">
                                        <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-2.5">Menu Terfavorit Hari Ini:</div>
                                        <div class="grid grid-cols-3 gap-2">
                                            <a href="{{ route('menu.index', ['kategori' => 'salad-buah']) }}" @click="openCartDrawer = false" class="p-2 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/70 hover:border-emerald-200 transition text-center group">
                                                <div class="text-xl mb-1 group-hover:scale-110 transition-transform">🥗</div>
                                                <div class="text-[11px] font-extrabold text-slate-800 leading-tight">Salad Buah</div>
                                                <div class="text-[10px] font-bold text-emerald-600 mt-0.5">13k</div>
                                            </a>
                                            <a href="{{ route('menu.index', ['kategori' => 'susu-jelly']) }}" @click="openCartDrawer = false" class="p-2 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/70 hover:border-emerald-200 transition text-center group">
                                                <div class="text-xl mb-1 group-hover:scale-110 transition-transform">🥤</div>
                                                <div class="text-[11px] font-extrabold text-slate-800 leading-tight">Susu Jelly</div>
                                                <div class="text-[10px] font-bold text-emerald-600 mt-0.5">12,5k</div>
                                            </a>
                                            <a href="{{ route('menu.index', ['kategori' => 'buah-potong']) }}" @click="openCartDrawer = false" class="p-2 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/70 hover:border-emerald-200 transition text-center group">
                                                <div class="text-xl mb-1 group-hover:scale-110 transition-transform">🍉</div>
                                                <div class="text-[11px] font-extrabold text-slate-800 leading-tight">Buah Potong</div>
                                                <div class="text-[10px] font-bold text-emerald-600 mt-0.5">10k</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Filled Items List (Clean Modern Cards) -->
                            <template x-for="(item, id) in cart.items" :key="id">
                                <div class="bg-white border border-slate-200/80 hover:border-emerald-200 rounded-2xl p-2.5 sm:p-3 flex gap-3 items-center shadow-2xs hover:shadow-xs transition">
                                    <img :src="item.image_url" :alt="item.name" class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl object-cover border border-slate-100 shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs sm:text-sm font-extrabold text-slate-900 truncate" x-text="item.name"></h4>
                                        <div class="text-xs font-black text-emerald-600 mt-0.5" x-text="item.formatted_price"></div>
                                        
                                        <!-- Addon badges (Susu Jelly) -->
                                        <template x-if="item.sugar_level || item.jelly_topping">
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <span x-show="item.sugar_level" class="inline-flex items-center px-1.5 py-0.2 rounded-md text-[9px] font-bold bg-amber-50 text-amber-800 border border-amber-200/80" x-text="item.sugar_level"></span>
                                                <span x-show="item.jelly_topping" class="inline-flex items-center px-1.5 py-0.2 rounded-md text-[9px] font-bold bg-purple-50 text-purple-800 border border-purple-200/80" x-text="item.jelly_topping"></span>
                                            </div>
                                        </template>

                                        <div class="text-[10px] text-slate-400 italic truncate mt-0.5" x-show="item.notes" x-text="'Catatan: ' + item.notes"></div>
                                        
                                        <!-- Tactile Stepper Qty Control -->
                                        <div class="flex items-center gap-1.5 mt-2">
                                            <div class="inline-flex items-center bg-slate-100 rounded-xl p-0.5 border border-slate-200/60 shadow-2xs">
                                                <button @click="updateCartQty(item.cart_key || item.id, item.quantity - 1)" 
                                                        type="button" 
                                                        class="w-6 h-6 rounded-lg bg-white border border-slate-200/80 flex items-center justify-center text-slate-700 font-black hover:bg-slate-100 active:scale-90 text-xs transition cursor-pointer">
                                                    -
                                                </button>
                                                <span class="w-7 text-center text-xs font-black text-slate-900" x-text="item.quantity"></span>
                                                <button @click="updateCartQty(item.cart_key || item.id, item.quantity + 1)" 
                                                        type="button" 
                                                        class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center hover:bg-emerald-700 active:scale-90 font-black text-xs transition cursor-pointer shadow-2xs">
                                                    +
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right flex flex-col justify-between items-end h-16 sm:h-18 shrink-0">
                                        <button @click="removeFromCart(item.cart_key || item.id)" 
                                                type="button" 
                                                class="text-slate-300 hover:text-rose-500 p-1 rounded-lg hover:bg-rose-50 transition cursor-pointer" 
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                        <div class="text-xs sm:text-sm font-black text-slate-900" x-text="item.formatted_subtotal"></div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Modern Clean Sticky Footer with Breakdown -->
                        <div class="border-t border-slate-100 p-4 sm:p-5 bg-white space-y-3 shrink-0 shadow-[0_-4px_16px_rgba(0,0,0,0.04)]" x-show="Object.keys(cart.items).length > 0">
                            <div class="flex justify-between items-center text-xs text-slate-500 font-semibold">
                                <span x-text="`Subtotal (${cart.count} item)`">Subtotal</span>
                                <span class="text-base sm:text-lg font-black text-slate-900" x-text="cart.formatted_subtotal"></span>
                            </div>
                            
                            <div class="flex items-center gap-1.5 text-[10px] text-emerald-700 bg-emerald-50 px-2.5 py-1.5 rounded-xl border border-emerald-100 font-bold">
                                <span>🛵</span>
                                <span>Bisa pesan antar (delivery kampus) atau ambil sendiri (pickup).</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-0.5">
                                <a href="{{ route('cart.index') }}" 
                                   @click="openCartDrawer = false"
                                   class="w-full text-center py-3 px-3 border border-slate-200 rounded-xl sm:rounded-2xl text-xs font-extrabold text-slate-700 hover:bg-slate-50 transition active:scale-95">
                                    Buka Keranjang
                                </a>
                                <a href="{{ route('checkout.index') }}" 
                                   @click="openCartDrawer = false"
                                   class="w-full inline-flex items-center justify-center gap-1.5 py-3 px-3 bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white rounded-xl sm:rounded-2xl text-xs font-black shadow-md shadow-emerald-600/20 hover:shadow-lg transition active:scale-95">
                                    <span>Checkout</span>
                                    <svg class="w-3.5 h-3.5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Product Detail Quick View -->
    <div x-show="productModal.open" 
         x-cloak
         class="relative z-50" 
         role="dialog" 
         aria-modal="true">
        <div x-show="productModal.open"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="closeProductModal()"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4 text-center">
                <div x-show="productModal.open"
                     x-transition:enter="ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     class="relative transform overflow-hidden rounded-t-3xl sm:rounded-3xl bg-white text-left shadow-2xl transition-all w-full sm:max-w-md border border-slate-100 max-h-[90vh] flex flex-col">
                    
                    <!-- Close button -->
                    <button @click="closeProductModal()" class="absolute top-3 right-3 z-10 bg-white/90 backdrop-blur-xs text-slate-600 hover:text-slate-900 rounded-full p-1.5 shadow-md cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <!-- Product Image -->
                    <div class="relative h-48 sm:h-56 w-full bg-slate-100 overflow-hidden shrink-0">
                        <img :src="productModal.item.image_url" :alt="productModal.item.name" class="w-full h-full object-cover">
                        <span x-show="productModal.item.badge" 
                              x-text="productModal.item.badge" 
                              class="absolute top-3 left-3 bg-yellow-400 text-emerald-950 font-black text-[10px] px-2.5 py-0.5 rounded-full shadow-md">
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="p-4 sm:p-6 overflow-y-auto">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider" x-text="productModal.item.category"></span>
                                <h3 class="text-base sm:text-lg font-black text-slate-900 mt-0.5" x-text="productModal.item.name"></h3>
                            </div>
                            <div class="text-base sm:text-lg font-black text-emerald-600 shrink-0" x-text="productModal.item.formatted_price"></div>
                        </div>

                        <p class="text-xs text-slate-600 mt-2 leading-relaxed" x-text="productModal.item.description"></p>

                        <!-- Susu Jelly Add-on Section (Sugar Level & Topping Jelly) -->
                        <template x-if="productModal.item.category_slug === 'susu-jelly'">
                            <div class="mt-4 p-3 bg-emerald-50/70 rounded-2xl border border-emerald-200/80 space-y-3.5">
                                
                                <!-- Sugar Level Selection -->
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="text-[11px] font-black text-slate-800 flex items-center gap-1">
                                            <span>🍯 Sugar Level:</span>
                                            <span class="text-emerald-700 font-extrabold" x-text="productModal.sugarLevel"></span>
                                        </label>
                                        <span class="text-[10px] font-bold text-slate-400">Pilih tingkat manis</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-1.5">
                                        <button type="button"
                                                @click="productModal.sugarLevel = 'Less sugar'"
                                                class="py-2 px-1 rounded-xl text-[11px] font-bold border transition text-center cursor-pointer select-none active:scale-95"
                                                :class="productModal.sugarLevel === 'Less sugar' ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            Less sugar
                                        </button>
                                        <button type="button"
                                                @click="productModal.sugarLevel = 'Normal sugar'"
                                                class="py-2 px-1 rounded-xl text-[11px] font-bold border transition text-center cursor-pointer select-none active:scale-95"
                                                :class="productModal.sugarLevel === 'Normal sugar' ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            Normal sugar
                                        </button>
                                        <button type="button"
                                                @click="productModal.sugarLevel = 'extra sugar'"
                                                class="py-2 px-1 rounded-xl text-[11px] font-bold border transition text-center cursor-pointer select-none active:scale-95"
                                                :class="productModal.sugarLevel === 'extra sugar' ? 'bg-emerald-600 text-white border-emerald-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            extra sugar
                                        </button>
                                    </div>
                                </div>

                                <!-- Topping Jelly Selection -->
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="text-[11px] font-black text-slate-800 flex items-center gap-1">
                                            <span>🧋 Topping Jelly:</span>
                                            <span class="text-purple-700 font-extrabold" x-text="productModal.jellyTopping"></span>
                                        </label>
                                        <span class="text-[10px] font-bold text-slate-400">Pilih varian topping</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-1.5">
                                        <button type="button"
                                                @click="productModal.jellyTopping = 'Tanpa jelly'"
                                                class="py-2 px-1 rounded-xl text-[11px] font-bold border transition text-center cursor-pointer select-none active:scale-95"
                                                :class="productModal.jellyTopping === 'Tanpa jelly' ? 'bg-purple-600 text-white border-purple-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            Tanpa jelly
                                        </button>
                                        <button type="button"
                                                @click="productModal.jellyTopping = 'Normal jelly'"
                                                class="py-2 px-1 rounded-xl text-[11px] font-bold border transition text-center cursor-pointer select-none active:scale-95"
                                                :class="productModal.jellyTopping === 'Normal jelly' ? 'bg-purple-600 text-white border-purple-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            Normal jelly
                                        </button>
                                        <button type="button"
                                                @click="productModal.jellyTopping = 'extra jelly'"
                                                class="py-2 px-1 rounded-xl text-[11px] font-bold border transition text-center cursor-pointer select-none active:scale-95"
                                                :class="productModal.jellyTopping === 'extra jelly' ? 'bg-purple-600 text-white border-purple-600 shadow-xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            extra jelly
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </template>

                        <!-- Notes / Special request -->
                        <div class="mt-4">
                            <label class="block text-[11px] font-bold text-slate-700 mb-1">Catatan Khusus (Opsional)</label>
                            <input type="text" 
                                   x-model="productModal.notes"
                                   placeholder="Contoh: Kurangi manis, tambah sendok..." 
                                   class="w-full text-xs px-3 py-2 rounded-xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <!-- Quantity Selector & Action -->
                        <div class="mt-5 flex items-center justify-between gap-3 pt-3 border-t border-slate-100">
                            <div class="flex items-center border border-slate-300 rounded-xl p-0.5 bg-slate-50">
                                <button @click="if(productModal.qty > 1) productModal.qty--" type="button" class="w-8 h-8 rounded-lg bg-white text-slate-700 font-black hover:bg-slate-200 transition flex items-center justify-center shadow-xs cursor-pointer text-xs">-</button>
                                <span class="w-9 text-center text-xs font-black text-slate-900" x-text="productModal.qty">1</span>
                                <button @click="productModal.qty++" type="button" class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-black hover:bg-emerald-700 transition flex items-center justify-center shadow-xs cursor-pointer text-xs">+</button>
                            </div>

                            <button @click="submitModalToCart()" 
                                    type="button" 
                                    class="grow bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-black text-xs py-3 px-4 rounded-xl shadow-md transition flex items-center justify-center gap-1.5 cursor-pointer">
                                <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                <span>Tambah ke Keranjang</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification (Compact) -->
    <div x-show="toast.show" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         class="fixed top-16 right-3 sm:right-4 z-50 max-w-xs w-full bg-slate-900/95 backdrop-blur-md text-white p-3 rounded-2xl shadow-2xl flex items-center gap-2.5 border border-slate-700">
        <div class="p-1.5 bg-emerald-500 rounded-lg text-white shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div class="grow text-xs font-bold truncate" x-text="toast.message">Pesanan ditambahkan!</div>
        <button @click="toast.show = false" class="text-slate-400 hover:text-white">&times;</button>
    </div>

    <!-- Footer (Hidden on Mobile or very compact, Full on Desktop) -->
    <footer class="bg-slate-900 text-slate-300 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 sm:gap-8">
                
                <!-- Col 1: Brand Info -->
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/logo-fruvit.jpg') }}" alt="FRUVIT.ID" class="h-10 w-auto bg-white p-0.5 rounded-xl object-contain">
                    </div>
                    <p class="text-xs text-slate-400 max-w-md leading-relaxed">
                        FRUVIT.ID merupakan produk kewirausahaan mahasiswa: Salad Buah keju melimpah, Susu Jelly varian nikmat, dan Buah Potong segar dingin.
                    </p>
                    <div class="flex items-center gap-2 text-xs text-emerald-400 font-semibold">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Menerima Pemesanan Pickup & Delivery Kampus</span>
                    </div>
                </div>

                <!-- Col 2: Navigasi Cepat -->
                <div class="hidden sm:block">
                    <h3 class="text-xs font-extrabold text-white tracking-wider uppercase mb-3">Navigasi</h3>
                    <ul class="space-y-2 text-xs font-semibold">
                        <li><a href="{{ route('home') }}" class="hover:text-yellow-400 transition">Beranda</a></li>
                        <li><a href="{{ route('menu.index') }}" class="hover:text-yellow-400 transition">Daftar Menu</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-yellow-400 transition">Keranjang Belanja</a></li>
                        <li><a href="{{ route('order.track') }}" class="hover:text-yellow-400 transition">Lacak Pesanan</a></li>
                    </ul>
                </div>

                <!-- Col 3: Kontak & Pembayaran -->
                <div>
                    <h3 class="text-xs font-extrabold text-white tracking-wider uppercase mb-3">Stand & Kontak</h3>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li class="flex items-center gap-2">
                            <span>📍</span>
                            <span>Stand Kewirausahaan FRUVIT.ID</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>💬</span>
                            <span>WhatsApp: 0812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span>💳</span>
                            <span>QRIS Instan & Tunai / Cash</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 mt-8 pt-4 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500 gap-2">
                <div>&copy; {{ date('Y') }} FRUVIT.ID • Usaha Mahasiswa Kewirausahaan.</div>
                <div class="text-slate-400">Segar Buahnya, Nikmat Rasanya!</div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js Store & App Logic -->
    <script>
        function fruvitApp() {
            return {
                openCartDrawer: false,
                cart: {
                    items: {},
                    count: 0,
                    subtotal: 0,
                    formatted_subtotal: 'Rp 0'
                },
                productModal: {
                    open: false,
                    qty: 1,
                    notes: '',
                    sugarLevel: 'Normal sugar',
                    jellyTopping: 'Normal jelly',
                    item: {}
                },
                toast: {
                    show: false,
                    message: ''
                },

                initApp() {
                    this.fetchCart();
                },

                fetchCart() {
                    fetch('{{ route('cart.json') }}')
                        .then(res => res.json())
                        .then(data => {
                            this.cart = data;
                        })
                        .catch(err => console.error(err));
                },

                showToast(msg) {
                    this.toast.message = msg;
                    this.toast.show = true;
                    setTimeout(() => {
                        this.toast.show = false;
                    }, 3500);
                },

                quickAddToCart(productId) {
                    fetch('{{ route('cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: 1
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.cart) {
                            this.cart = data.cart;
                            this.showToast('✅ Berhasil ditambahkan!');
                        }
                    })
                    .catch(err => console.error(err));
                },

                openProductDetail(productId) {
                    fetch(`/menu/${productId}/detail`)
                        .then(res => res.json())
                        .then(data => {
                            this.productModal.item = data;
                            this.productModal.qty = 1;
                            this.productModal.notes = '';
                            this.productModal.sugarLevel = 'Normal sugar';
                            this.productModal.jellyTopping = 'Normal jelly';
                            this.productModal.open = true;
                        })
                        .catch(err => console.error(err));
                },

                closeProductModal() {
                    this.productModal.open = false;
                },

                submitModalToCart() {
                    const isSusuJelly = this.productModal.item.category_slug === 'susu-jelly';
                    fetch('{{ route('cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: this.productModal.item.id,
                            quantity: this.productModal.qty,
                            notes: this.productModal.notes,
                            sugar_level: isSusuJelly ? this.productModal.sugarLevel : null,
                            jelly_topping: isSusuJelly ? this.productModal.jellyTopping : null
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.cart) {
                            this.cart = data.cart;
                            this.closeProductModal();
                            this.showToast('✅ ' + this.productModal.item.name + ' ditambahkan!');
                        }
                    })
                    .catch(err => console.error(err));
                },

                updateCartQty(cartKey, newQty) {
                    fetch('{{ route('cart.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            cart_key: cartKey,
                            product_id: cartKey,
                            quantity: newQty
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.cart) {
                            this.cart = data.cart;
                        }
                    })
                    .catch(err => console.error(err));
                },

                removeFromCart(cartKey) {
                    fetch('{{ route('cart.remove') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            cart_key: cartKey,
                            product_id: cartKey
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.cart) {
                            this.cart = data.cart;
                            this.showToast('Item telah dihapus');
                        }
                    })
                    .catch(err => console.error(err));
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
