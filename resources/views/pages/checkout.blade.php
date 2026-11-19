@extends('layouts.app')

@section('title', 'Checkout Pesanan - FRUVIT.ID')

@section('content')
<div class="py-4 sm:py-8 bg-slate-50 min-h-screen" x-data="{
    deliveryMethod: '{{ old('delivery_method', 'pickup') }}',
    paymentMethod: '{{ old('payment_method', 'qris') }}',
    deliveryFee: {{ $deliveryFee }},
    subtotal: {{ (float) $cart['subtotal'] }},
    get total() {
        return this.subtotal + (this.deliveryMethod === 'delivery' ? this.deliveryFee : 0);
    },
    formatRupiah(num) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(num);
    }
}">
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb & Header -->
        <div class="mb-4 sm:mb-6">
            <div class="flex items-center gap-1.5 text-xs text-slate-400 font-medium mb-1">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                <span>/</span>
                <a href="{{ route('menu.index') }}" class="hover:text-blue-600">Menu</a>
                <span>/</span>
                <a href="{{ route('cart.index') }}" class="hover:text-blue-600">Keranjang</a>
                <span>/</span>
                <span class="text-slate-700">Checkout</span>
            </div>
            <h1 class="text-xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Checkout Pesanan</h1>
        </div>

        @if ($errors->any())
            <div class="mb-5 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs shadow-2xs">
                <div class="font-bold mb-1 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span>Mohon lengkapi data berikut:</span>
                </div>
                <ul class="list-disc list-inside space-y-0.5 text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-8 items-start">
                
                <!-- Left Column: Customer Data, Method, & Payment -->
                <div class="lg:col-span-7 space-y-4 sm:space-y-6">
                    
                    <!-- 1. Data Pemesan -->
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs">
                        <div class="flex items-center gap-2.5 pb-3.5 border-b border-slate-100 mb-4">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                1
                            </div>
                            <h2 class="text-sm sm:text-base font-bold text-slate-900">Informasi Pemesan</h2>
                        </div>

                        <div class="space-y-3.5">
                            <div>
                                <label for="customer_name" class="block text-xs font-semibold text-slate-700 mb-1">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" 
                                       id="customer_name" 
                                       name="customer_name" 
                                       value="{{ old('customer_name') }}" 
                                       required
                                       placeholder="Masukkan nama lengkap Anda" 
                                       class="w-full text-xs sm:text-sm px-3.5 py-2.5 sm:py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-xs font-semibold text-slate-700 mb-1">
                                    Nomor WhatsApp Aktif <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="tel" 
                                           id="customer_phone" 
                                           name="customer_phone" 
                                           value="{{ old('customer_phone') }}" 
                                           required
                                           placeholder="Contoh: 081234567890" 
                                           class="w-full text-xs sm:text-sm px-3.5 py-2.5 sm:py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                                    <span class="absolute right-3.5 top-2.5 sm:top-3 text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100">WhatsApp</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Metode Pengambilan & Alamat -->
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs">
                        <div class="flex items-center gap-2.5 pb-3.5 border-b border-slate-100 mb-4">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                2
                            </div>
                            <h2 class="text-sm sm:text-base font-bold text-slate-900">Metode Pengambilan</h2>
                        </div>

                        <!-- 2 columns option -->
                        <div class="grid grid-cols-2 gap-2.5 sm:gap-3 mb-3.5">
                            <!-- Pickup Option -->
                            <label class="relative flex flex-col p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 cursor-pointer transition select-none"
                                   :class="deliveryMethod === 'pickup' ? 'border-blue-600 bg-blue-50/40' : 'border-slate-200 bg-white hover:border-slate-300'">
                                <input type="radio" name="delivery_method" value="pickup" x-model="deliveryMethod" class="sr-only">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-lg sm:text-xl">🏪</span>
                                    <span class="text-[10px] sm:text-xs font-bold text-blue-700 bg-blue-50 border border-blue-100 px-2 py-0.5 rounded-md">Gratis</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-slate-900 leading-tight">Ambil Sendiri</span>
                                <span class="text-[10px] text-slate-400 mt-0.5 leading-tight">Pickup di stand</span>
                            </label>

                            <!-- Delivery Option -->
                            <label class="relative flex flex-col p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 cursor-pointer transition select-none"
                                   :class="deliveryMethod === 'delivery' ? 'border-blue-600 bg-blue-50/40' : 'border-slate-200 bg-white hover:border-slate-300'">
                                <input type="radio" name="delivery_method" value="delivery" x-model="deliveryMethod" class="sr-only">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-lg sm:text-xl">🛵</span>
                                    <span class="text-[10px] sm:text-xs font-bold text-slate-900 bg-yellow-400 px-2 py-0.5 rounded-md">+1k</span>
                                </div>
                                <span class="text-xs sm:text-sm font-bold text-slate-900 leading-tight">Delivery</span>
                                <span class="text-[10px] text-slate-400 mt-0.5 leading-tight">Antar ke kampus/kos</span>
                            </label>
                        </div>

                        <!-- Pickup Location info -->
                        <div x-show="deliveryMethod === 'pickup'" x-cloak class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-xs text-slate-600">
                            <span class="font-bold text-slate-800">Alamat Stand:</span> {{ $storeAddress }}
                        </div>

                        <!-- Delivery Address Field -->
                        <div x-show="deliveryMethod === 'delivery'" x-cloak class="mt-3.5">
                            <label for="shipping_address" class="block text-xs font-semibold text-slate-700 mb-1">
                                Alamat Pengiriman Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <textarea id="shipping_address" 
                                      name="shipping_address" 
                                      rows="2" 
                                      :required="deliveryMethod === 'delivery'"
                                      placeholder="Nama Gedung / Fakultas / Ruang Kelas / Nama Kos & Kamar..." 
                                      class="w-full text-xs sm:text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">{{ old('shipping_address') }}</textarea>
                        </div>

                        <!-- Special Notes Field -->
                        <div class="mt-3.5">
                            <label for="notes" class="block text-xs font-semibold text-slate-700 mb-1">
                                Catatan Pesanan (Opsional)
                            </label>
                            <input type="text" 
                                   id="notes" 
                                   name="notes" 
                                   value="{{ old('notes') }}" 
                                   placeholder="Contoh: Ekstra sendok, jangan terlalu manis..." 
                                   class="w-full text-xs sm:text-sm px-3.5 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                        </div>
                    </div>

                    <!-- 3. Metode Pembayaran -->
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs">
                        <div class="flex items-center gap-2.5 pb-3.5 border-b border-slate-100 mb-4">
                            <div class="w-7 h-7 rounded-lg bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                3
                            </div>
                            <h2 class="text-sm sm:text-base font-bold text-slate-900">Metode Pembayaran</h2>
                        </div>

                        <div class="space-y-2.5">
                            <!-- QRIS -->
                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 cursor-pointer transition select-none"
                                   :class="paymentMethod === 'qris' ? 'border-blue-600 bg-blue-50/40' : 'border-slate-200 bg-white hover:border-slate-300'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="qris" x-model="paymentMethod" class="text-blue-600">
                                    <div>
                                        <div class="text-xs sm:text-sm font-bold text-slate-900 flex items-center gap-1.5">
                                            <span>QRIS Instan (Scan & Bayar)</span>
                                            <span class="bg-blue-600 text-white text-[9px] font-bold px-1.5 py-0.2 rounded-md">Rekomendasi</span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">GoPay, OVO, Dana, ShopeePay, BCA & Semua m-Banking</div>
                                    </div>
                                </div>
                                <span class="text-lg">📲</span>
                            </label>

                            <!-- Cash saat Ambil / COD -->
                            <label class="flex items-center justify-between p-3.5 rounded-xl border-2 cursor-pointer transition select-none"
                                   :class="paymentMethod === 'cash' ? 'border-blue-600 bg-blue-50/40' : 'border-slate-200 bg-white hover:border-slate-300'">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="payment_method" value="cash" x-model="paymentMethod" class="text-blue-600">
                                    <div>
                                        <div class="text-xs sm:text-sm font-bold text-slate-900">Tunai / Cash saat Ambil (COD)</div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">Bayar langsung di stand saat mengambil pesanan</div>
                                    </div>
                                </div>
                                <span class="text-lg">💵</span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Order Summary -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-2xs sticky top-24 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <h2 class="text-sm sm:text-base font-bold text-slate-900">Ringkasan Pesanan</h2>
                            <a href="{{ route('cart.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">Ubah</a>
                        </div>

                        <!-- Items list -->
                        <div class="divide-y divide-slate-100 max-h-56 overflow-y-auto pr-1">
                            @foreach($cart['items'] as $item)
                                <div class="py-2.5 flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-11 h-11 rounded-xl object-cover border border-slate-100 shrink-0">
                                        <div class="min-w-0">
                                            <h4 class="text-xs font-bold text-slate-900 truncate">{{ $item['name'] }}</h4>
                                            @if(!empty($item['pickup_day']) || !empty($item['sugar_level']) || !empty($item['jelly_topping']))
                                                <div class="flex flex-wrap gap-1 mt-0.5">
                                                    @if(!empty($item['pickup_day']) && !empty($item['pickup_batch']))
                                                        <span class="inline-block px-1.5 py-0.2 rounded text-[8px] font-semibold bg-blue-100 text-blue-800 border border-blue-200">📅 {{ $item['pickup_day'] }} • {{ $item['pickup_batch'] }}</span>
                                                    @endif
                                                    @if(!empty($item['sugar_level']))
                                                        <span class="inline-block px-1.5 py-0.2 rounded text-[8px] font-semibold bg-blue-50 text-blue-700 border border-blue-100">{{ $item['sugar_level'] }}</span>
                                                    @endif
                                                    @if(!empty($item['jelly_topping']))
                                                        <span class="inline-block px-1.5 py-0.2 rounded text-[8px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">{{ $item['jelly_topping'] }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="text-[10px] text-slate-400 mt-0.5">{{ $item['quantity'] }}x @ Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-900 shrink-0">{{ $item['formatted_subtotal'] }}</span>
                                </div>
                            @endforeach
                        </div>

                        <!-- Calculations -->
                        <div class="pt-3 border-t border-slate-100 space-y-2 text-xs">
                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal</span>
                                <span class="font-bold text-slate-900">{{ $cart['formatted_subtotal'] }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Ongkir</span>
                                <span class="font-bold" 
                                      :class="deliveryMethod === 'delivery' ? 'text-slate-900' : 'text-blue-600'"
                                      x-text="deliveryMethod === 'delivery' ? formatRupiah(deliveryFee) : 'Gratis (Pickup)'">
                                </span>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex justify-between items-center">
                            <div>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total Tagihan</span>
                                <span class="text-xl sm:text-2xl font-black text-blue-600" x-text="formatRupiah(total)"></span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm py-3.5 px-4 rounded-xl shadow-xs hover:shadow-md transition cursor-pointer active:scale-95">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span>Buat Pesanan</span>
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>
@endsection
