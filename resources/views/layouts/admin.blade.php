<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - FRUVIT.ID')</title>
    
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-fruvit.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased font-sans flex flex-col">

    <!-- Top Admin Bar -->
    <header class="bg-slate-900 text-white sticky top-0 z-40 border-b border-slate-800 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo-fruvit.jpg') }}" alt="FRUVIT.ID" class="h-9 w-auto bg-white p-0.5 rounded-lg object-contain">
                        <span class="text-xs font-black uppercase tracking-wider bg-emerald-600 text-white px-2 py-0.5 rounded-md">Admin</span>
                    </a>
                </div>

                <!-- Admin Navigation Links -->
                <nav class="hidden md:flex items-center space-x-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-yellow-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        📊 Dashboard & Toko
                    </a>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.orders.*') ? 'bg-slate-800 text-yellow-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        📦 Kelola Pesanan
                    </a>
                    <a href="{{ route('admin.products.index') }}" 
                       class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.products.*') ? 'bg-slate-800 text-yellow-400' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        🥗 Kelola Produk
                    </a>
                </nav>

                <!-- Right Actions: View Website & Logout -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 text-xs text-slate-300 hover:text-yellow-400 font-bold px-3 py-1.5 rounded-xl border border-slate-700 hover:border-slate-600 transition">
                        <span>Lihat Website</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>

                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-rose-600/90 hover:bg-rose-700 text-white text-xs font-bold px-3 py-1.5 rounded-xl transition cursor-pointer">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Nav Sub-bar -->
        <div class="md:hidden border-t border-slate-800 px-4 py-2 flex items-center justify-around text-xs font-bold">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'text-yellow-400' : 'text-slate-400' }}">Dashboard</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'text-yellow-400' : 'text-slate-400' }}">Pesanan</a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'text-yellow-400' : 'text-slate-400' }}">Produk</a>
            <a href="{{ route('home') }}" target="_blank" class="text-slate-400">Website</a>
        </div>
    </header>

    <!-- Global Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 bg-emerald-50 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-2xl flex items-center justify-between text-xs font-bold shadow-xs">
                <span>{{ session('success') }}</span>
                <button @click="show = false">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" class="mb-4 bg-rose-50 border border-rose-300 text-rose-800 px-4 py-3 rounded-2xl flex items-center justify-between text-xs font-bold shadow-xs">
                <span>{{ session('error') }}</span>
                <button @click="show = false">&times;</button>
            </div>
        @endif
    </div>

    <!-- Admin Content -->
    <main class="flex-grow pb-16">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-500">
        Panel Admin FRUVIT.ID &copy; {{ date('Y') }} • Sistem Pemesanan Online Kewirausahaan
    </footer>

    @stack('scripts')
</body>
</html>
