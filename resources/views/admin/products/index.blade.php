@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin FRUVIT.ID')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Katalog Produk FRUVIT.ID</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Kelola menu makanan & minuman, harga, foto, status ketersediaan, dan stok.</p>
            </div>

            <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-extrabold text-xs px-5 py-3 rounded-2xl shadow-md transition flex items-center gap-1.5 self-start">
                <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Produk Baru</span>
            </a>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 uppercase font-bold text-[10px]">
                        <tr>
                            <th class="py-3 px-4 rounded-l-xl">Produk</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Harga</th>
                            <th class="py-3 px-4">Badge</th>
                            <th class="py-3 px-4">Status & Stok</th>
                            <th class="py-3 px-4 rounded-r-xl text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($products as $product)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 flex-shrink-0">
                                        <div>
                                            <div class="font-extrabold text-slate-900 text-sm">{{ $product->name }}</div>
                                            <div class="text-slate-400 text-[11px] line-clamp-1 max-w-xs">{{ $product->description }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="bg-slate-100 text-slate-700 px-2 py-1 rounded-lg font-bold text-[10px]">
                                        {{ $product->category?->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 font-black text-emerald-600 text-sm">
                                    {{ $product->formatted_price }}
                                </td>
                                <td class="py-3 px-4">
                                    @if($product->badge)
                                        <span class="bg-yellow-400 text-emerald-950 font-black text-[10px] px-2.5 py-0.5 rounded-full">
                                            {{ $product->badge }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <form action="{{ route('admin.products.toggle', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="px-2.5 py-1 rounded-full text-[10px] font-black cursor-pointer transition {{ $product->is_available ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-rose-100 text-rose-800 hover:bg-rose-200' }}">
                                            {{ $product->is_available ? '● Tersedia' : '○ Habis' }}
                                        </button>
                                    </form>
                                    <div class="text-[10px] text-slate-400 mt-0.5">Stok: {{ $product->stock ?? 'Tidak terbatas' }}</div>
                                </td>
                                <td class="py-3 px-4 text-right space-x-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-2.5 py-1.5 rounded-lg transition inline-block">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold px-2.5 py-1.5 rounded-lg transition cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
