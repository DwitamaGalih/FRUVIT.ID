@extends('layouts.admin')

@section('title', 'Detail Pesanan ' . $order->order_number . ' - Admin FRUVIT.ID')

@section('content')
<div class="py-8" x-data="{ imageModal: false }">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Breadcrumb & Top Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 mb-1">
                    &larr; Kembali ke Daftar Pesanan
                </a>
                <h1 class="text-2xl font-black text-slate-900">Pesanan: {{ $order->order_number }}</h1>
                <p class="text-xs text-slate-500">Dibuat pada {{ $order->created_at->format('d F Y, H:i:s') }}</p>
            </div>

            <div class="flex items-center gap-2">
                <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $order->customer_phone)) }}&text={{ urlencode('Halo kak ' . $order->customer_name . ', kami dari admin FRUVIT.ID mengenai pesanan ' . $order->order_number . '...') }}" 
                   target="_blank" 
                   class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-xs transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span>Hubungi WhatsApp</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left: Items & Customer Details -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Items Table -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs">
                    <h2 class="text-sm font-extrabold text-slate-900 pb-3 border-b border-slate-100 mb-4">
                        Daftar Menu yang Dipesan
                    </h2>

                    <div class="divide-y divide-slate-100">
                        @foreach($order->items as $item)
                            <div class="py-3 flex items-center justify-between gap-4">
                                <div>
                                    <h4 class="text-xs sm:text-sm font-extrabold text-slate-900">{{ $item->product_name }}</h4>
                                    @if($item->pickup_day || $item->sugar_level || $item->jelly_topping)
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @if($item->pickup_day && $item->pickup_batch)
                                                <span class="inline-block px-1.5 py-0.2 rounded text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">📅 Jadwal: {{ $item->pickup_day }} • {{ $item->pickup_batch }}</span>
                                            @endif
                                            @if($item->sugar_level)
                                                <span class="inline-block px-1.5 py-0.2 rounded text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-200">Gula: {{ $item->sugar_level }}</span>
                                            @endif
                                            @if($item->jelly_topping)
                                                <span class="inline-block px-1.5 py-0.2 rounded text-[10px] font-bold bg-purple-100 text-purple-800 border border-purple-200">Topping: {{ $item->jelly_topping }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="text-[11px] text-slate-500 mt-0.5">{{ $item->quantity }} x {{ $item->formatted_price }}</div>
                                    @if($item->notes)
                                        <div class="text-[10px] text-slate-400 italic">"{{ $item->notes }}"</div>
                                    @endif
                                </div>
                                <div class="text-xs sm:text-sm font-black text-slate-900">
                                    {{ $item->formatted_subtotal }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 border-t border-slate-200 space-y-1.5 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal Menu</span>
                            <span class="font-bold text-slate-900">{{ $order->formatted_subtotal }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Ongkos Kirim</span>
                            <span class="font-bold text-slate-900">{{ $order->formatted_delivery_fee }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm font-black text-slate-900 pt-2 border-t border-slate-100">
                            <span>Total Pembayaran</span>
                            <span class="text-emerald-600 text-lg">{{ $order->formatted_total }}</span>
                        </div>
                    </div>
                </div>

                <!-- Customer & Delivery Details -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-4">
                    <h2 class="text-sm font-extrabold text-slate-900 pb-3 border-b border-slate-100">
                        Informasi Pelanggan & Pengiriman
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 font-bold block mb-1">Nama Pemesan</span>
                            <span class="font-bold text-slate-900 text-sm">{{ $order->customer_name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold block mb-1">Nomor WhatsApp</span>
                            <span class="font-bold text-emerald-600 text-sm">{{ $order->customer_phone }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold block mb-1">Metode Penerimaan</span>
                            <span class="font-bold text-slate-900">{{ $order->delivery_method_label }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold block mb-1">Metode Pembayaran</span>
                            <span class="font-bold text-slate-900">{{ $order->payment_method_label }}</span>
                        </div>
                    </div>

                    @if($order->shipping_address)
                        <div class="pt-3 border-t border-slate-100 text-xs">
                            <span class="text-slate-400 font-bold block mb-1">Alamat Pengiriman (Delivery)</span>
                            <p class="text-slate-800 bg-slate-50 p-3 rounded-xl border border-slate-200">{{ $order->shipping_address }}</p>
                        </div>
                    @endif

                    @if($order->notes)
                        <div class="pt-2 text-xs">
                            <span class="text-slate-400 font-bold block mb-1">Catatan Pesanan</span>
                            <p class="text-slate-800 bg-slate-50 p-3 rounded-xl border border-slate-200 italic">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Right: Status Update & Proof Photo -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Status Update Card -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs space-y-5">
                    <h2 class="text-sm font-extrabold text-slate-900 pb-3 border-b border-slate-100">
                        Kelola Status Pesanan
                    </h2>

                    <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Status Pembayaran</label>
                            <select name="payment_status" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-300">
                                <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>🔴 Belum Dibayar</option>
                                <option value="pending_verification" {{ $order->payment_status === 'pending_verification' ? 'selected' : '' }}>🟡 Menunggu Verifikasi</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>🟢 Lunas / Dikonfirmasi</option>
                                <option value="cancelled" {{ $order->payment_status === 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Status Pesanan</label>
                            <select name="order_status" class="w-full text-xs px-3 py-2.5 rounded-xl border border-slate-300">
                                <option value="new" {{ $order->order_status === 'new' ? 'selected' : '' }}>🔵 Pesanan Baru</option>
                                <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>🟡 Sedang Disiapkan</option>
                                <option value="ready" {{ $order->order_status === 'ready' ? 'selected' : '' }}>🟣 Siap Diambil / Diantar</option>
                                <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>🟢 Pesanan Selesai</option>
                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>❌ Batal</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs py-3 rounded-xl transition cursor-pointer">
                            Perbarui Status
                        </button>
                    </form>
                </div>

                <!-- Proof of Payment Card -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs">
                    <h2 class="text-sm font-extrabold text-slate-900 pb-3 border-b border-slate-100 mb-3">
                        Bukti Pembayaran Pelanggan
                    </h2>

                    @if($order->payment_proof)
                        <div class="space-y-3">
                            <div class="relative rounded-2xl overflow-hidden border border-slate-200 cursor-pointer group"
                                 @click="imageModal = true">
                                <img src="{{ $order->payment_proof_url }}" alt="Bukti Transfer" class="w-full h-48 object-cover group-hover:scale-105 transition">
                                <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-xs font-bold">
                                    🔍 Klik untuk Memperbesar
                                </div>
                            </div>
                            
                            <!-- Quick Verification Button -->
                            @if($order->payment_status !== 'paid')
                                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_status" value="paid">
                                    <input type="hidden" name="order_status" value="processing">
                                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs py-2.5 rounded-xl transition cursor-pointer">
                                        ✓ Verifikasi Lunas & Proses Sekarang
                                    </button>
                                </form>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-6 text-slate-400 text-xs">
                            Pelanggan belum mengunggah bukti pembayaran foto/screenshot.
                        </div>
                    @endif
                </div>

                <!-- Delete Order Option -->
                <div class="pt-2 text-right">
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-bold">
                            Hapus Pesanan Ini
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </div>

    <!-- Image Zoom Modal -->
    @if($order->payment_proof)
        <div x-show="imageModal" 
             x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-xs"
             @click="imageModal = false">
            <div class="relative max-w-2xl w-full bg-white rounded-3xl overflow-hidden p-2" @click.stop>
                <img src="{{ $order->payment_proof_url }}" alt="Bukti Transfer Zoom" class="w-full h-auto max-h-[85vh] object-contain rounded-2xl">
                <button @click="imageModal = false" class="absolute top-4 right-4 bg-slate-900/80 text-white p-2 rounded-full hover:bg-slate-900">&times;</button>
            </div>
        </div>
    @endif
</div>
@endsection
