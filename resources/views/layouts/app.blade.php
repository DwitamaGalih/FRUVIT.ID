<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'FRUVIT.ID - Fresh Fruit, Better Mood! | Pesan Salad Buah & Susu Jelly Online')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-fruvit.jpg') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Alpine.js & Scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 text-slate-800 antialiased font-sans flex flex-col"
      x-data="fruvitApp()"
      x-init="initApp()">

    <!-- Main Navigation Bar (Clean Minimalist Fresh Blue) -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs transition">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Brand Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <img src="{{ asset('images/logo-fruvit.jpg') }}" alt="FRUVIT.ID" class="h-9 sm:h-12 w-auto object-contain rounded-xl transition-transform group-hover:scale-105 duration-200">
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                    <a href="{{ route('home') }}" 
                       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition flex items-center gap-1.5 {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-house text-xs"></i>
                        <span>Home</span>
                    </a>
                    <a href="{{ route('menu.index') }}" 
                       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition flex items-center gap-1.5 {{ request()->routeIs('menu.*') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-utensils text-xs"></i>
                        <span>Menu</span>
                    </a>
                    <a href="{{ route('home') }}#tentang" 
                       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-info text-xs"></i>
                        <span>Tentang Kami</span>
                    </a>
                    <a href="{{ route('home') }}#kontak" 
                       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition flex items-center gap-1.5">
                        <i class="fa-solid fa-address-book text-xs"></i>
                        <span>Kontak</span>
                    </a>
                    <a href="{{ route('order.track') }}" 
                       class="px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold transition flex items-center gap-1.5 {{ request()->routeIs('order.track') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fa-solid fa-clipboard-list text-xs"></i>
                        <span>Cek Pesanan</span>
                    </a>
                </nav>

                <!-- Header Actions: Cart & CTA Button -->
                <div class="flex items-center space-x-2 sm:space-x-3">
                    
                    <!-- Shopping Cart Button -->
                    <button @click="openCartDrawer = true" 
                            type="button"
                            class="relative inline-flex items-center gap-2 p-2 sm:px-3.5 sm:py-2.5 rounded-xl border border-slate-200/90 hover:border-blue-300 bg-white hover:bg-blue-50/50 text-slate-700 hover:text-blue-600 font-bold text-xs sm:text-sm shadow-2xs transition-all duration-200 cursor-pointer active:scale-95"
                            title="Keranjang Belanja">
                        <i class="fa-solid fa-bag-shopping text-blue-600 text-base"></i>
                        <span class="font-bold">Keranjang</span>
                    </button>

                    <!-- CTA Button Pesan Sekarang (Desktop) -->
                    <a href="{{ route('menu.index') }}" 
                       class="hidden sm:inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm px-4 py-2.5 rounded-xl shadow-sm hover:shadow-md transition active:scale-95">
                        <span>Pesan Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Global Alerts / Flashes -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3 w-full">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-3 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-2xl flex items-center justify-between text-xs font-semibold shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-check text-blue-600 text-sm shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-blue-500 hover:text-blue-800 cursor-pointer"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" class="mb-3 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl flex items-center justify-between text-xs font-semibold shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-circle-xmark text-rose-600 text-sm shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-800 cursor-pointer"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>
        @endif

        @if(session('warning'))
            <div x-data="{ show: true }" x-show="show" class="mb-3 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-2xl flex items-center justify-between text-xs font-semibold shadow-2xs">
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-triangle-exclamation text-amber-600 text-sm shrink-0"></i>
                    <span>{{ session('warning') }}</span>
                </div>
                <button @click="show = false" class="text-amber-500 hover:text-amber-800 cursor-pointer"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>
        @endif
    </div>

    <!-- Main Content Area with Bottom Padding for Mobile Nav -->
    <main class="grow pb-24 md:pb-12">
        @yield('content')
    </main>

    <!-- Floating Order Bar (Fresh Blue Mobile-First Delivery Bar) -->
    <div x-show="cart.count > 0 && !['cart.index', 'checkout.index'].includes('{{ Route::currentRouteName() }}')" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-6"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-6"
         class="fixed bottom-18 md:bottom-6 inset-x-0 z-30 px-3 sm:px-6 pointer-events-none">
        <div class="max-w-xl mx-auto pointer-events-auto">
            <div class="bg-slate-900/95 backdrop-blur-md text-white p-3 sm:p-4 rounded-2xl sm:rounded-3xl shadow-xl border border-slate-700/60 flex items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="relative bg-blue-600 text-white w-9 h-9 rounded-xl shadow-xs flex items-center justify-center">
                        <i class="fa-solid fa-bag-shopping text-base"></i>
                        <span x-text="cart.count" class="absolute -top-1.5 -right-1.5 bg-yellow-400 text-slate-900 font-black text-[10px] w-4 h-4 rounded-full flex items-center justify-center">1</span>
                    </div>
                    <div>
                        <div class="text-[10px] text-slate-400 font-medium">Subtotal Pesanan:</div>
                        <div class="text-sm sm:text-base font-black text-white" x-text="cart.formatted_subtotal">Rp 0</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="openCartDrawer = true" 
                            type="button"
                            class="bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold px-3 py-2 rounded-xl transition cursor-pointer">
                        Rincian
                    </button>
                    <a href="{{ route('checkout.index') }}" 
                       class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs sm:text-sm px-4 py-2 rounded-xl shadow-sm transition cursor-pointer">
                        <span>Checkout</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Bottom App Navigation Bar (Clean Minimalist White) -->
    <nav class="md:hidden fixed bottom-0 inset-x-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200/90 shadow-[0_-4px_16px_rgba(0,0,0,0.04)] px-2 py-1.5">
        <div class="grid grid-cols-4 items-center text-center">
            
            <!-- Tab 1: Home -->
            <a href="{{ route('home') }}" 
               class="flex flex-col items-center py-1 transition {{ request()->routeIs('home') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800 font-medium' }}">
                <i class="fa-solid fa-house text-base {{ request()->routeIs('home') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                <span class="text-[10px] mt-0.5">Home</span>
            </a>

            <!-- Tab 2: Menu -->
            <a href="{{ route('menu.index') }}" 
               class="flex flex-col items-center py-1 transition {{ request()->routeIs('menu.*') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800 font-medium' }}">
                <i class="fa-solid fa-utensils text-base {{ request()->routeIs('menu.*') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                <span class="text-[10px] mt-0.5">Menu</span>
            </a>

            <!-- Tab 3: Keranjang -->
            <button @click="openCartDrawer = true" 
                    type="button"
                    class="relative flex flex-col items-center py-1 transition text-slate-500 hover:text-slate-800 font-medium cursor-pointer">
                <div>
                    <i class="fa-solid fa-bag-shopping text-base text-slate-400"></i>
                </div>
                <span class="text-[10px] mt-0.5">Keranjang</span>
            </button>

            <!-- Tab 4: Lacak -->
            <a href="{{ route('order.track') }}" 
               class="flex flex-col items-center py-1 transition {{ request()->routeIs('order.track') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800 font-medium' }}">
                <i class="fa-solid fa-clipboard-list text-base {{ request()->routeIs('order.track') ? 'text-blue-600' : 'text-slate-400' }}"></i>
                <span class="text-[10px] mt-0.5">Lacak</span>
            </a>

        </div>
    </nav>

    <!-- Slide-over Cart Drawer / Native Mobile Bottom Sheet (Fresh Blue Minimalist) -->
    <div x-show="openCartDrawer" 
         x-cloak
         class="relative z-50" 
         aria-labelledby="slide-over-title" 
         role="dialog" 
         aria-modal="true">
        <!-- Soft Blur Backdrop -->
        <div x-show="openCartDrawer"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="openCartDrawer = false"
             class="fixed inset-0 bg-slate-950/40 backdrop-blur-xs transition-opacity"></div>

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
                         class="pointer-events-auto w-full sm:w-[420px] max-h-[90vh] sm:max-h-full h-auto sm:h-full flex flex-col bg-white rounded-t-[28px] sm:rounded-t-none sm:rounded-l-[28px] shadow-2xl border-t sm:border-t-0 sm:border-l border-slate-100 overflow-hidden">
                        
                        <!-- Mobile Drag Handle -->
                        <div class="sm:hidden w-12 h-1.5 bg-slate-200 rounded-full mx-auto my-2.5 shrink-0"></div>

                        <!-- Header -->
                        <div class="px-5 py-4 bg-white border-b border-slate-100 flex items-center justify-between shrink-0">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                                    <i class="fa-solid fa-bag-shopping text-base"></i>
                                </div>
                                <div>
                                    <h2 class="text-sm sm:text-base font-bold text-slate-900 tracking-tight" id="slide-over-title">Keranjang Pesanan</h2>
                                    <span class="inline-flex items-center px-2 py-0.2 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200/60" x-text="`${cart.count} item dipilih`">
                                        0 item dipilih
                                    </span>
                                </div>
                            </div>
                            <button @click="openCartDrawer = false" 
                                    type="button" 
                                    class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition active:scale-90 cursor-pointer"
                                    title="Tutup">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </button>
                        </div>

                        <!-- Cart Items List / Empty State -->
                        <div class="flex-1 overflow-y-auto p-4 sm:p-5 space-y-3">
                            
                            <!-- Empty State Card -->
                            <template x-if="Object.keys(cart.items).length === 0">
                                <div class="py-8 px-2 flex flex-col items-center text-center">
                                    <div class="w-20 h-20 mb-3.5 flex items-center justify-center rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 text-3xl">
                                        🥤
                                    </div>
                                    <h3 class="text-base sm:text-lg font-bold text-slate-900">Keranjang Masih Kosong</h3>
                                    <p class="text-xs text-slate-500 mt-1 max-w-[260px] leading-relaxed">
                                        Pilih menu favorit buah segar dan minuman nikmat kami untuk memulai pesanan Anda.
                                    </p>
                                    
                                    <a href="{{ route('menu.index') }}" 
                                       @click="openCartDrawer = false" 
                                       class="mt-4 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-xs active:scale-95 transition cursor-pointer">
                                        <span>Lihat Daftar Menu</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>

                                    <!-- Quick Recommendations -->
                                    <div class="mt-6 pt-5 border-t border-slate-100 w-full">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2.5">Pilihan Favorit:</div>
                                        <div class="grid grid-cols-3 gap-2">
                                            <a href="{{ route('menu.index', ['kategori' => 'salad-buah']) }}" @click="openCartDrawer = false" class="p-2.5 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/70 hover:border-blue-200 transition text-center group">
                                                <div class="text-xl mb-1 group-hover:scale-105 transition-transform">🥗</div>
                                                <div class="text-[11px] font-bold text-slate-800 leading-tight">Salad Buah</div>
                                                <div class="text-[10px] font-semibold text-blue-600 mt-0.5">13k</div>
                                            </a>
                                            <a href="{{ route('menu.index', ['kategori' => 'susu-jelly']) }}" @click="openCartDrawer = false" class="p-2.5 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/70 hover:border-blue-200 transition text-center group">
                                                <div class="text-xl mb-1 group-hover:scale-105 transition-transform">🥤</div>
                                                <div class="text-[11px] font-bold text-slate-800 leading-tight">Susu Jelly</div>
                                                <div class="text-[10px] font-semibold text-blue-600 mt-0.5">12,5k</div>
                                            </a>
                                            <a href="{{ route('menu.index', ['kategori' => 'buah-potong']) }}" @click="openCartDrawer = false" class="p-2.5 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/70 hover:border-blue-200 transition text-center group">
                                                <div class="text-xl mb-1 group-hover:scale-105 transition-transform">🍉</div>
                                                <div class="text-[11px] font-bold text-slate-800 leading-tight">Buah Potong</div>
                                                <div class="text-[10px] font-semibold text-blue-600 mt-0.5">10k</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Filled Items List -->
                            <template x-for="(item, id) in cart.items" :key="id">
                                <div class="bg-white border border-slate-200/80 rounded-xl p-3 flex gap-3 items-center shadow-2xs hover:border-blue-200 transition">
                                    <img :src="item.image_url" :alt="item.name" class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl object-cover border border-slate-100 shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 truncate" x-text="item.name"></h4>
                                        <div class="text-xs font-extrabold text-blue-600 mt-0.5" x-text="item.formatted_price"></div>
                                        
                                        <!-- Add-on & Jadwal Badges -->
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            <template x-if="item.pickup_day && item.pickup_batch">
                                                <span class="inline-flex items-center px-1.5 py-0.2 rounded-md text-[9px] font-semibold bg-blue-100 text-blue-800 border border-blue-200" x-text="`📅 ${item.pickup_day} • ${item.pickup_batch}`"></span>
                                            </template>
                                            <template x-if="item.sugar_level">
                                                <span class="inline-flex items-center px-1.5 py-0.2 rounded-md text-[9px] font-semibold bg-blue-50 text-blue-700 border border-blue-200/70" x-text="item.sugar_level"></span>
                                            </template>
                                            <template x-if="item.jelly_topping">
                                                <span class="inline-flex items-center px-1.5 py-0.2 rounded-md text-[9px] font-semibold bg-slate-100 text-slate-700 border border-slate-200" x-text="item.jelly_topping"></span>
                                            </template>
                                        </div>

                                        <div class="text-[10px] text-slate-400 italic truncate mt-0.5" x-show="item.notes" x-text="'Catatan: ' + item.notes"></div>
                                        
                                        <!-- Stepper Qty Control -->
                                        <div class="flex items-center gap-1.5 mt-2">
                                            <div class="inline-flex items-center bg-slate-100 rounded-lg p-0.5 border border-slate-200/60 shadow-2xs">
                                                <button @click="updateCartQty(item.cart_key || item.id, item.quantity - 1)" 
                                                        type="button" 
                                                        class="w-6 h-6 rounded-md bg-white border border-slate-200 flex items-center justify-center text-slate-700 font-bold hover:bg-slate-100 active:scale-90 text-xs transition cursor-pointer">
                                                    -
                                                </button>
                                                <span class="w-7 text-center text-xs font-bold text-slate-900" x-text="item.quantity"></span>
                                                <button @click="if(!item.stock || item.quantity < item.stock) updateCartQty(item.cart_key || item.id, item.quantity + 1); else showToast(`Stok maksimal tercapai (${item.stock} porsi)`);" 
                                                        type="button" 
                                                        :disabled="item.stock && item.quantity >= item.stock"
                                                        :class="item.stock && item.quantity >= item.stock ? 'bg-slate-200 text-slate-400 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700 cursor-pointer shadow-2xs'"
                                                        class="w-6 h-6 rounded-md flex items-center justify-center active:scale-90 font-bold text-xs transition">
                                                    +
                                                </button>
                                            </div>
                                            <template x-if="item.stock && item.quantity >= item.stock">
                                                <span class="text-[9px] text-amber-600 font-semibold">(Maks stok)</span>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="text-right flex flex-col justify-between items-end h-16 sm:h-18 shrink-0">
                                        <button @click="removeFromCart(item.cart_key || item.id)" 
                                                type="button" 
                                                class="text-slate-300 hover:text-rose-500 p-1.5 rounded-lg hover:bg-rose-50 transition cursor-pointer" 
                                                title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                        <div class="text-xs sm:text-sm font-bold text-slate-900" x-text="item.formatted_subtotal"></div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Sticky Footer -->
                        <div class="border-t border-slate-100 p-4 sm:p-5 bg-white space-y-3 shrink-0" x-show="Object.keys(cart.items).length > 0">
                            <div class="flex justify-between items-center text-xs text-slate-600 font-medium">
                                <span x-text="`Subtotal (${cart.count} item)`">Subtotal</span>
                                <span class="text-base sm:text-lg font-black text-slate-900" x-text="cart.formatted_subtotal"></span>
                            </div>
                            
                            <div class="flex items-center gap-2 text-[11px] text-blue-700 bg-blue-50 px-3 py-2 rounded-xl border border-blue-100">
                                <i class="fa-solid fa-check text-blue-600"></i>
                                <span>Pilihan Delivery ke Kampus / Kos & Pickup Stand</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 pt-0.5">
                                <a href="{{ route('cart.index') }}" 
                                   @click="openCartDrawer = false"
                                   class="w-full text-center py-2.5 px-3 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition active:scale-95">
                                    Buka Keranjang
                                </a>
                                <a href="{{ route('checkout.index') }}" 
                                   @click="openCartDrawer = false"
                                   class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 px-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-sm transition active:scale-95">
                                    <span>Checkout</span>
                                    <i class="fa-solid fa-arrow-right text-xs"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Product Detail Quick View (Fresh Blue Minimalist) -->
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
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4 text-center">
                <div x-show="productModal.open"
                     x-transition:enter="ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     class="relative transform overflow-hidden rounded-t-[28px] sm:rounded-2xl bg-white text-left shadow-2xl transition-all w-full sm:max-w-md border border-slate-100 max-h-[90vh] flex flex-col">
                    
                    <!-- Close button -->
                    <button @click="closeProductModal()" class="absolute top-3 right-3 z-10 bg-white/90 backdrop-blur-xs text-slate-500 hover:text-slate-900 rounded-full w-8 h-8 flex items-center justify-center shadow-xs cursor-pointer">
                        <i class="fa-solid fa-xmark text-sm"></i>
                    </button>

                    <!-- Product Image -->
                    <div class="relative h-48 sm:h-56 w-full bg-slate-100 overflow-hidden shrink-0">
                        <img :src="productModal.item.image_url" :alt="productModal.item.name" class="w-full h-full object-cover" :class="productModal.item.is_sold_out ? 'grayscale contrast-75 brightness-95' : ''">
                        <span x-show="!productModal.item.is_sold_out && productModal.item.badge" 
                              x-text="productModal.item.badge" 
                              class="absolute top-3 left-3 bg-yellow-400 text-slate-900 font-bold text-[10px] px-2.5 py-0.5 rounded-md shadow-2xs">
                        </span>
                        <div x-show="productModal.item.is_sold_out" class="absolute inset-0 bg-slate-950/30 backdrop-blur-[1.5px] flex items-center justify-center">
                            <span class="bg-rose-600 text-white font-black text-xs px-3.5 py-1 rounded-full shadow-md tracking-wider uppercase">
                                Stok Habis
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 sm:p-6 overflow-y-auto space-y-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider" x-text="productModal.item.category"></span>
                                <h3 class="text-base sm:text-lg font-bold text-slate-900 mt-0.5" x-text="productModal.item.name"></h3>
                                <!-- Sisa Stok Info di Modal -->
                                <div class="mt-1">
                                    <template x-if="productModal.item.is_sold_out">
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-rose-600">
                                            ✕ Stok Habis
                                        </span>
                                    </template>
                                    <template x-if="!productModal.item.is_sold_out && productModal.item.stock <= 5">
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-md border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            <span x-text="`Sisa ${productModal.item.stock} porsi lagi`"></span>
                                        </span>
                                    </template>
                                    <template x-if="!productModal.item.is_sold_out && productModal.item.stock > 5">
                                        <span class="text-[10px] text-slate-500" x-text="`Tersedia: ${productModal.item.stock} porsi`"></span>
                                    </template>
                                </div>
                            </div>
                            <div class="text-base sm:text-lg font-black text-blue-600 shrink-0" x-text="productModal.item.formatted_price"></div>
                        </div>

                        <p class="text-xs text-slate-500 leading-relaxed" x-text="productModal.item.description"></p>

                        <!-- Jadwal Pengambilan Add-on Selection (Datepicker Kalender Senin & Kamis) -->
                        <div class="p-3.5 bg-blue-50/50 rounded-2xl border border-blue-100 space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] font-bold text-slate-800 flex items-center gap-1.5">
                                    <i class="fa-solid fa-calendar-days text-blue-600 text-xs"></i>
                                    <span>Pilih Tanggal Pengambilan</span>
                                </span>
                                <span class="text-[10px] bg-blue-100 text-blue-800 font-bold px-2 py-0.5 rounded-full" x-text="`${productModal.pickupDayName} • ${productModal.pickupBatch}`"></span>
                            </div>

                            <!-- Kalender Widget (Pilihan Khusus Senin & Kamis) -->
                            <div class="bg-white rounded-xl p-3 border border-slate-200/90 shadow-2xs">
                                
                                <!-- Header Bulan & Navigasi -->
                                <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-100">
                                    <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                                        <i class="fa-regular fa-calendar text-blue-600 text-xs"></i>
                                        <span x-text="currentMonthYear"></span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <button type="button" 
                                                @click="prevMonth()" 
                                                :disabled="isPrevMonthDisabled"
                                                :class="isPrevMonthDisabled ? 'text-slate-300 cursor-not-allowed' : 'text-slate-600 hover:bg-slate-100 cursor-pointer'"
                                                class="w-7 h-7 rounded-lg flex items-center justify-center transition"
                                                title="Bulan sebelumnya">
                                            <i class="fa-solid fa-chevron-left text-[11px]"></i>
                                        </button>
                                        <button type="button" 
                                                @click="nextMonth()" 
                                                class="w-7 h-7 rounded-lg hover:bg-slate-100 text-slate-600 flex items-center justify-center transition cursor-pointer"
                                                title="Bulan berikutnya">
                                            <i class="fa-solid fa-chevron-right text-[11px]"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Nama Hari dalam Seminggu (Senin & Kamis Diberi Tanda Khusus) -->
                                <div class="grid grid-cols-7 gap-1 text-center mb-1 text-[10px] font-bold">
                                    <div class="text-slate-400">Min</div>
                                    <div class="text-blue-600 font-extrabold flex flex-col items-center">
                                        <span>Sen</span>
                                        <span class="w-1 h-1 bg-blue-600 rounded-full mt-0.5"></span>
                                    </div>
                                    <div class="text-slate-400">Sel</div>
                                    <div class="text-slate-400">Rab</div>
                                    <div class="text-blue-600 font-extrabold flex flex-col items-center">
                                        <span>Kam</span>
                                        <span class="w-1 h-1 bg-blue-600 rounded-full mt-0.5"></span>
                                    </div>
                                    <div class="text-slate-400">Jum</div>
                                    <div class="text-slate-400">Sab</div>
                                </div>

                                <!-- Grid Tanggal -->
                                <div class="grid grid-cols-7 gap-1 text-center text-xs">
                                    <template x-for="(item, idx) in calDays" :key="idx">
                                        <div class="aspect-square flex items-center justify-center p-0.5">
                                            
                                            <!-- Hari yang BISA dipilih (Hanya Hari Senin & Kamis) -->
                                            <template x-if="item.isCurrentMonth && item.isSelectable">
                                                <button type="button"
                                                        @click="selectCalendarDate(item)"
                                                        class="w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-xs font-bold transition cursor-pointer select-none"
                                                        :class="productModal.pickupDate === item.dateStr 
                                                            ? 'bg-blue-600 text-white font-black shadow-md scale-105 ring-2 ring-blue-300' 
                                                            : 'bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-600 hover:text-white'">
                                                    <span x-text="item.day"></span>
                                                </button>
                                            </template>

                                            <!-- Hari yang TIDAK bisa dipilih (Bukan Senin/Kamis atau sudah lewat) -->
                                            <template x-if="item.isCurrentMonth && !item.isSelectable">
                                                <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-xs text-slate-300 cursor-not-allowed select-none"
                                                      x-text="item.day"></span>
                                            </template>

                                            <!-- Tanggal dari bulan sebelumnya / berikutnya -->
                                            <template x-if="!item.isCurrentMonth">
                                                <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-full flex items-center justify-center text-xs text-slate-200 cursor-default select-none"
                                                      x-text="item.day"></span>
                                            </template>

                                        </div>
                                    </template>
                                </div>

                                <!-- Bar Keterangan Tanggal Terpilih -->
                                <div class="mt-2.5 pt-2 border-t border-slate-100 flex items-center justify-between text-[10px] text-slate-500">
                                    <div class="flex items-center gap-1.5">
                                        <span class="w-2 h-2 rounded-full bg-blue-600 inline-block"></span>
                                        <span>Khusus hari <strong class="text-blue-700">Senin & Kamis</strong></span>
                                    </div>
                                    <div class="font-bold text-blue-600 truncate max-w-[170px]" x-text="productModal.pickupDay"></div>
                                </div>

                            </div>

                            <!-- Pilihan Batch Jam Pengambilan -->
                            <div>
                                <label class="text-[10px] font-bold text-slate-600 block mb-1.5">Pilih Jam / Batch:</label>
                                <div class="grid grid-cols-2 gap-1.5">
                                    <button type="button"
                                            @click="productModal.pickupBatch = 'Batch 1'"
                                            class="p-2 rounded-xl text-left border transition cursor-pointer select-none"
                                            :class="productModal.pickupBatch === 'Batch 1' ? 'bg-blue-600 text-white border-blue-600 shadow-2xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                        <div class="text-[11px] font-bold">Batch 1</div>
                                        <div class="text-[9px] mt-0.5" :class="productModal.pickupBatch === 'Batch 1' ? 'text-blue-100' : 'text-slate-500'" x-text="productModal.pickupDayName === 'Senin' ? 'Pukul 11.00 AM' : 'Pukul 09.00 AM'"></div>
                                    </button>
                                    <button type="button"
                                            @click="productModal.pickupBatch = 'Batch 2'"
                                            class="p-2 rounded-xl text-left border transition cursor-pointer select-none"
                                            :class="productModal.pickupBatch === 'Batch 2' ? 'bg-blue-600 text-white border-blue-600 shadow-2xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                        <div class="text-[11px] font-bold">Batch 2</div>
                                        <div class="text-[9px] mt-0.5" :class="productModal.pickupBatch === 'Batch 2' ? 'text-blue-100' : 'text-slate-500'" x-text="productModal.pickupDayName === 'Senin' ? 'Pukul 03.00 PM' : 'Pukul 02.00 PM'"></div>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Susu Jelly Add-on Section (Sugar Level & Topping Jelly) -->
                        <template x-if="productModal.item.category_slug === 'susu-jelly'">
                            <div class="p-3.5 bg-blue-50/60 rounded-xl border border-blue-100 space-y-3.5">
                                
                                <!-- Sugar Level Selection -->
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="text-[11px] font-bold text-slate-800 flex items-center gap-1">
                                            <span>Level Gula:</span>
                                            <span class="text-blue-600 font-extrabold" x-text="productModal.sugarLevel"></span>
                                        </label>
                                        <span class="text-[10px] text-slate-400">Pilih salah satu</span>
                                    </div>
                                    <div class="grid grid-cols-4 gap-1 sm:gap-1.5">
                                        <button type="button"
                                                @click="productModal.sugarLevel = 'No sugar'"
                                                class="py-2 px-1 rounded-lg text-[10px] sm:text-[11px] font-semibold border transition text-center cursor-pointer select-none"
                                                :class="productModal.sugarLevel === 'No sugar' ? 'bg-blue-600 text-white border-blue-600 shadow-2xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            No sugar
                                        </button>
                                        <button type="button"
                                                @click="productModal.sugarLevel = 'Less sugar'"
                                                class="py-2 px-1 rounded-lg text-[10px] sm:text-[11px] font-semibold border transition text-center cursor-pointer select-none"
                                                :class="productModal.sugarLevel === 'Less sugar' ? 'bg-blue-600 text-white border-blue-600 shadow-2xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            Less sugar
                                        </button>
                                        <button type="button"
                                                @click="productModal.sugarLevel = 'Normal sugar'"
                                                class="py-2 px-1 rounded-lg text-[10px] sm:text-[11px] font-semibold border transition text-center cursor-pointer select-none"
                                                :class="productModal.sugarLevel === 'Normal sugar' ? 'bg-blue-600 text-white border-blue-600 shadow-2xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            Normal sugar
                                        </button>
                                        <button type="button"
                                                @click="productModal.sugarLevel = 'extra sugar'"
                                                class="py-2 px-1 rounded-lg text-[10px] sm:text-[11px] font-semibold border transition text-center cursor-pointer select-none"
                                                :class="(productModal.sugarLevel === 'extra sugar' || productModal.sugarLevel === 'Extra sugar') ? 'bg-blue-600 text-white border-blue-600 shadow-2xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            extra sugar
                                        </button>
                                    </div>
                                </div>

                                <!-- Topping Jelly Selection -->
                                <div>
                                    <div class="flex items-center justify-between mb-1.5">
                                        <label class="text-[11px] font-bold text-slate-800 flex items-center gap-1">
                                            <span>Topping Jelly:</span>
                                            <span class="text-blue-600 font-extrabold" x-text="productModal.jellyTopping"></span>
                                        </label>
                                        <span class="text-[10px] text-slate-400">Pilih varian</span>
                                    </div>
                                    <div class="grid grid-cols-3 gap-1.5">
                                        <button type="button"
                                                @click="productModal.jellyTopping = 'Tanpa jelly'"
                                                class="py-2 px-1 rounded-lg text-[11px] font-semibold border transition text-center cursor-pointer select-none"
                                                :class="productModal.jellyTopping === 'Tanpa jelly' ? 'bg-blue-600 text-white border-blue-600 shadow-2xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            Tanpa jelly
                                        </button>
                                        <button type="button"
                                                @click="productModal.jellyTopping = 'Normal jelly'"
                                                class="py-2 px-1 rounded-lg text-[11px] font-semibold border transition text-center cursor-pointer select-none"
                                                :class="productModal.jellyTopping === 'Normal jelly' ? 'bg-blue-600 text-white border-blue-600 shadow-2xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            Normal jelly
                                        </button>
                                        <button type="button"
                                                @click="productModal.jellyTopping = 'extra jelly'"
                                                class="py-2 px-1 rounded-lg text-[11px] font-semibold border transition text-center cursor-pointer select-none"
                                                :class="productModal.jellyTopping === 'extra jelly' ? 'bg-blue-600 text-white border-blue-600 shadow-2xs' : 'bg-white text-slate-700 border-slate-200 hover:bg-slate-100'">
                                            extra jelly
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </template>

                        <!-- Notes / Special request -->
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-700 mb-1">Catatan Khusus (Opsional)</label>
                            <input type="text" 
                                   x-model="productModal.notes"
                                   placeholder="Contoh: jangan terlalu manis, tambah sedotan..." 
                                   class="w-full text-xs px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <!-- Quantity Selector & Action -->
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-3">
                            <template x-if="!productModal.item.is_sold_out">
                                <div class="flex items-center border border-slate-200 rounded-xl p-0.5 bg-slate-50">
                                    <button @click="if(productModal.qty > 1) productModal.qty--" type="button" class="w-8 h-8 rounded-lg bg-white text-slate-700 font-bold hover:bg-slate-100 transition flex items-center justify-center shadow-2xs cursor-pointer text-xs">-</button>
                                    <span class="w-9 text-center text-xs font-bold text-slate-900" x-text="productModal.qty">1</span>
                                    <button @click="if(!productModal.item.stock || productModal.qty < productModal.item.stock) productModal.qty++; else showToast(`Maksimal pesanan ${productModal.item.stock} porsi`);" 
                                            :disabled="productModal.item.stock && productModal.qty >= productModal.item.stock"
                                            :class="productModal.item.stock && productModal.qty >= productModal.item.stock ? 'bg-slate-200 text-slate-400 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700 cursor-pointer shadow-2xs'"
                                            type="button" 
                                            class="w-8 h-8 rounded-lg transition flex items-center justify-center font-bold text-xs">+</button>
                                </div>
                            </template>

                            <button x-show="!productModal.item.is_sold_out"
                                    @click="submitModalToCart()" 
                                    type="button" 
                                    class="grow bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-3 px-4 rounded-xl shadow-xs transition flex items-center justify-center gap-2 cursor-pointer active:scale-95">
                                <i class="fa-solid fa-plus text-xs"></i>
                                <span>Tambah ke Keranjang</span>
                                <span class="text-blue-100 font-semibold" x-show="productModal.item.price" x-text="`• Rp ${new Intl.NumberFormat('id-ID').format(productModal.item.price * productModal.qty)}`"></span>
                            </button>

                            <button x-show="productModal.item.is_sold_out"
                                    type="button" 
                                    disabled
                                    class="w-full bg-slate-100 text-slate-400 font-bold text-xs py-3 px-4 rounded-xl flex items-center justify-center gap-2 cursor-not-allowed select-none">
                                <i class="fa-solid fa-ban text-xs"></i>
                                <span>Menu Sedang Habis (Sold Out)</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification (Always Perfectly Centered on Mobile & Web) -->
    <div class="fixed top-20 sm:top-24 inset-x-0 z-50 flex justify-center pointer-events-none px-4">
        <div x-show="toast.show" 
             x-cloak
             x-transition:enter="transition cubic-bezier(0.16, 1, 0.3, 1) duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
             class="pointer-events-auto bg-slate-900/95 text-white py-2.5 px-4 sm:px-5 rounded-2xl shadow-2xl flex items-center gap-3 border border-slate-700/60 backdrop-blur-md max-w-sm sm:max-w-md w-auto">
            <div class="w-7 h-7 rounded-xl flex items-center justify-center shrink-0 shadow-xs"
                 :class="toast.isWarning ? 'bg-amber-500 text-white' : 'bg-blue-600 text-white'">
                <template x-if="toast.isWarning">
                    <i class="fa-solid fa-triangle-exclamation text-xs"></i>
                </template>
                <template x-if="!toast.isWarning">
                    <i class="fa-solid fa-check text-xs font-black"></i>
                </template>
            </div>
            <div class="text-xs sm:text-sm font-semibold text-slate-100 select-none whitespace-nowrap" x-text="toast.message">
                Ditambahkan ke keranjang
            </div>
            <button @click="toast.show = false" 
                    type="button"
                    class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800/60 transition cursor-pointer shrink-0 ml-1">
                <i class="fa-solid fa-xmark text-xs"></i>
            </button>
        </div>
    </div>

    <!-- Modal Jadwal Pengambilan (Batch Ready) -->
    <div x-show="openScheduleModal" 
         x-cloak
         class="relative z-50" 
         role="dialog" 
         aria-modal="true">
        <div x-show="openScheduleModal"
             x-transition:enter="ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             @click="openScheduleModal = false"
             class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4 text-center">
                <div x-show="openScheduleModal"
                     x-transition:enter="ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-8 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     class="relative transform overflow-hidden rounded-t-[28px] sm:rounded-2xl bg-white text-left shadow-2xl transition-all w-full sm:max-w-md border border-slate-100 p-5 sm:p-6 space-y-4">
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                                <i class="fa-solid fa-clock text-base"></i>
                            </div>
                            <div>
                                <h3 class="text-sm sm:text-base font-bold text-slate-900">Jadwal Pengambilan</h3>
                                <p class="text-[11px] text-slate-400">Batch Ready FRUVIT.ID</p>
                            </div>
                        </div>
                        <button @click="openScheduleModal = false" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-400 hover:text-slate-600 flex items-center justify-center transition cursor-pointer">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </button>
                    </div>

                    <!-- Schedule Content -->
                    <div class="space-y-3">
                        <!-- Card Senin -->
                        <div class="p-3.5 rounded-xl bg-blue-50/60 border border-blue-100 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-blue-600 text-white text-xs font-black">
                                    <i class="fa-regular fa-calendar-check text-[10px]"></i>
                                    <span>Senin</span>
                                </span>
                                <span class="text-[10px] font-semibold text-blue-600">2 Batch Tersedia</span>
                            </div>
                            <ul class="space-y-1.5 text-xs text-slate-700 pl-1">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                    <span><strong>Batch 1:</strong> Ready pukul 11.00 AM</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                    <span><strong>Batch 2:</strong> Ready pukul 03.00 PM</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Card Kamis -->
                        <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/80 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md bg-slate-800 text-white text-xs font-black">
                                    <i class="fa-regular fa-calendar-check text-[10px]"></i>
                                    <span>Kamis</span>
                                </span>
                                <span class="text-[10px] font-semibold text-slate-500">2 Batch Tersedia</span>
                            </div>
                            <ul class="space-y-1.5 text-xs text-slate-700 pl-1">
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-800"></span>
                                    <span><strong>Batch 1:</strong> Ready pukul 09.00 AM</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-800"></span>
                                    <span><strong>Batch 2:</strong> Ready pukul 02.00 PM</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Notice / Info footer -->
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100 text-[11px] text-slate-500 leading-relaxed">
                        💡 <em>Semua pesanan diracik fresh dan dingin. Anda dapat mengambil pesanan di stand atau dikirimkan sesuai jam batch di atas.</em>
                    </div>

                    <!-- Button -->
                    <button type="button" 
                            @click="openScheduleModal = false" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-2.5 rounded-xl transition cursor-pointer shadow-2xs">
                        Mengerti
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer (Fresh Blue Minimalist) -->
    <footer class="bg-white border-t border-slate-200/90 text-slate-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- Col 1: Brand Info -->
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/logo-fruvit.jpg') }}" alt="FRUVIT.ID" class="h-10 w-auto rounded-xl object-contain">
                    </div>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-sm leading-relaxed">
                        FRUVIT.ID – Fresh Fruit, Better Mood! Penjualan salad buah segar keju melimpah, susu jelly varian nikmat, dan buah potong dingin higienis.
                    </p>
                    <div class="inline-flex items-center gap-2 text-xs text-blue-700 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100 font-semibold">
                        <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                        <span>Menerima Pemesanan Pickup & Delivery Kampus</span>
                    </div>
                </div>

                <!-- Col 2: Navigasi -->
                <div>
                    <h3 class="text-xs font-bold text-slate-900 tracking-wider uppercase mb-3">Navigasi</h3>
                    <ul class="space-y-2.5 text-xs font-medium">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a></li>
                        <li><a href="{{ route('menu.index') }}" class="hover:text-blue-600 transition">Our Menu</a></li>
                        <li><a href="{{ route('home') }}#tentang" class="hover:text-blue-600 transition">Tentang Kami</a></li>
                        <li><a href="{{ route('home') }}#kontak" class="hover:text-blue-600 transition">Kontak</a></li>
                        <li><a href="{{ route('order.track') }}" class="hover:text-blue-600 transition">Cek Status Pesanan</a></li>
                    </ul>
                </div>

                <!-- Col 3: Stand & Kontak -->
                <div id="kontak">
                    <h3 class="text-xs font-bold text-slate-900 tracking-wider uppercase mb-3">Kontak & Lokasi</h3>
                    <ul class="space-y-2 text-xs text-slate-500">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-blue-600 mt-0.5 text-xs"></i>
                            <span>Stand Kewirausahaan FRUVIT.ID (Food Court Kampus)</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-brands fa-whatsapp text-blue-600 text-xs"></i>
                            <span>WhatsApp: 0812-3456-7890</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-money-bill-wave text-blue-600 text-xs"></i>
                            <span>Metode: QRIS & Cash</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-100 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-2">
                <div>&copy; {{ date('Y') }} FRUVIT.ID. All rights reserved.</div>
                <div class="text-slate-500">Fresh Fruit, Better Mood!</div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js Store & App Logic -->
    <script>
        function fruvitApp() {
            return {
                openCartDrawer: false,
                openScheduleModal: false,
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
                    pickupDate: '',
                    pickupDay: '',
                    pickupDayName: 'Senin',
                    pickupBatch: 'Batch 1',
                    item: {}
                },
                calYear: new Date().getFullYear(),
                calMonth: new Date().getMonth(),
                calDays: [],
                toast: {
                    show: false,
                    isWarning: false,
                    message: ''
                },
                toastTimeout: null,

                get currentMonthYear() {
                    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    return `${months[this.calMonth]} ${this.calYear}`;
                },

                get isPrevMonthDisabled() {
                    const now = new Date();
                    return this.calYear < now.getFullYear() || (this.calYear === now.getFullYear() && this.calMonth <= now.getMonth());
                },

                prevMonth() {
                    if (this.isPrevMonthDisabled) return;
                    if (this.calMonth === 0) {
                        this.calMonth = 11;
                        this.calYear--;
                    } else {
                        this.calMonth--;
                    }
                    this.renderCalendar();
                },

                nextMonth() {
                    if (this.calMonth === 11) {
                        this.calMonth = 0;
                        this.calYear++;
                    } else {
                        this.calMonth++;
                    }
                    this.renderCalendar();
                },

                formatDateIso(d) {
                    const y = d.getFullYear();
                    const m = String(d.getMonth() + 1).padStart(2, '0');
                    const day = String(d.getDate()).padStart(2, '0');
                    return `${y}-${m}-${day}`;
                },

                formatPickupDateLabel(d) {
                    const dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    return `${dayNames[d.getDay()]}, ${d.getDate()} ${monthNames[d.getMonth()]} ${d.getFullYear()}`;
                },

                initCalendar() {
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    // Cari hari Senin (1) atau Kamis (4) terdekat dari hari ini
                    let target = new Date(today);
                    for (let i = 0; i < 14; i++) {
                        const check = new Date(today);
                        check.setDate(today.getDate() + i);
                        if (check.getDay() === 1 || check.getDay() === 4) {
                            target = check;
                            break;
                        }
                    }

                    this.calYear = target.getFullYear();
                    this.calMonth = target.getMonth();

                    const dayOfWeek = target.getDay();
                    this.productModal.pickupDayName = (dayOfWeek === 1) ? 'Senin' : 'Kamis';
                    this.productModal.pickupDate = this.formatDateIso(target);
                    this.productModal.pickupDay = this.formatPickupDateLabel(target);

                    this.renderCalendar();
                },

                renderCalendar() {
                    const year = this.calYear;
                    const month = this.calMonth;
                    const firstDayIndex = new Date(year, month, 1).getDay(); // 0 = Min, 1 = Sen
                    const daysInMonth = new Date(year, month + 1, 0).getDate();
                    const daysInPrevMonth = new Date(year, month, 0).getDate();

                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    const days = [];

                    // Hari dari bulan sebelumnya
                    for (let i = firstDayIndex - 1; i >= 0; i--) {
                        days.push({
                            day: daysInPrevMonth - i,
                            isCurrentMonth: false,
                            isSelectable: false,
                            dateStr: ''
                        });
                    }

                    // Hari pada bulan saat ini
                    for (let d = 1; d <= daysInMonth; d++) {
                        const dateObj = new Date(year, month, d);
                        dateObj.setHours(0, 0, 0, 0);
                        const dayOfWeek = dateObj.getDay();

                        // HANYA hari Senin (1) dan Kamis (4) serta hari ini atau masa depan
                        const isMonOrThu = (dayOfWeek === 1 || dayOfWeek === 4);
                        const isSelectable = isMonOrThu && (dateObj >= today);
                        const dateStr = this.formatDateIso(dateObj);

                        days.push({
                            day: d,
                            year: year,
                            month: month,
                            dayOfWeek: dayOfWeek,
                            isCurrentMonth: true,
                            isSelectable: isSelectable,
                            dateStr: dateStr
                        });
                    }

                    // Hari dari bulan berikutnya untuk melengkapi baris 7 kolom
                    const remaining = 7 - (days.length % 7);
                    if (remaining < 7) {
                        for (let i = 1; i <= remaining; i++) {
                            days.push({
                                day: i,
                                isCurrentMonth: false,
                                isSelectable: false,
                                dateStr: ''
                            });
                        }
                    }

                    this.calDays = days;
                },

                selectCalendarDate(item) {
                    if (!item.isSelectable) return;
                    const dateObj = new Date(item.year, item.month, item.day);
                    this.productModal.pickupDate = item.dateStr;
                    this.productModal.pickupDay = this.formatPickupDateLabel(dateObj);
                    this.productModal.pickupDayName = (item.dayOfWeek === 1) ? 'Senin' : 'Kamis';
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
                    const isWarn = typeof msg === 'string' && (msg.includes('⚠️') || msg.toLowerCase().includes('maks') || msg.toLowerCase().includes('gagal') || msg.toLowerCase().includes('stok'));
                    this.toast.isWarning = isWarn;
                    this.toast.message = typeof msg === 'string' ? msg.replace(/^[✅⚠️❌]\s*/, '') : msg;
                    this.toast.show = true;
                    if (this.toastTimeout) {
                        clearTimeout(this.toastTimeout);
                    }
                    this.toastTimeout = setTimeout(() => {
                        this.toast.show = false;
                    }, 3000);
                },

                quickAddToCart(productId) {
                    this.openProductDetail(productId);
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
                            this.productModal.pickupBatch = 'Batch 1';
                            this.initCalendar();
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
                            jelly_topping: isSusuJelly ? this.productModal.jellyTopping : null,
                            pickup_day: this.productModal.pickupDay,
                            pickup_batch: this.productModal.pickupBatch
                        })
                    })
                    .then(res => res.json().then(data => ({ status: res.status, ok: res.ok, body: data })))
                    .then(result => {
                        if (result.ok && result.body.cart) {
                            this.cart = result.body.cart;
                            this.closeProductModal();
                            this.showToast('Ditambahkan ke keranjang');
                        } else {
                            this.showToast('⚠️ ' + (result.body.message || 'Gagal menambahkan pesanan'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        this.showToast('⚠️ Terjadi kesalahan jaringan');
                    });
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
                    .then(res => res.json().then(data => ({ status: res.status, ok: res.ok, body: data })))
                    .then(result => {
                        if (result.body && result.body.cart) {
                            this.cart = result.body.cart;
                        }
                        if (!result.ok && result.body.message) {
                            this.showToast('⚠️ ' + result.body.message);
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