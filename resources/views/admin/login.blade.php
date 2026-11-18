<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - FRUVIT.ID</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-fruvit.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-3xl border border-slate-200/90 shadow-xl p-8 space-y-6">
        
        <div class="text-center">
            <div class="inline-block mb-3">
                <img src="{{ asset('images/logo-fruvit.jpg') }}" alt="FRUVIT.ID" class="h-14 w-auto mx-auto object-contain">
            </div>
            <h1 class="text-xl font-black text-slate-900">Portal Pengelola FRUVIT.ID</h1>
            <p class="text-xs text-slate-500 mt-1">Masuk untuk mengelola pesanan, produk, dan konfirmasi pembayaran.</p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border border-rose-300 text-rose-800 p-3 rounded-2xl text-xs font-semibold">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Email Administrator</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', 'admin@fruvit.id') }}" 
                       required 
                       placeholder="admin@fruvit.id" 
                       class="w-full text-xs sm:text-sm px-4 py-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       value="admin123"
                       required 
                       placeholder="••••••••" 
                       class="w-full text-xs sm:text-sm px-4 py-3 rounded-2xl border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" checked>
                    <span>Ingat saya</span>
                </label>
            </div>

            <button type="submit" 
                    class="w-full bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-black text-sm py-3.5 px-6 rounded-2xl shadow-md transition cursor-pointer">
                Masuk ke Dashboard Admin
            </button>
        </form>

        <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-200 text-[11px] text-emerald-900 text-center">
            <strong>Default Kredensial Admin:</strong><br>
            Email: <span class="font-mono font-bold">admin@fruvit.id</span> | Password: <span class="font-mono font-bold">admin123</span>
        </div>

        <div class="text-center pt-2">
            <a href="{{ route('home') }}" class="text-xs font-bold text-slate-500 hover:text-emerald-600">
                &larr; Kembali ke Website Utama
            </a>
        </div>

    </div>

</body>
</html>
