@extends('layouts.app')

@section('title', 'Status Pesanan ' . $order->order_number . ' - FRUVIT.ID')

@section('content')
<div class="py-4 sm:py-8 bg-slate-50 min-h-screen" x-data="{
    copied: false,
    copyText(text) {
        navigator.clipboard.writeText(text);
        this.copied = true;
        setTimeout(() => this.copied = false, 2500);
    }
}">
    <div class="max-w-3xl mx-auto px-3 sm:px-6 lg:px-8">
        
        <!-- Order Success & Status Banner -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-5 sm:p-8 shadow-2xs text-center mb-4 sm:mb-6">
            <div class="w-14 h-14 sm:w-16 sm:h-16 mx-auto mb-3 sm:mb-4 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl sm:text-3xl border border-blue-100 shadow-2xs">
                @if($order->order_status === 'completed')
                    🎉
                @elseif($order->payment_status === 'paid')
                    ✅
                @else
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                @endif
            </div>

            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-2 {{ $order->payment_status_color }} border">
                <span>Status: {{ $order->payment_status_label }}</span>
            </div>

            <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">
                @if($order->payment_status === 'paid')
                    Pembayaran Terkonfirmasi!
                @elseif($order->payment_status === 'pending_verification')
                    Bukti Pembayaran Sedang Diverifikasi
                @else
                    Pesanan Berhasil Dibuat!
                @endif
            </h1>

            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-md mx-auto">
                Terima kasih telah memesan di <span class="font-bold text-slate-700">FRUVIT.ID</span>. Simpan nomor pesanan Anda untuk mengecek status pesanan sewaktu-waktu.
            </p>

            <!-- Order Number Highlight Card -->
            <div class="mt-4 inline-flex items-center justify-between gap-4 bg-slate-50 border border-slate-200 rounded-xl sm:rounded-2xl px-4 py-2.5 sm:px-6 sm:py-3 w-full sm:w-auto">
                <div class="text-left">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nomor Pesanan</span>
                    <span class="text-base sm:text-lg font-black text-slate-900 font-mono tracking-wide">{{ $order->order_number }}</span>
                </div>
                <button type="button" 
                        @click="copyText('{{ $order->order_number }}')"
                        class="bg-white hover:bg-slate-100 text-slate-700 text-xs font-bold px-3 py-1.5 rounded-lg border border-slate-300 transition flex items-center gap-1 cursor-pointer shrink-0">
                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                </button>
            </div>
        </div>

        <!-- Order Stepper (Status Perjalanan Pesanan) -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs mb-4 sm:mb-6">
            <h2 class="text-xs sm:text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider">Status Perjalanan Pesanan</h2>
            
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 sm:gap-4 text-center">
                <!-- Step 1: Diterima -->
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/70 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs mb-1.5 {{ in_array($order->order_status, ['new', 'processing', 'ready', 'completed']) ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                        1
                    </div>
                    <div class="text-xs font-bold text-slate-900">Pesanan Dibuat</div>
                    <div class="text-[10px] text-slate-400 mt-0.5">{{ $order->created_at->format('H:i') }} WIB</div>
                </div>

                <!-- Step 2: Pembayaran / Verifikasi -->
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/70 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs mb-1.5 {{ $order->payment_status === 'paid' ? 'bg-blue-600 text-white' : ($order->payment_status === 'pending_verification' ? 'bg-amber-500 text-white animate-pulse' : 'bg-slate-200 text-slate-500') }}">
                        2
                    </div>
                    <div class="text-xs font-bold text-slate-900">
                        @if($order->payment_status === 'paid')
                            Lunas
                        @elseif($order->payment_status === 'pending_verification')
                            Verifikasi
                        @else
                            Menunggu Bayar
                        @endif
                    </div>
                    <div class="text-[10px] text-slate-400 uppercase mt-0.5">{{ $order->payment_method }}</div>
                </div>

                <!-- Step 3: Diproses / Disiapkan -->
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/70 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs mb-1.5 {{ in_array($order->order_status, ['processing', 'ready', 'completed']) ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                        3
                    </div>
                    <div class="text-xs font-bold text-slate-900">Disiapkan</div>
                    <div class="text-[10px] text-slate-400 mt-0.5">Dirajang & dibuat</div>
                </div>

                <!-- Step 4: Siap / Selesai -->
                <div class="bg-slate-50 p-3 rounded-xl border border-slate-200/70 flex flex-col items-center">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs mb-1.5 {{ in_array($order->order_status, ['ready', 'completed']) ? 'bg-blue-600 text-white' : 'bg-slate-200 text-slate-500' }}">
                        4
                    </div>
                    <div class="text-xs font-bold text-slate-900">
                        {{ $order->delivery_method === 'delivery' ? 'Diantar' : 'Siap Diambil' }}
                    </div>
                    <div class="text-[10px] text-slate-400 mt-0.5">
                        {{ $order->order_status === 'completed' ? 'Selesai' : 'Siap' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Instructions & Upload Bukti Section -->
        @if($order->payment_status !== 'paid')
            <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs mb-4 sm:mb-6">
                <div class="flex items-center gap-2.5 pb-3 border-b border-slate-100 mb-4">
                    <span class="text-xl">💳</span>
                    <div>
                        <h2 class="text-sm sm:text-base font-bold text-slate-900">Instruksi Pembayaran</h2>
                        <p class="text-xs text-slate-500">Total Tagihan: <strong class="text-blue-600 font-extrabold">{{ $order->formatted_total }}</strong></p>
                    </div>
                </div>

                @if($order->payment_method === 'qris')
                    <!-- QRIS DISPLAY -->
                    <div class="flex flex-col sm:flex-row gap-5 sm:gap-6 items-center">
                        <div class="w-48 sm:w-64 shrink-0 bg-slate-50 p-3.5 rounded-2xl border border-slate-200 text-center shadow-2xs">
                            <img src="{{ asset($qrisImage) }}" alt="QRIS FRUVIT.ID" class="w-full h-auto rounded-xl">
                            <div class="mt-2 text-[10px] font-bold text-slate-600">
                                Scan via GoPay, Dana, OVO, m-Banking
                            </div>
                        </div>

                        <div class="grow space-y-3.5 w-full">
                            <div class="bg-blue-50/80 rounded-xl p-3.5 border border-blue-100 text-xs text-blue-900 space-y-1.5">
                                <div class="font-bold text-blue-950">Cara Bayar QRIS:</div>
                                <ol class="list-decimal list-inside space-y-1 text-xs text-slate-700">
                                    <li>Buka aplikasi e-Wallet atau m-Banking Anda.</li>
                                    <li>Scan QR code di samping, bayar tepat <strong>{{ $order->formatted_total }}</strong>.</li>
                                    <li>Upload foto/screenshot bukti transfer di bawah ini.</li>
                                </ol>
                            </div>

                            <!-- Upload Proof Box -->
                            <div class="border border-dashed border-slate-300 rounded-xl p-3.5 bg-slate-50/70">
                                <h3 class="text-xs font-bold text-slate-800 mb-2">Upload Bukti Pembayaran</h3>
                                <form action="{{ route('order.upload-proof', $order->order_number) }}" method="POST" enctype="multipart/form-data" class="space-y-2.5">
                                    @csrf
                                    <input type="file" 
                                           name="payment_proof" 
                                           required 
                                           accept="image/*"
                                           class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white cursor-pointer">
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs py-2.5 rounded-xl transition cursor-pointer shadow-2xs">
                                        Konfirmasi Pembayaran
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                @else
                    <!-- CASH / COD DISPLAY -->
                    <div class="bg-blue-50/60 border border-blue-100 rounded-xl p-4 text-slate-800 text-xs">
                        <div class="font-bold mb-1 text-blue-900">💵 Bayar Tunai (Cash) Saat Pengambilan di Stand</div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Siapkan uang pas <strong class="text-blue-600 font-bold">{{ $order->formatted_total }}</strong> saat mengambil pesanan langsung di <strong>Stand FRUVIT.ID</strong>.
                        </p>
                    </div>
                @endif

                @if($order->payment_proof)
                    <div class="mt-4 pt-3.5 border-t border-slate-100 flex items-center gap-3">
                        <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti" class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                        <div class="text-xs">
                            <div class="font-bold text-slate-800">Bukti Transfer Terunggah</div>
                            <div class="text-slate-400">Status: <span class="font-bold text-amber-600">{{ $order->payment_status_label }}</span></div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Order Items & Details -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs mb-4 sm:mb-6">
            <h2 class="text-sm sm:text-base font-bold text-slate-900 pb-2.5 border-b border-slate-100 mb-3">
                Ringkasan Pesanan
            </h2>

            <div class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                    <div class="py-2.5 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <h4 class="text-xs sm:text-sm font-bold text-slate-900 truncate">{{ $item->product_name }}</h4>
                            @if($item->sugar_level || $item->jelly_topping)
                                <div class="flex flex-wrap gap-1 mt-0.5">
                                    @if($item->sugar_level)
                                        <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-semibold bg-blue-50 text-blue-700 border border-blue-100">{{ $item->sugar_level }}</span>
                                    @endif
                                    @if($item->jelly_topping)
                                        <span class="inline-block px-1.5 py-0.2 rounded text-[9px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">{{ $item->jelly_topping }}</span>
                                    @endif
                                </div>
                            @endif
                            <div class="text-[10px] text-slate-400 mt-0.5">{{ $item->quantity }}x @ {{ $item->formatted_price }}</div>
                            @if($item->notes)
                                <div class="text-[10px] text-slate-400 italic">"{{ $item->notes }}"</div>
                            @endif
                        </div>
                        <div class="text-xs sm:text-sm font-bold text-slate-900 shrink-0">
                            {{ $item->formatted_subtotal }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Total Calculations -->
            <div class="pt-3 border-t border-slate-100 space-y-1.5 text-xs">
                <div class="flex justify-between text-slate-600">
                    <span>Subtotal</span>
                    <span class="font-bold text-slate-900">{{ $order->formatted_subtotal }}</span>
                </div>
                <div class="flex justify-between text-slate-600">
                    <span>Metode Penerimaan</span>
                    <span class="font-bold text-slate-900">{{ $order->delivery_method_label }}</span>
                </div>
                @if($order->delivery_fee > 0)
                    <div class="flex justify-between text-slate-600">
                        <span>Biaya Pengiriman</span>
                        <span class="font-bold text-slate-900">{{ $order->formatted_delivery_fee }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-slate-600">
                    <span>Metode Pembayaran</span>
                    <span class="font-bold text-slate-900">{{ $order->payment_method_label }}</span>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-100 flex justify-between items-center mt-2">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Tagihan</span>
                <span class="text-xl sm:text-2xl font-black text-blue-600">{{ $order->formatted_total }}</span>
            </div>
        </div>

        <!-- Action Buttons: Kembali ke Menu & Hubungi Admin -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-200/80 p-4 sm:p-6 shadow-2xs flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
            <div>
                <h3 class="text-xs sm:text-sm font-bold text-slate-900">Perlu Bantuan atau Konfirmasi?</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Hubungi Admin FRUVIT.ID melalui WhatsApp dengan rincian pesanan Anda.
                </p>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('menu.index') }}" 
                   class="grow sm:grow-0 inline-flex items-center justify-center px-4 py-2.5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-700 font-bold text-xs transition">
                    Kembali ke Menu
                </a>

                <a href="{{ $order->whats_app_url }}" 
                   target="_blank" 
                   rel="noopener"
                   class="grow sm:grow-0 inline-flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition active:scale-95 cursor-pointer">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span>Hubungi Admin</span>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
