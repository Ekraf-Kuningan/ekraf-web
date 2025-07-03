<div class="w-full">
    <div class="sticky top-0 z-50 flex justify-between items-center py-3 px-4 lg:px-14 bg-gradient-to-r from-yellow-300 via-yellow-400 to-orange-500 shadow-md">
        <!-- Logo dan Search -->
        <div class="flex items-center gap-6 w-full">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('assets/img/LogoEkraf.png') }}" alt="Logo" class="w-20">
            </a>

            <!-- Search Bar -->
            <div class="relative w-full max-w-md">
                <input type="text" placeholder="Cari..."
                    class="bg-gradient-to-r from-yellow-200 via-yellow-300 to-orange-200 text-green-900 placeholder-green-700 font-medium rounded-full px-4 py-2 pl-10 w-full text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-white border border-white">
                <span class="absolute inset-y-0 left-3 flex items-center">
                    <img src="{{ asset('assets/img/search.png') }}" alt="search" class="w-4 opacity-70">
                </span>
            </div>
        </div>

        <!-- Menu Navigasi -->
        <div class="hidden lg:flex items-center gap-6 font-medium text-sm tracking-wide">
            <a href="{{ url('/') }}" class="text-white hover:underline">HOME</a>
            <a href="{{ url('/katalog') }}" class="text-green-900 hover:underline">KATALOG</a>
            <a href="{{ url('/artikel') }}" class="text-green-900 hover:underline">ARTIKEL</a>
            <a href="{{ url('/kontak') }}" class="text-green-900 hover:underline">KONTAK</a>
            <a href="{{ route('register') }}" class="text-green-900 hover:underline text-right leading-tight">DAFTAR </a>
            <a href="{{ route('login') }}" class="text-green-900 hover:underline text-right leading-tight">LOGIN</a>
        </div>

        <!-- Tombol menu (mode mobile) -->
        <button class="lg:hidden text-white text-2xl ml-4 focus:outline-none" id="menu-toggle">
            ☰
        </button>
    </div>

    <!-- Menu responsive (hidden by default) -->
    <div id="menu" class="lg:hidden hidden flex-col bg-white px-6 py-4 text-sm font-medium shadow-md">
        <a href="{{ url('/') }}" class="py-1">HOME</a>
        <a href="{{ url('/katalog') }}" class="py-1">KATALOG</a>
        <a href="{{ url('/artikel') }}" class="py-1">ARTIKEL</a>
        <a href="{{ url('/kontak') }}" class="py-1">KONTAK</a>
        <a href="{{ route('login') }}" class="py-1">DAFTAR / LOGIN</a>
    </div>
</div>
