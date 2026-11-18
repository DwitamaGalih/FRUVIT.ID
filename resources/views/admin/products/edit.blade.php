@extends('layouts.admin')

@section('title', 'Edit Produk ' . $product->name . ' - Admin FRUVIT.ID')

@section('content')
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 flex items-center gap-1 mb-1">
                &larr; Kembali ke Daftar Produk
            </a>
            <h1 class="text-2xl font-black text-slate-900">Edit Produk: {{ $product->name }}</h1>
            <p class="text-xs text-slate-500">Perbarui informasi, harga, foto, atau status produk.</p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-300 text-rose-800 p-4 rounded-2xl text-xs font-semibold">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Produk <span class="text-rose-500">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required class="w-full text-xs sm:text-sm px-4 py-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-xs font-bold text-slate-700 mb-1.5">Kategori <span class="text-rose-500">*</span></label>
                        <select id="category_id" name="category_id" class="w-full text-xs px-4 py-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="price" class="block text-xs font-bold text-slate-700 mb-1.5">Harga (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" id="price" name="price" value="{{ old('price', (int) $product->price) }}" required class="w-full text-xs sm:text-sm px-4 py-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi Produk</label>
                    <textarea id="description" name="description" rows="3" class="w-full text-xs sm:text-sm px-4 py-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="badge" class="block text-xs font-bold text-slate-700 mb-1.5">Badge Promo (Opsional)</label>
                        <input type="text" id="badge" name="badge" value="{{ old('badge', $product->badge) }}" placeholder="Contoh: Best Seller, Favorit, New" class="w-full text-xs sm:text-sm px-4 py-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div>
                        <label for="stock" class="block text-xs font-bold text-slate-700 mb-1.5">Jumlah Stok</label>
                        <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full text-xs sm:text-sm px-4 py-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Foto Saat Ini</label>
                    <div class="flex items-center gap-4 mb-2">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200">
                        <div class="text-[11px] text-slate-500">Pilih file baru di bawah ini jika ingin mengganti foto produk.</div>
                    </div>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                </div>

                <div class="pt-2 flex items-center gap-2">
                    <input type="checkbox" id="is_available" name="is_available" value="1" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" {{ $product->is_available ? 'checked' : '' }}>
                    <label for="is_available" class="text-xs font-bold text-slate-700 cursor-pointer">Status Produk Tersedia untuk Dipesan</label>
                </div>

                <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
                    <a href="{{ route('admin.products.index') }}" class="px-5 py-3 rounded-xl border border-slate-300 text-xs font-bold text-slate-700 hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs px-6 py-3 rounded-xl shadow-md transition cursor-pointer">
                        Perbarui Produk
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
