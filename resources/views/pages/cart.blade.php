@extends('layouts.app')

@section('title', 'Keranjang Belanja - FRUVIT.ID')

@section('content')
<div class="py-4 sm:py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Header -->
        <div class="mb-4 sm:mb-6">
            <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium mb-1">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                <span>/</span>
                <a href="{{ route('menu.index') }}" class="hover:text-blue-600">Menu</a>
                <span>/</span>
                <span class="text-slate-700">Keranjang</span>
            </div>
            <h1 class="text-xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Keranjang Belanja</h1>
        </div>

        <!-- Empty State -->
        <template x-if="Object.keys(cart.items).length === 0">
            <div class="text-center py-12 sm:py-16 bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-6 sm:p-10 shadow-xs max-w-md mx-auto">
                <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 text-3xl">
                    🥤
                </div>
                <h2 class="text-lg sm:text-xl font-bold text-slate-900">Keranjang Belanja Masih Kosong</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2 max-w-xs mx-auto leading-relaxed">
                    Yuk pilih salad buah segar, susu jelly nikmat, atau buah potong dingin favoritmu!
                </p>
                <div class="mt-5">
                    <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm px-6 py-3 rounded-xl shadow-xs active:scale-95 transition">
                        <span>Pilih Menu Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Category quick shortcuts -->
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Pilihan Menu Terfavorit:</div>
                    <div class="grid grid-cols-3 gap-2">
                        <a href="{{ route('menu.index', ['kategori' => 'salad-buah']) }}" class="p-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/70 hover:border-blue-200 transition text-center group">
                            <div class="text-2xl mb-1 group-hover:scale-105 transition-transform">🥗</div>
                            <div class="text-xs font-bold text-slate-800 leading-tight">Salad Buah</div>
                            <div class="text-[10px] font-semibold text-blue-600 mt-0.5">13k</div>
                        </a>
                        <a href="{{ route('menu.index', ['kategori' => 'susu-jelly']) }}" class="p-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/70 hover:border-blue-200 transition text-center group">
                            <div class="text-2xl mb-1 group-hover:scale-105 transition-transform">🥤</div>
                            <div class="text-xs font-bold text-slate-800 leading-tight">Susu Jelly</div>
                            <div class="text-[10px] font-semibold text-blue-600 mt-0.5">12,5k</div>
                        </a>
                        <a href="{{ route('menu.index', ['kategori' => 'buah-potong']) }}" class="p-3 rounded-xl bg-slate-50 hover:bg-blue-50 border border-slate-200/70 hover:border-blue-200 transition text-center group">
                            <div class="text-2xl mb-1 group-hover:scale-105 transition-transform">🍉</div>
                            <div class="text-xs font-bold text-slate-800 leading-tight">Buah Potong</div>
                            <div class="text-[10px] font-semibold text-blue-600 mt-0.5">10k</div>
                        </a>
                    </div>
                </div>
            </div>
        </template>

        <!-- Cart Filled State -->
        <template x-if="Object.keys(cart.items).length > 0">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8 items-start">
                
                <!-- Left: Items List -->
                <div class="lg:col-span-8 space-y-3 sm:space-y-4">
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs">
                        <div class="flex items-center justify-between pb-3.5 border-b border-slate-100 mb-4">
                            <h2 class="text-sm sm:text-base font-bold text-slate-900" x-text="`Daftar Pesanan (${cart.count} item)`"></h2>
                            <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                                @csrf
                                <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-semibold flex items-center gap-1 cursor-pointer">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    <span>Kosongkan</span>
                                </button>
                            </form>
                        </div>

                        <!-- Item Card Repeater -->
                        <div class="space-y-3">
                            <template x-for="(item, id) in cart.items" :key="id">
                                <div class="p-3 sm:p-4 rounded-xl bg-slate-50 border border-slate-200/70 flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <img :src="item.image_url" :alt="item.name" class="w-14 h-14 sm:w-18 sm:h-18 rounded-xl object-cover border border-slate-200 shrink-0">
                                        <div class="min-w-0">
                                            <span class="text-[9px] sm:text-[10px] font-bold text-blue-600 uppercase" x-text="item.category_name"></span>
                                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 truncate" x-text="item.name"></h3>
                                            <div class="text-xs sm:text-sm font-black text-blue-600 mt-0.5" x-text="item.formatted_price"></div>
                                            
                                            <!-- Add-ons (Sugar Level & Jelly Topping) -->
                                            <template x-if="item.sugar_level || item.jelly_topping">
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    <span x-show="item.sugar_level" class="inline-flex items-center px-1.5 py-0.2 rounded-md text-[9px] font-semibold bg-blue-50 text-blue-700 border border-blue-200/70" x-text="item.sugar_level"></span>
                                                    <span x-show="item.jelly_topping" class="inline-flex items-center px-1.5 py-0.2 rounded-md text-[9px] font-semibold bg-slate-100 text-slate-700 border border-slate-200" x-text="item.jelly_topping"></span>
                                                </div>
                                            </template>

                                            <div class="text-[10px] text-slate-400 italic truncate mt-0.5" x-show="item.notes" x-text="'Catatan: ' + item.notes"></div>
                                        </div>
                                    </div>

                                    <!-- Controls Row -->
                                    <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                                        <!-- Qty Stepper -->
                                        <div class="flex items-center bg-white border border-slate-200 rounded-lg p-0.5 shadow-2xs">
                                            <button @click="updateCartQty(item.cart_key || item.id, item.quantity - 1)" 
                                                    type="button" 
                                                    class="w-6 h-6 rounded text-slate-700 font-bold hover:bg-slate-100 flex items-center justify-center transition cursor-pointer text-xs">
                                                -
                                            </button>
                                            <span class="w-7 text-center text-xs font-bold text-slate-900" x-text="item.quantity"></span>
                                            <button @click="updateCartQty(item.cart_key || item.id, item.quantity + 1)" 
                                                    type="button" 
                                                    class="w-6 h-6 rounded bg-blue-600 text-white font-bold hover:bg-blue-700 flex items-center justify-center transition cursor-pointer text-xs shadow-2xs">
                                                +
                                            </button>
                                        </div>

                                        <div class="text-right min-w-[70px]">
                                             <div class="text-xs sm:text-sm font-bold text-slate-900" x-text="item.formatted_subtotal"></div>
                                        </div>

                                        <button @click="removeFromCart(item.cart_key || item.id)" 
                                                type="button" 
                                                class="text-slate-300 hover:text-rose-600 p-1 rounded-lg hover:bg-rose-50 transition cursor-pointer"
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Back to Menu Button -->
                        <div class="mt-5 pt-3.5 border-t border-slate-100 flex items-center justify-between">
                            <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:text-blue-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                                <span>Tambah Menu Lainnya</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary Box & Checkout Button -->
                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-2xs sticky top-24 space-y-4">
                        <h2 class="text-sm sm:text-base font-bold text-slate-900 pb-2.5 border-b border-slate-100">
                            Ringkasan Pembayaran
                        </h2>

                        <div class="space-y-2 text-xs sm:text-sm">
                            <div class="flex justify-between text-slate-600">
                                <span>Total Item</span>
                                <span class="font-bold text-slate-900" x-text="`${cart.count} pcs`"></span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal Menu</span>
                                <span class="font-bold text-slate-900" x-text="cart.formatted_subtotal"></span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Pengambilan</span>
                                <span class="font-medium text-slate-500 text-xs">Pilih di Checkout</span>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex justify-between items-center">
                            <div>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total Tagihan</span>
                                <span class="text-lg sm:text-xl font-black text-blue-600" x-text="cart.formatted_subtotal"></span>
                            </div>
                            <span class="text-[10px] text-slate-400">*Belum ongkir</span>
                        </div>

                        <a href="{{ route('checkout.index') }}" 
                           class="w-full inline-flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm py-3 px-4 rounded-xl shadow-xs hover:shadow-md transition cursor-pointer active:scale-95">
                            <span>Lanjut ke Checkout</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>

            </div>
        </template>

    </div>
</div>
@endsection
