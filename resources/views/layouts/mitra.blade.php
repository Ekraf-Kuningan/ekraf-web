<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Mitra') - Ekraf Kuningan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">
    
    <!-- Top Navbar -->
    <nav class="bg-white shadow-sm fixed top-0 left-0 right-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Title -->
                <div class="flex items-center">
                    <div class="flex items-center space-x-4">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3">
                            <img src="{{ asset('assets/img/LogoEkraf.png') }}" alt="EKRAF Logo"
                                class="w-10 h-10 sm:w-12 sm:h-12 lg:w-14 lg:h-14 transition-transform duration-300 hover:scale-105">
                        </a>
                        <div class="sm:block">
                            <h1 class="text-lg font-bold text-gray-800">Ekraf Kuningan</h1>
                            <p class="text-xs text-gray-500">@yield('page_title','Dashboard Pelaku Ekraf')</p>
                        </div>
                    </div>
                </div>

                <!-- User Profile (Hidden on Mobile) -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-full">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100">
                            @if(Auth::user()->profile_image_url)
                                <img src="{{ Auth::user()->profile_image_url }}" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="hidden md:block text-sm font-medium">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border hidden group-hover:block">
                            <a href="{{ route('mitra.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-home mr-2"></i> Dashboard
                            </a>
                            <a href="{{ route('mitra.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-2"></i> Profil Saya
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-cog mr-2"></i> Pengaturan
                            </a>
                            <hr class="my-1">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20 pb-20 md:pb-6 min-h-screen">
        <!-- Success Message -->
        @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
                <button onclick="this.parentElement.remove()" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        @yield('content')
    </main>

    <!-- Bottom Navigation (Mobile) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 shadow-lg">
        <div class="flex justify-around items-center h-16">
            <!-- Home -->
            <a href="{{ route('mitra.dashboard') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('mitra.dashboard') ? 'text-orange-600' : 'text-gray-500' }}">
                <x-heroicon-o-home class="w-6 h-6 mb-1" />
                <span class="text-xs">Home</span>
            </a>

            <!-- Products -->
            <a href="{{ route('mitra.products') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('mitra.products*') ? 'text-orange-600' : 'text-gray-500' }}">
                <x-heroicon-o-cube class="w-6 h-6 mb-1" />
                <span class="text-xs">Produk</span>
            </a>

            <!-- Add Product (Center Button) -->
            <a href="{{ route('mitra.products.create') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full flex items-center justify-center -mt-7 shadow-xl border-4 border-white">
                    <i class="fas fa-inbox text-white text-xl"></i>
                </div>
            </a>

            <!-- Katalog -->
            <a href="{{ route('mitra.katalog-management.index') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('mitra.katalog-management*') ? 'text-orange-600' : 'text-gray-500' }}">
                <x-heroicon-o-squares-2x2 class="w-6 h-6 mb-1" />
                <span class="text-xs">Katalog</span>
            </a>

            <!-- Profile -->
            <a href="{{ route('mitra.profile.edit') }}" 
               class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('mitra.profile*') ? 'text-orange-600' : 'text-gray-500' }}">
                <i class="fas fa-user text-xl mb-1"></i>
                <span class="text-xs">Profil</span>
            </a>
        </div>
    </nav>

    <!-- Desktop Sidebar (Card Style) -->
    <aside class="hidden md:block fixed left-0 top-16 bottom-0 w-64 bg-gray-50 overflow-y-auto border-r border-gray-200">
        <nav class="p-4 space-y-2">
            <!-- Dashboard Card -->
            <a href="{{ route('mitra.dashboard') }}" 
               class="block bg-white rounded-lg shadow-sm hover:shadow-md transition p-3 {{ request()->routeIs('mitra.dashboard') ? 'ring-2 ring-orange-500' : '' }}">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg {{ request()->routeIs('mitra.dashboard') ? 'bg-gradient-to-br from-orange-400 to-orange-500' : 'bg-gray-100' }} flex items-center justify-center">
                        <x-heroicon-o-home class=" w-5 h-5 text-sm {{ request()->routeIs('mitra.dashboard') ? 'text-white' : 'text-gray-600' }}" />
                    </div>
                    <span class="text-sm {{ request()->routeIs('mitra.dashboard') ? 'text-orange-600 font-medium' : 'text-gray-700' }}">Dashboard</span>
                </div>
            </a>
            
            <!-- Products Card -->
            <a href="{{ route('mitra.products') }}" 
               class="block bg-white rounded-lg shadow-sm hover:shadow-md transition p-3 {{ request()->routeIs('mitra.products*') && !request()->routeIs('mitra.products.create') ? 'ring-2 ring-orange-500' : '' }}">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg {{ request()->routeIs('mitra.products*') && !request()->routeIs('mitra.products.create') ? 'bg-gradient-to-br from-orange-400 to-orange-500' : 'bg-gray-100' }} flex items-center justify-center">
                        <x-heroicon-o-archive-box class=" w-5 h-5 text-sm {{ request()->routeIs('mitra.products*') && !request()->routeIs('mitra.products.create') ? 'text-white' : 'text-gray-600' }}" />
                    </div>
                    <span class="text-sm {{ request()->routeIs('mitra.products*') && !request()->routeIs('mitra.products.create') ? 'text-orange-600 font-medium' : 'text-gray-700' }}">Produk Saya</span>
                </div>
            </a>
            
            <!-- Add Product Card (Special) -->
            <a href="{{ route('mitra.products.create') }}" 
               class="block bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg shadow-md hover:shadow-lg transition p-3 hover:scale-105 transform">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-white bg-opacity-25 flex items-center justify-center">
                        <x-heroicon-o-plus class=" w-5 h-5 text-sm text-white" />
                    </div>
                    <span class="text-sm text-white">Tambah Produk</span>
                </div>
            </a>
            
            <!-- Katalog Management Card -->
            <a href="{{ route('mitra.katalog-management.index') }}" 
               class="block bg-white rounded-lg shadow-sm hover:shadow-md transition p-3 {{ request()->routeIs('mitra.katalog-management*') ? 'ring-2 ring-orange-500' : '' }}">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg {{ request()->routeIs('mitra.katalog-management*') ? 'bg-gradient-to-br from-orange-400 to-orange-500' : 'bg-gray-100' }} flex items-center justify-center">
                        <x-heroicon-o-clipboard class=" w-5 h-5 text-sm {{ request()->routeIs('mitra.katalog-management*') ? 'text-white' : 'text-gray-600' }}" />
                    </div>
                    <span class="text-sm {{ request()->routeIs('mitra.katalog-management*') ? 'text-orange-600 font-medium' : 'text-gray-700' }}">Katalog Saya</span>
                </div>
            </a>
            
            <!-- Browse Katalog Produk Card -->
            {{-- <a href="{{ route('mitra.katalog-management.index') }}" 
               class="block bg-white rounded-xl shadow-sm hover:shadow-md transition p-4 {{ request()->routeIs('mitra.katalog-management') || request()->routeIs('mitra.katalog-management.show') ? 'ring-2 ring-orange-500' : '' }}">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-lg {{ request()->routeIs('mitra.katalog-management*') || request()->routeIs('mitra.katalog-management.show') ? 'bg-gradient-to-br from-orange-400 to-orange-500' : 'bg-gray-100' }} flex items-center justify-center">
                        <i class="fas fa-store {{ request()->routeIs('mitra.katalog-management*') || request()->routeIs('mitra.katalog-management.show') ? 'text-white' : 'text-gray-600' }}"></i>
                    </div>
                    <span class="font-medium {{ request()->routeIs('mitra.katalog-management*') || request()->routeIs('mitra.katalog-management.show') ? 'text-orange-600' : 'text-gray-700' }}">Katalog Produk</span>
                </div>
            </a> --}}
            
            <!-- Statistics Card -->
            <a href="#" 
               class="block bg-white rounded-lg shadow-sm hover:shadow-md transition p-3">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-chart-line text-sm text-gray-600"></i>
                    </div>
                    <span class="text-sm text-gray-700">Statistik</span>
                </div>
            </a>
            
            <div class="pt-2 border-t border-gray-200"></div>
            
            <!-- Profile Card -->
            <a href="{{ route('mitra.profile.edit') }}" 
               class="block bg-white rounded-lg shadow-sm hover:shadow-md transition p-3 {{ request()->routeIs('mitra.profile*') ? 'ring-2 ring-orange-500' : '' }}">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg {{ request()->routeIs('mitra.profile*') ? 'bg-gradient-to-br from-orange-400 to-orange-500' : 'bg-gray-100' }} flex items-center justify-center">
                        <x-heroicon-o-user class=" w-5 h-5 text-sm {{ request()->routeIs('mitra.profile*') ? 'text-white' : 'text-gray-600' }}" />
                    </div>
                    <span class="text-sm {{ request()->routeIs('mitra.profile*') ? 'text-orange-600 font-medium' : 'text-gray-700' }}">Profil</span>
                </div>
            </a>
            
            <!-- Settings Card -->
            <a href="#" 
               class="block bg-white rounded-lg shadow-sm hover:shadow-md transition p-3">
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-cog text-sm text-gray-600"></i>
                    </div>
                    <span class="text-sm text-gray-700">Pengaturan</span>
                </div>
            </a>
        </nav>
    </aside>

    <!-- Main content wrapper for desktop with sidebar -->
    <style>
        @media (min-width: 768px) {
            main {
                margin-left: 16rem; /* 256px = w-64 */
            }
        }

        /* Prevent content from being hidden behind navbar on mobile */
        body {
            padding-top: env(safe-area-inset-top);
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Ensure proper spacing on iOS devices */
        @supports (padding: max(0px)) {
            main {
                padding-left: max(1rem, env(safe-area-inset-left));
                padding-right: max(1rem, env(safe-area-inset-right));
            }
        }
    </style>

    @stack('scripts')
</body>
</html>
