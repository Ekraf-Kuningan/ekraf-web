@extends('layouts.mitra')

@section('title', 'Dashboard Mitra')

@push('styles')
<style>
    /* Hide scrollbar for horizontal scroll */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    /* Smooth scroll */
    .snap-x {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }
</style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Welcome -->
        <div class="mb-6">
            <div class="rounded-2xl bg-gradient-to-r from-orange-400 to-orange-500 p-6 md:p-8 text-white shadow-lg">
                <p class="text-sm md:text-base opacity-90 mb-2">Selamat
                    datang{{ isset($mitra->business_name) ? ', ' . $mitra->business_name : '' }}</p>
                <h2 class="text-lg md:text-xl font-semibold leading-relaxed">Kelola produk dan aktivitas bisnis Anda di bawah
                    ini</h2>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-5 mb-8">
            <!-- Total Views All Time -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Total Kunjungan</p>
                        <p class="text-3xl font-bold">{{ number_format($totalViews) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-eye text-2xl"></i>
                    </div>
                </div>
                <p class="text-xs opacity-75">Sepanjang waktu</p>
            </div>

            <!-- Views This Month -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Bulan Ini</p>
                        <p class="text-3xl font-bold">{{ number_format($viewsThisMonth) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                </div>
                <p class="text-xs opacity-75">{{ now()->format('F Y') }}</p>
            </div>

            <!-- Views Today -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-sm opacity-90 mb-1">Hari Ini</p>
                        <p class="text-3xl font-bold">{{ number_format($viewsToday) }}</p>
                    </div>
                    <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                </div>
                <p class="text-xs opacity-75">{{ now()->format('d M Y') }}</p>
            </div>
        </div>

        <!-- Top Viewed Products & Device Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Top Viewed Katalogs -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center mb-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl flex items-center justify-center text-white shadow-md">
                        <i class="fas fa-fire text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 ml-3">Katalog Terpopuler</h3>
                </div>

                <div class="space-y-3">
                    @forelse($topViewedKatalogs as $index => $katalog)
                        <div
                            class="flex items-center p-3 rounded-xl border border-gray-100 hover:border-orange-200 hover:shadow-md transition-all duration-300">
                            <div
                                class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-orange-500 text-white flex items-center justify-center font-bold text-sm">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-shrink-0 w-12 h-12 rounded-lg overflow-hidden bg-gray-100 ml-3">
                                <img src="{{ $katalog->image_url }}" alt="{{ $katalog->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="ml-3 flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $katalog->title }}</p>
                                <p class="text-xs text-gray-600">
                                    <i class="fas fa-eye text-orange-500 mr-1"></i>
                                    {{ number_format($katalog->views_count) }} kunjungan
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-chart-line text-4xl mb-3 opacity-50"></i>
                            <p class="text-sm">Belum ada data kunjungan</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Device Stats -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center mb-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl flex items-center justify-center text-white shadow-md">
                        <i class="fas fa-mobile-alt text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 ml-3">Perangkat Pengunjung</h3>
                </div>

                <div class="space-y-4">
                    @php
                        $totalDeviceViews = array_sum($deviceStats);
                        $deviceIcons = [
                            'mobile' => 'fa-mobile-alt',
                            'tablet' => 'fa-tablet-alt',
                            'desktop' => 'fa-desktop',
                        ];
                        $deviceColors = [
                            'mobile' => 'bg-blue-500',
                            'tablet' => 'bg-green-500',
                            'desktop' => 'bg-purple-500',
                        ];
                    @endphp

                    @forelse($deviceStats as $device => $count)
                        @php
                            $percentage = $totalDeviceViews > 0 ? round(($count / $totalDeviceViews) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <i class="fas {{ $deviceIcons[$device] ?? 'fa-question' }} text-gray-600 mr-2"></i>
                                    <span class="text-sm font-medium text-gray-700 capitalize">{{ $device }}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm font-bold text-gray-900 mr-2">{{ number_format($count) }}</span>
                                    <span class="text-xs text-gray-500">({{ $percentage }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="{{ $deviceColors[$device] ?? 'bg-gray-500' }} h-2 rounded-full transition-all duration-500"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-mobile-alt text-4xl mb-3 opacity-50"></i>
                            <p class="text-sm">Belum ada data perangkat</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Daily Views Chart (Optional - menggunakan Chart.js) -->
        <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 mb-8">
            <div class="flex items-center mb-4">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-indigo-500 rounded-xl flex items-center justify-center text-white shadow-md">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 ml-3">Grafik Kunjungan 7 Hari Terakhir</h3>
            </div>

            <canvas id="viewsChart" height="80"></canvas>
        </div>
        <!-- Stats Cards -->
        <div class="flex overflow-x-auto gap-4 pb-4 mb-8 snap-x snap-mandatory scrollbar-hide md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-5">
            <!-- Active -->
            <div
                class="group rounded-2xl bg-white shadow-md hover:shadow-xl border border-gray-100 p-6 min-w-[280px] md:min-w-0 h-32 md:h-36 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 snap-start">
                <div>
                    <span class="inline-block w-12 h-1.5 rounded-full bg-orange-500 mb-3"></span>
                    <p class="text-xs md:text-sm tracking-wide text-gray-600 font-medium">Produk Aktif</p>
                </div>
                <div class="text-3xl md:text-4xl leading-none font-bold text-orange-600">{{ $stats['active'] }}</div>
            </div>

            <!-- Pending -->
            <div
                class="group rounded-2xl bg-white shadow-md hover:shadow-xl border border-gray-100 p-6 min-w-[280px] md:min-w-0 h-32 md:h-36 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 snap-start">
                <div>
                    <span class="inline-block w-12 h-1.5 rounded-full bg-blue-500 mb-3"></span>
                    <p class="text-xs md:text-sm tracking-wide text-gray-600 font-medium">Belum Terverifikasi</p>
                </div>
                <div class="text-3xl md:text-4xl leading-none font-bold text-blue-600">{{ $stats['pending'] }}</div>
            </div>

            <!-- Rejected -->
            <div
                class="group rounded-2xl bg-white shadow-md hover:shadow-xl border border-gray-100 p-6 min-w-[280px] md:min-w-0 h-32 md:h-36 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1 snap-start">
                <div>
                    <span class="inline-block w-12 h-1.5 rounded-full bg-gray-400 mb-3"></span>
                    <p class="text-xs md:text-sm tracking-wide text-gray-600 font-medium">Ditolak</p>
                </div>
                <div class="text-3xl md:text-4xl leading-none font-bold text-gray-600">{{ $stats['rejected'] }}</div>
            </div>
        </div>

        <!-- Quick Nav (Desktop) -->
        <div class="hidden md:grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-5 mb-8">
            <a href="{{ route('mitra.products.create') }}"
                class="group rounded-2xl bg-white shadow-md hover:shadow-xl border border-gray-100 p-5 md:p-6 hover:border-orange-200 transition-all duration-300 hover:-translate-y-1">
                <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition-colors">Tambah Produk</p>
            </a>
            <a href="{{ route('mitra.products') }}"
                class="group rounded-2xl bg-white shadow-md hover:shadow-xl border border-gray-100 p-5 md:p-6 hover:border-orange-200 transition-all duration-300 hover:-translate-y-1">
                <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition-colors">Produk Saya</p>
            </a>
            <a href="{{ route('mitra.profile.edit') }}"
                class="group rounded-2xl bg-white shadow-md hover:shadow-xl border border-gray-100 p-5 md:p-6 hover:border-orange-200 transition-all duration-300 hover:-translate-y-1">
                <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition-colors">Edit Profil</p>
            </a>
            <a href="#"
                class="group rounded-2xl bg-white shadow-md hover:shadow-xl border border-gray-100 p-5 md:p-6 hover:border-orange-200 transition-all duration-300 hover:-translate-y-1">
                <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition-colors">Statistik</p>
            </a>
        </div>

    
        <!-- Layout Grid: Profil Usaha, Notifikasi, dan Produk Terakhir -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <!-- 1. Profil Usaha (Mini Card) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 h-full">
                    <div class="flex items-center mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl flex items-center justify-center text-white shadow-md">
                            <x-heroicon-o-briefcase class="w-6 h-6 mb-1" />
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 ml-3">Profil Usaha</h3>
                    </div>

                    @if ($mitra)
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Nama Usaha</p>
                                <p class="font-semibold text-gray-900">{{ $mitra->business_name ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Pemilik</p>
                                <p class="text-sm text-gray-700 flex items-center">
                                    <i class="fas fa-user text-gray-400 mr-2"></i>
                                    {{ Auth::user()->name }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Kontak</p>
                                <p class="text-sm text-gray-700 flex items-center">
                                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                                    {{ Auth::user()->phone_number ?? '-' }}
                                </p>
                            </div>
                            @if ($mitra->address)
                                <div>
                                    <p class="text-xs text-gray-500 mb-1">Alamat</p>
                                    <p class="text-sm text-gray-700 flex items-start">
                                        <i class="fas fa-map-marker-alt text-gray-400 mr-2 mt-1"></i>
                                        <span class="line-clamp-2">{{ $mitra->address }}</span>
                                    </p>
                                </div>
                            @endif
                            <div class="pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500 mb-2">Total Produk</p>
                                <p class="text-2xl font-bold text-orange-600">{{ $stats['total'] }}</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                                <i class="fas fa-store text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Lengkapi profil usaha Anda</p>
                            <a href="{{ route('mitra.profile.edit') }}"
                                class="inline-block px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Profil
                            </a>
                        </div>
                    @endif

                    <a href="{{ route('mitra.profile.edit') }}"
                        class="block mt-4 text-center text-sm text-orange-600 hover:text-orange-700 font-medium transition-colors">
                        <i class="fas fa-arrow-right mr-1"></i>
                        Kelola Profil
                    </a>
                </div>
            </div>

            <!-- 2. Notifikasi Status Terbaru -->
            <div class="lg:col-span-2">

                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl flex items-center justify-center text-white shadow-md">
                            <x-heroicon-o-bell class="w-6 h-6 mb-1" />
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 ml-3">Status Terakhir</h3>
                    </div>
                    <span class="text-xs text-gray-500">30 hari terakhir</span>
                </div>

                <div class="space-y-3 max-h-80 overflow-y-auto">
                    @forelse($notifications as $notif)
                        <div
                            class="flex items-start p-3 rounded-xl border {{ $notif->status === 'approved' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }} hover:shadow-md transition-all duration-300">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center {{ $notif->status === 'approved' ? 'bg-green-500' : 'bg-red-500' }} text-white">
                                <i class="fas {{ $notif->status === 'approved' ? 'fa-check' : 'fa-times' }}"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900">{{ $notif->name }}</p>
                                        <p
                                            class="text-xs {{ $notif->status === 'approved' ? 'text-green-700' : 'text-red-700' }} font-medium mt-1">
                                            @if ($notif->status === 'approved')
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Produk disetujui dan aktif
                                            @else
                                                <i class="fas fa-times-circle mr-1"></i>
                                                Produk ditolak
                                            @endif
                                        </p>
                                    </div>
                                    <span
                                        class="text-xs text-gray-500 ml-2 flex-shrink-0">{{ $notif->uploaded_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                                <i class="fas fa-bell-slash text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-sm text-gray-600">Tidak ada notifikasi terbaru</p>
                            <p class="text-xs text-gray-500 mt-1">Notifikasi akan muncul ketika ada perubahan status produk
                            </p>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

        <!-- 3. Produk Terakhir (List Kecil) -->
        <div class="mb-8">
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-500 rounded-xl flex items-center justify-center text-white shadow-md">
                            <x-heroicon-o-cube class="w-6 h-6 mb-1" />
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 ml-3">Produk Terakhir</h3>
                    </div>
                    <a href="{{ route('mitra.products') }}"
                        class="text-sm text-orange-600 hover:text-orange-700 font-medium transition-colors">
                        Lihat Semua →
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($latestProducts as $product)
                        <div
                            class="flex items-center p-1 rounded-xl border border-gray-100 hover:border-orange-200 hover:shadow-md transition-all duration-300 group">
                            <!-- Product Image -->
                            <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-gray-100">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                    onerror="this.onerror=null; this.src='{{ asset('assets/img/placeholder-product.svg') }}';">
                            </div>

                            <!-- Product Info -->
                            <div class="ml-4 flex-1 min-w-0">
                                <h4
                                    class="text-sm font-semibold text-gray-900 truncate group-hover:text-orange-600 transition-colors">
                                    {{ $product->name }}
                                </h4>
                                <div class="flex items-center gap-3 mt-1">
                                    <p class="text-sm font-bold text-orange-600">
                                        Rp {{ number_format($product->price ?? 0, 0, ',', '.') }}
                                    </p>
                                    <span class="text-xs text-gray-500">•</span>
                                    {{-- <p class="text-xs text-gray-600">
									Stok: <span class="font-semibold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $product->stock }}</span>
								</p> --}}
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div class="flex-shrink-0 ml-3">
                                @if ($product->status === 'approved')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Aktif
                                    </span>
                                @elseif($product->status === 'pending')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                        <i class="fas fa-clock mr-1"></i>
                                        Pending
                                    </span>
                                @elseif($product->status === 'rejected')
                                    <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded-full">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto mb-3 flex items-center justify-center">
                                <i class="fas fa-box-open text-2xl text-gray-400"></i>
                            </div>
                            <p class="text-sm text-gray-600 mb-3">Belum ada produk</p>
                            <a href="{{ route('mitra.products.create') }}"
                                class="inline-block px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Produk
                            </a>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>

        <!-- Sub Sektor -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg md:text-xl font-bold text-gray-900">Sub Sektor</h3>
                <a href="{{ route('mitra.products') }}"
                    class="text-sm md:text-base text-blue-600 hover:text-blue-700 font-medium transition-colors">Lihat
                    Semua →</a>
            </div>

            @if ($categories->count())
                <!-- Mobile: horizontal scroll dengan icon -->
                <div class="md:hidden overflow-x-auto -mx-4 pl-4 pr-4 pb-2">
                    <div class="flex gap-3">
                        @foreach ($categories as $c)
                            <a href="{{ route('mitra.products', ['category' => $c->id]) }}"
                                class="group flex-shrink-0 w-24 text-center">
                                <div
                                    class="w-24 h-24 rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 flex items-center justify-center mb-2 group-hover:from-orange-100 group-hover:to-orange-200 transition-all duration-300 shadow-sm group-hover:shadow-md">
                                    @php
                                        // Map kategori ke icon
                                        $iconMap = [
                                            'aplikasi' => 'fa-mobile-alt',
                                            'game' => 'fa-gamepad',
                                            'arsitektur' => 'fa-building',
                                            'desain' => 'fa-paint-brush',
                                            'interior' => 'fa-couch',
                                            'fashion' => 'fa-tshirt',
                                            'kuliner' => 'fa-utensils',
                                            'kerajinan' => 'fa-hand-sparkles',
                                            'musik' => 'fa-music',
                                            'film' => 'fa-film',
                                            'fotografi' => 'fa-camera',
                                            'seni' => 'fa-palette',
                                            'digital' => 'fa-laptop',
                                            'teknologi' => 'fa-microchip',
                                            'web' => 'fa-code',
                                            'grafis' => 'fa-pen-nib',
                                            'animasi' => 'fa-video',
                                        ];

                                        $title = strtolower($c->title);
                                        $icon = 'fa-box'; // default icon

                                        foreach ($iconMap as $key => $value) {
                                            if (str_contains($title, $key)) {
                                                $icon = $value;
                                                break;
                                            }
                                        }
                                    @endphp
                                    <i
                                        class="fas {{ $icon }} text-3xl text-orange-500 group-hover:scale-110 transition-transform duration-300"></i>
                                </div>
                                <p class="text-xs font-medium text-gray-700 line-clamp-2 leading-tight">
                                    {{ $c->title }}</p>
                            </a>
                        @endforeach
                        <!-- Spacer untuk margin akhir -->
                        <div class="flex-shrink-0 w-4"></div>
                    </div>
                </div>

                <!-- Desktop: grid dengan text minimal -->
                <div class="hidden md:grid grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach ($categories as $c)
                        <a href="{{ route('mitra.products', ['category' => $c->id]) }}"
                            class="group p-4 md:p-5 rounded-2xl bg-white shadow-md hover:shadow-xl border border-gray-100 hover:border-orange-200 transition-all duration-300 hover:-translate-y-1">
                            <div
                                class="text-sm font-semibold text-gray-800 group-hover:text-orange-600 line-clamp-2 transition-colors">
                                {{ $c->title }}</div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="rounded-2xl bg-white shadow-md p-12 text-center text-gray-500 border border-gray-100">Belum ada
                    kategori</div>
            @endif
        </div>
        

        <!-- Katalog Produk EKRAF (Produk dari Mitra Lain) -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-2 flex items-center">
                        <span class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center mr-3 shadow-md">
                            <x-heroicon-o-building-storefront class="w-6 h-6 text-white" />
                        </span>
                        Katalog Produk Pelaku Ekraf
                    </h3>
                    <p class="text-sm text-gray-600 ml-13">
                        Jelajahi produk dari Pelaku Ekraf lainnya
                        <span class="inline-flex items-center ml-2 px-2 py-1 mt-4 bg-blue-500 text-white text-xs font-semibold rounded-full shadow-sm">
                            <x-heroicon-o-eye class="w-4 h-4 mr-1" />
                            Hanya Lihat
                        </span>
                    </p>
                </div>
                <a href="{{ route('katalog') }}"
                    class="hidden md:inline-flex items-center text-orange-600 hover:text-orange-700 font-semibold transition-colors">
                    Lihat Semua
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            @if ($katalogsBySubSektor->count() > 0)
                @foreach ($katalogsBySubSektor as $subSektor)
                    @if ($subSektor->katalogs->count() > 0)
                        <div class="mb-10">
                            <!-- Sub Sektor Header -->
                            <div class="mb-5 pb-3 border-b-2 border-orange-200">
                                <h4 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                                    <span class="w-2 h-8 bg-gradient-to-b from-orange-400 to-orange-600 rounded-full mr-3 shadow-sm"></span>
                                    {{ $subSektor->title }}
                                    <span class="ml-3 px-2.5 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">
                                        {{ $subSektor->katalogs->count() }} Katalog
                                    </span>
                                </h4>
                            </div>

                            <!-- Katalog Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 md:gap-6">
                                @foreach ($subSektor->katalogs->take(4) as $katalog)
                                    <a href="{{ route('katalog.show', $katalog->slug) }}" class="group block">
                                        <div
                                            class="rounded-2xl bg-white shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2 border-2 border-gray-100 hover:border-orange-300">
                                            <!-- Katalog Image -->
                                            <div class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden relative">
                                                <img src="{{ $katalog->image_url }}" alt="{{ $katalog->title }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                                    onerror="this.onerror=null; this.src='{{ asset('assets/img/placeholder-catalog.svg') }}';" />

                                                <!-- Overlay Gradient -->
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                                <!-- View Count Badge -->
                                                <div class="absolute top-3 right-3">
                                                    <span
                                                        class="px-3 py-1.5 bg-black/70 backdrop-blur-sm text-white text-xs font-bold rounded-full shadow-lg flex items-center">
                                                        <i class="fas fa-eye mr-1.5"></i>{{ number_format($katalog->views_count) }}
                                                    </span>
                                                </div>

                                                <!-- Product Count Badge -->
                                                <div class="absolute bottom-3 left-3">
                                                    <span
                                                        class="px-3 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-xs font-bold rounded-full shadow-lg flex items-center">
                                                        <i class="fas fa-box mr-1.5"></i>{{ $katalog->products->count() }} Produk
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Katalog Info -->
                                            <div class="p-5">
                                                <h5
                                                    class="text-base font-bold text-gray-900 line-clamp-2 mb-3 min-h-[3rem] group-hover:text-orange-600 transition-colors leading-tight">
                                                    {{ $katalog->title }}
                                                </h5>

                                                <p class="text-sm text-gray-600 mb-4 line-clamp-2 leading-relaxed">
                                                    {{ Str::limit(strip_tags($katalog->content), 80) }}
                                                </p>

                                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                                    <span class="text-xs text-gray-500 flex items-center">
                                                        <i class="fas fa-calendar-alt mr-1.5 text-orange-500"></i>
                                                        {{ $katalog->created_at->format('d M Y') }}
                                                    </span>
                                                    <span class="text-xs font-semibold text-orange-600 flex items-center group-hover:translate-x-1 transition-transform">
                                                        Lihat Detail
                                                        <i class="fas fa-arrow-right ml-1.5"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                <!-- CTA to Full Catalog -->
                <div class="text-center mt-4 border-t-2 border-orange-200">
                    <a href="{{ route('katalog') }}"
                        class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-lg font-bold rounded-2xl hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 mt-3">
                        {{-- <i class="fas fa-store mr-3 text-sm "></i> --}}
                        <x-heroicon-o-building-storefront class="w-6 h-6 text-sm " />
                        Jelajahi Semua Katalog
                        <i class="fas fa-arrow-right ml-3 text-xl"></i>
                    </a>
                    <p class="text-sm text-gray-500 mt-3">
                        Temukan lebih banyak produk kreatif dari seluruh Pelaku EKRAF
                    </p>
                </div>
            @else
                <!-- Empty State -->
                <div class="rounded-2xl bg-gradient-to-br from-orange-50 to-white shadow-lg border-2 border-orange-200 p-16 text-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-orange-100 to-orange-200 rounded-full mx-auto mb-6 flex items-center justify-center shadow-md">
                        <i class="fas fa-store text-5xl text-orange-500"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-3">Belum Ada Katalog Tersedia</h4>
                    <p class="text-gray-600 text-base mb-2">Katalog produk akan muncul ketika ada Pelaku EKRAF lain</p>
                    <p class="text-gray-500 text-sm mb-8">yang telah mengunggah produk mereka</p>
                    <a href="{{ route('katalog') }}"
                        class="inline-flex items-center px-8 py-3.5 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white text-base font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 mt-3">
                        <i class="fas fa-search mr-2"></i>
                        Jelajahi Katalog EKRAF
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @endif
        </div>

    </div>
    
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Delete Modal Functions
    

    // Chart.js for Daily Views
    const ctx = document.getElementById('viewsChart').getContext('2d');
    const viewsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyViews->pluck('date')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d M'))) !!},
            datasets: [{
                label: 'Kunjungan',
                data: {!! json_encode($dailyViews->pluck('count')) !!},
                borderColor: 'rgb(249, 115, 22)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(249, 115, 22)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 13
                    },
                    cornerRadius: 8,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Product Modal Functions
    const productsData = {!! json_encode($products->mapWithKeys(function($p) {
        return [$p->id => [
            'id' => $p->id,
            'name' => $p->name,
            'description' => $p->description,
            'price' => $p->price,
            'stock' => $p->stock,
            'phone_number' => $p->user->phone_number ?? '-',
            'image' => $p->image_url,
            'status' => $p->status,
            'category' => optional($p->subSektor)->title ?? 'Tanpa Kategori',
            'business_category' => optional($p->businessCategory)->name ?? null,
            'uploaded_at' => $p->uploaded_at ? $p->uploaded_at->format('d M Y, H:i') : null,
        ]];
    })) !!};

    function openProductModal(productId) {
        const modal = document.getElementById('productModal');
        const modalContent = document.getElementById('modalContent');
        const product = productsData[productId];
        
        if (!product) return;
        
        // Status badge color
        let statusBadge = '';
        if (product.status === 'approved') {
            statusBadge = '<span class="px-4 py-2 bg-green-100 text-green-700 text-sm font-semibold rounded-full"><i class="fas fa-check-circle mr-1"></i>Aktif</span>';
        } else if (product.status === 'pending') {
            statusBadge = '<span class="px-4 py-2 bg-orange-100 text-orange-700 text-sm font-semibold rounded-full"><i class="fas fa-clock mr-1"></i>Pending</span>';
        } else {
            statusBadge = '<span class="px-4 py-2 bg-red-100 text-red-700 text-sm font-semibold rounded-full"><i class="fas fa-times-circle mr-1"></i>Ditolak</span>';
        }
        
        // Build modal content
        modalContent.innerHTML = `
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Image Section -->
                <div class="space-y-4">
                    <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden">
                        ${product.image 
                            ? `<img src="${product.image}" alt="${product.name}" class="w-full h-full object-cover">`
                            : `<div class="w-full h-full flex items-center justify-center">
                                   <i class="fas fa-image text-gray-300 text-8xl"></i>
                               </div>`
                        }
                    </div>
                </div>

                <!-- Info Section -->
                <div class="space-y-6">
                    <!-- Status & Category -->
                    <div class="flex items-center gap-3 flex-wrap">
                        ${statusBadge}
                        <span class="px-4 py-2 bg-orange-50 text-orange-700 text-sm font-semibold rounded-full">
                            <i class="fas fa-tag mr-1"></i>${product.category}
                        </span>
                    </div>

                    <!-- Product Name -->
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">${product.name}</h2>
                        ${product.uploaded_at ? `<p class="text-sm text-gray-500"><i class="fas fa-calendar-alt mr-1"></i>Ditambahkan: ${product.uploaded_at}</p>` : ''}
                    </div>

                    <!-- Price & Stock -->
                    <div class="flex items-center gap-6 p-4 bg-gradient-to-r from-orange-50 to-orange-100 rounded-xl">
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-1">Harga</p>
                            <p class="text-2xl font-bold text-orange-600">Rp ${new Intl.NumberFormat('id-ID').format(product.price)}</p>
                        </div>
                        <div class="h-12 w-px bg-orange-300"></div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600 mb-1">Stok</p>
                            <p class="text-2xl font-bold text-gray-900">${product.stock}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <h4 class="font-bold text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-align-left text-orange-500 mr-2"></i>
                            Deskripsi
                        </h4>
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">${product.description}</p>
                    </div>

                    ${product.business_category ? `
                    <div class="p-4 bg-blue-50 rounded-xl">
                        <h4 class="font-bold text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-briefcase text-blue-500 mr-2"></i>
                            Kategori Bisnis
                        </h4>
                        <p class="text-gray-700">${product.business_category}</p>
                    </div>
                    ` : ''}

                    <!-- Contact -->
                    <div class="p-4 bg-green-50 rounded-xl">
                        <h4 class="font-bold text-gray-900 mb-2 flex items-center">
                            <i class="fas fa-phone text-green-500 mr-2"></i>
                            Kontak
                        </h4>
                        <a href="tel:${product.phone_number}" class="text-green-600 hover:text-green-700 font-semibold text-lg">
                            ${product.phone_number}
                        </a>
                    </div>
                </div>
            </div>
            </div>
        `;
        
        // Tampilkan modal dengan animasi
        modal.classList.remove('hidden');
        const modalBox = document.getElementById('modalBox');
        
        // Reset position untuk animasi
        modalBox.style.transform = 'translateY(-100px)';
        modalBox.style.opacity = '0';
        
        // Trigger animasi slide down
        setTimeout(() => {
            modalBox.style.transform = 'translateY(0)';
            modalBox.style.opacity = '1';
        }, 10);
        
        document.body.style.overflow = 'hidden';
        
        // Scroll modal content ke atas
        const modalContentScroll = document.getElementById('modalContent');
        modalContentScroll.scrollTop = 0;
    }

    function closeProductModal() {
        const modal = document.getElementById('productModal');
        const modalBox = document.getElementById('modalBox');
        
        // Animasi slide up sebelum close
        modalBox.style.transform = 'translateY(-100px)';
        modalBox.style.opacity = '0';
        
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // Close modal on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeProductModal();
        }
    });

</script>
@endpush
