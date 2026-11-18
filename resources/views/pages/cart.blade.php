@extends('layouts.app')

@section('title', 'Keranjang Belanja - FRUVIT.ID')

@section('content')
<div class="py-3 sm:py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Header (Compact) -->
        <div class="mb-3.5 sm:mb-6">
            <div class="flex items-center gap-1.5 text-[11px] text-slate-400 font-bold mb-1">
                <a href="{{ route('home') }}" class="hover:text-emerald-600">Beranda</a>
                <span>/</span>
                <a href="{{ route('menu.index') }}" class="hover:text-emerald-600">Menu</a>
                <span>/</span>
                <span class="text-slate-700">Keranjang</span>
            </div>
            <h1 class="text-xl sm:text-3xl font-black text-slate-900">Keranjang Pesanan</h1>
        </div>

        <template x-if="Object.keys(cart.items).length === 0">
            <div class="text-center py-10 sm:py-16 bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-10 shadow-xs max-w-md mx-auto">
                <div class="relative w-24 h-24 mx-auto mb-4 flex items-center justify-center rounded-3xl bg-gradient-to-tr from-emerald-50 via-teal-50 to-amber-50 border border-emerald-100 shadow-sm">
                    <span class="text-5xl">🥗</span>
                    <span class="absolute -top-1.5 -right-1.5 w-7 h-7 rounded-full bg-yellow-400 text-emerald-950 font-black text-sm flex items-center justify-center shadow-xs">✨</span>
                </div>
                <h2 class="text-lg sm:text-2xl font-black text-slate-900">Keranjang Belanja Masih Kosong</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2 max-w-xs mx-auto leading-relaxed">
                    Yuk pilih salad buah segar, susu jelly manis creamy, atau buah potong dingin favoritmu!
                </p>
                <div class="mt-5">
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-black text-xs sm:text-sm px-6 py-3.5 rounded-2xl shadow-md shadow-emerald-600/20 active:scale-95 transition">
                        <span>Pilih Menu Sekarang</span>
                        <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Category quick shortcuts -->
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <div class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mb-3">Pilihan Menu Terfavorit:</div>
                    <div class="grid grid-cols-3 gap-2.5">
                        <a href="{{ route('menu.index', ['kategori' => 'salad-buah']) }}" class="p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/70 hover:border-emerald-200 transition text-center group">
                            <div class="text-2xl mb-1 group-hover:scale-110 transition-transform">🥗</div>
                            <div class="text-xs font-extrabold text-slate-800 leading-tight">Salad Buah</div>
                            <div class="text-[10px] font-bold text-emerald-600 mt-0.5">13k</div>
                        </a>
                        <a href="{{ route('menu.index', ['kategori' => 'susu-jelly']) }}" class="p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/70 hover:border-emerald-200 transition text-center group">
                            <div class="text-2xl mb-1 group-hover:scale-110 transition-transform">🥤</div>
                            <div class="text-xs font-extrabold text-slate-800 leading-tight">Susu Jelly</div>
                            <div class="text-[10px] font-bold text-emerald-600 mt-0.5">12,5k</div>
                        </a>
                        <a href="{{ route('menu.index', ['kategori' => 'buah-potong']) }}" class="p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/70 hover:border-emerald-200 transition text-center group">
                            <div class="text-2xl mb-1 group-hover:scale-110 transition-transform">🍉</div>
                            <div class="text-xs font-extrabold text-slate-800 leading-tight">Buah Potong</div>
                            <div class="text-[10px] font-bold text-emerald-600 mt-0.5">10k</div>
                        </a>
                    </div>
                </div>
            </div>
        </template>

        <template x-if="Object.keys(cart.items).length > 0">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-8 items-start">
                
                <!-- Left: Items List -->
                <div class="lg:col-span-8 space-y-3 sm:space-y-4">
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-3.5 sm:p-6 shadow-2xs">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                            <h2 class="text-xs sm:text-base font-extrabold text-slate-900" x-text="`Daftar Pesanan (${cart.count} item)`"></h2>
                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                                @csrf
                                <button type="submit" class="text-[11px] text-rose-600 hover:text-rose-800 font-bold flex items-center gap-1 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    <span>Kosongkan</span>
                                </button>
                            </form>
                        </div>

                        <!-- Item Card Repeater (Compact on Mobile) -->
                        <div class="space-y-2.5 sm:space-y-4">
                            <template x-for="(item, id) in cart.items" :key="id">
                                <div class="p-2.5 sm:p-4 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200/70 flex items-center justify-between gap-2.5">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <img :src="item.image_url" :alt="item.name" class="w-14 h-14 sm:w-20 sm:h-20 rounded-xl sm:rounded-2xl object-cover border border-slate-200 shrink-0">
                                        <div class="min-w-0">
                                            <span class="text-[9px] sm:text-[10px] font-bold text-emerald-600 uppercase" x-text="item.category_name"></span>
                                            <h3 class="text-xs sm:text-sm font-extrabold text-slate-900 truncate" x-text="item.name"></h3>
                                            <div class="text-[11px] sm:text-xs font-black text-emerald-600 mt-0.5" x-text="item.formatted_price"></div>
                                            
                                            <!-- Add-ons (Sugar Level & Jelly Topping) -->
                                            <template x-if="item.sugar_level || item.jelly_topping">
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    <span x-show="item.sugar_level" class="inline-flex items-center px-1.5 py-0.2 rounded-md text-[9px] font-bold bg-amber-100 text-amber-800 border border-amber-200" x-text="item.sugar_level"></span>
                                                    <span x-show="item.jelly_topping" class="inline-flex items-center px-1.5 py-0.2 rounded-md text-[9px] font-bold bg-purple-100 text-purple-800 border border-purple-200" x-text="item.jelly_topping"></span>
                                                </div>
                                            </template>

                                            <div class="text-[10px] text-slate-400 italic truncate mt-0.5" x-show="item.notes" x-text="'Catatan: ' + item.notes"></div>
                                        </div>
                                    </div>

                                    <!-- Controls Row -->
                                    <div class="flex items-center gap-2 sm:gap-5 shrink-0">
                                        <!-- Qty Button Group -->
                                        <div class="flex items-center bg-white border border-slate-300 rounded-lg sm:rounded-xl p-0.5 shadow-2xs">
                                            <button @click="updateCartQty(item.cart_key || item.id, item.quantity - 1)" 
                                                    type="button" 
                                                    class="w-5 h-5 sm:w-7 sm:h-7 rounded text-slate-700 font-black hover:bg-slate-100 flex items-center justify-center transition cursor-pointer text-[11px] sm:text-xs">
                                                -
                                            </button>
                                            <span class="w-6 sm:w-8 text-center text-xs font-black text-slate-900" x-text="item.quantity"></span>
                                            <button @click="updateCartQty(item.cart_key || item.id, item.quantity + 1)" 
                                                    type="button" 
                                                    class="w-5 h-5 sm:w-7 sm:h-7 rounded bg-emerald-600 text-white font-black hover:bg-emerald-700 flex items-center justify-center transition cursor-pointer text-[11px] sm:text-xs">
                                                +
                                            </button>
                                        </div>

                                        <div class="text-right">
                                             <div class="text-xs sm:text-sm font-black text-slate-900" x-text="item.formatted_subtotal"></div>
                                        </div>

                                        <button @click="removeFromCart(item.cart_key || item.id)" 
                                                type="button" 
                                                class="text-slate-400 hover:text-rose-600 p-1 rounded-lg hover:bg-rose-50 transition cursor-pointer"
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Back to Menu Button -->
                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-1 text-[11px] sm:text-xs font-bold text-emerald-700 hover:text-emerald-800 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                <span>Tambah Menu Lainnya</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary Box & Checkout Button -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs sticky top-20 space-y-3 sm:space-y-4">
                        <h2 class="text-sm sm:text-base font-extrabold text-slate-900 pb-2 border-b border-slate-100">
                            Ringkasan Pembayaran
                        </h2>

                        <div class="space-y-2 text-xs sm:text-sm">
                            <div class="flex justify-between text-slate-600">
                                <span>Total Item</span>
                                <span class="font-extrabold text-slate-900" x-text="`${cart.count} pcs`"></span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal Menu</span>
                                <span class="font-extrabold text-slate-900" x-text="cart.formatted_subtotal"></span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Pengambilan</span>
                                <span class="font-medium text-slate-500 text-[11px]">Pilih di Checkout</span>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-200 flex justify-between items-center">
                            <div>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total Tagihan</span>
                                <span class="text-lg sm:text-xl font-black text-emerald-600" x-text="cart.formatted_subtotal"></span>
                            </div>
                            <span class="text-[10px] text-slate-400">*Belum ongkir</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" 
                           class="w-full inline-flex items-center justify-center gap-1.5 bg-gradient-to-r from-emerald-600 via-emerald-500 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-black text-xs sm:text-sm py-3 sm:py-3.5 px-4 rounded-xl sm:rounded-2xl shadow-md hover:shadow-lg transition cursor-pointer">
                            <span>Lanjut ke Checkout</span>
                            <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

            </div>
        </template>

    </div>
</div>
@endsection
