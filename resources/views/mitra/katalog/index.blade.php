@extends('layouts.mitra')

@section('title', 'Katalog Produk EKRAF')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-store text-orange-500 mr-2"></i>
            Katalog Produk EKRAF
        </h1>
        <p class="text-gray-600">Jelajahi katalog produk ekonomi kreatif dari berbagai sub sektor</p>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('mitra.katalog') }}" class="space-y-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari katalog atau deskripsi..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    >
                </div>
            </div>
            
            <!-- Filters Row -->
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Sub Sektor Filter -->
                <div class="flex-1">
                    <label class="block text-xs text-gray-600 mb-1">
                        <i class="fas fa-tag mr-1"></i>
                        Kategori
                    </label>
                    <select 
                        name="sub_sektor" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach($subSektors as $subSektor)
                            <option value="{{ $subSektor->id }}" {{ request('sub_sektor') == $subSektor->id ? 'selected' : '' }}>
                                {{ $subSektor->title }} ({{ $subSektor->katalogs_count }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition"
                >
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
                @if(request('search') || request('sub_sektor'))
                    <a 
                        href="{{ route('mitra.katalog') }}" 
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                    >
                        <i class="fas fa-redo mr-2"></i>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Active Filter Info -->
    @if($selectedSubSektor || request('search'))
        <div class="mb-6 flex flex-wrap items-center gap-2">
            <span class="text-sm text-gray-600">Filter aktif:</span>
            @if($selectedSubSektor)
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-sm">
                    <i class="fas fa-tag mr-2"></i>
                    {{ $selectedSubSektor->title }}
                    <a href="{{ route('mitra.katalog', ['search' => request('search')]) }}" class="ml-2 hover:text-orange-900">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
            @if(request('search'))
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                    <i class="fas fa-search mr-2"></i>
                    "{{ request('search') }}"
                    <a href="{{ route('mitra.katalog', ['sub_sektor' => request('sub_sektor')]) }}" class="ml-2 hover:text-blue-900">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
        </div>
    @endif

    <!-- Katalogs Grid -->
    @if($katalogs->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
            @foreach($katalogs as $katalog)
                <a href="{{ route('katalog.show', $katalog->slug) }}" class="group">
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
                        <!-- Katalog Image -->
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            <img 
                                src="{{ $katalog->image_url }}" 
                                alt="{{ $katalog->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                onerror="this.onerror=null; this.src='{{ asset('assets/img/placeholder-catalog.svg') }}';"
                            >
                            
                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1 bg-orange-500 text-white text-xs font-semibold rounded-full shadow-lg">
                                    {{ $katalog->subSektor->title ?? 'Uncategorized' }}
                                </span>
                            </div>

                            <!-- View Count -->
                            <div class="absolute top-3 right-3">
                                <span class="px-3 py-1 bg-black bg-opacity-60 text-white text-xs font-semibold rounded-full shadow-lg">
                                    <i class="fas fa-eye mr-1"></i>{{ number_format($katalog->views_count) }}
                                </span>
                            </div>

                            <!-- Product Count -->
                            <div class="absolute bottom-3 left-3">
                                <span class="px-3 py-1 bg-blue-500 text-white text-xs font-semibold rounded-full shadow-lg">
                                    <i class="fas fa-box mr-1"></i>{{ $katalog->products->count() }} Produk
                                </span>
                            </div>
                        </div>

                        <!-- Katalog Info -->
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-gray-800 mb-1 line-clamp-2 group-hover:text-orange-600 transition">
                                {{ $katalog->title }}
                            </h3>
                            
                            <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                                {{ Str::limit(strip_tags($katalog->content), 80) }}
                            </p>

                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $katalog->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $katalogs->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                <i class="fas fa-search text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Katalog Tidak Ditemukan</h3>
            <p class="text-gray-600 mb-4">
                @if(request('search'))
                    Tidak ada katalog yang cocok dengan pencarian "{{ request('search') }}"
                @elseif($selectedSubSektor)
                    Belum ada katalog di kategori {{ $selectedSubSektor->title }}
                @else
                    Belum ada katalog yang tersedia
                @endif
            </p>
            <a href="{{ route('mitra.katalog') }}" class="inline-block px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                <i class="fas fa-redo mr-2"></i>
                Lihat Semua Katalog
            </a>
        </div>
    @endif
</div>
@endsection

@section('title', 'Katalog Produk EKRAF')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-store text-orange-500 mr-2"></i>
            Katalog Produk EKRAF
        </h1>
        <p class="text-gray-600">Jelajahi produk ekonomi kreatif dari berbagai sub sektor</p>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('mitra.katalog') }}" class="space-y-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Cari produk, pemilik, atau deskripsi..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    >
                </div>
            </div>
            
            <!-- Filters Row -->
            <div class="flex flex-col md:flex-row gap-4">
                <!-- Sub Sektor Filter -->
                <div class="flex-1">
                    <label class="block text-xs text-gray-600 mb-1">
                        <i class="fas fa-tag mr-1"></i>
                        Kategori
                    </label>
                    <select 
                        name="sub_sektor" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <option value="">Semua Kategori</option>
                        @foreach($subSektors as $subSektor)
                            <option value="{{ $subSektor->id }}" {{ request('sub_sektor') == $subSektor->id ? 'selected' : '' }}>
                                {{ $subSektor->title }} ({{ $subSektor->products_count }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Katalog Saya Toggle -->
                <div class="flex-1">
                    <label class="block text-xs text-gray-600 mb-1">
                        <i class="fas fa-user-check mr-1"></i>
                        Tampilkan
                    </label>
                    <select 
                        name="my_products" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                    >
                        <option value="">Semua Produk</option>
                        <option value="1" {{ request('my_products') ? 'selected' : '' }}>
                            <i class="fas fa-star mr-1"></i>
                            Katalog Saya
                        </option>
                    </select>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition"
                >
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
                @if(request('search') || request('sub_sektor') || request('my_products'))
                    <a 
                        href="{{ route('mitra.katalog') }}" 
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition"
                    >
                        <i class="fas fa-redo mr-2"></i>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Active Filter Info -->
    @if($selectedSubSektor || request('my_products') || request('search'))
        <div class="mb-6 flex flex-wrap items-center gap-2">
            <span class="text-sm text-gray-600">Filter aktif:</span>
            @if($selectedSubSektor)
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-sm">
                    <i class="fas fa-tag mr-2"></i>
                    {{ $selectedSubSektor->title }}
                    <a href="{{ route('mitra.katalog', ['search' => request('search'), 'my_products' => request('my_products')]) }}" class="ml-2 hover:text-orange-900">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
            @if(request('my_products'))
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-purple-100 text-purple-700 text-sm">
                    <i class="fas fa-user-check mr-2"></i>
                    Katalog Saya
                    <a href="{{ route('mitra.katalog', ['search' => request('search'), 'sub_sektor' => request('sub_sektor')]) }}" class="ml-2 hover:text-purple-900">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
            @if(request('search'))
                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">
                    <i class="fas fa-search mr-2"></i>
                    "{{ request('search') }}"
                    <a href="{{ route('mitra.katalog', ['sub_sektor' => request('sub_sektor'), 'my_products' => request('my_products')]) }}" class="ml-2 hover:text-blue-900">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
            @endif
        </div>
    @endif

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
            @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                    <!-- Product Image -->
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <img 
                            src="{{ $product->image_url }}" 
                            alt="{{ $product->name }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                            onerror="this.onerror=null; this.src='{{ asset('assets/img/placeholder-product.svg') }}';"
                        >
                        
                        <!-- Category Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 bg-orange-500 text-white text-xs font-semibold rounded-full shadow-lg">
                                {{ $product->subSektor->title ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <!-- Stock Badge -->
                        @if($product->stock <= 0)
                            <div class="absolute top-3 right-3">
                                <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg">
                                    Habis
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800 mb-1 line-clamp-2 group-hover:text-orange-600 transition">
                            {{ $product->name }}
                        </h3>
                        
                        <p class="text-sm text-gray-600 mb-2 flex items-center">
                            <i class="fas fa-user text-gray-400 mr-2"></i>
                            {{ $product->user->name }}
                        </p>

                        <p class="text-gray-600 text-sm line-clamp-2 mb-3">
                            {{ $product->description }}
                        </p>

                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <p class="text-xs text-gray-500">Harga</p>
                                <p class="text-lg font-bold text-orange-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">Stok</p>
                                <p class="text-lg font-bold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $product->stock }}
                                </p>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a 
                                href="{{ route('mitra.katalog.show', $product->id) }}" 
                                class="flex-1 px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center rounded-lg hover:from-orange-600 hover:to-orange-700 transition text-sm font-medium"
                            >
                                <i class="fas fa-eye mr-2"></i>
                                Detail
                            </a>
                            <a 
                                href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->user->phone_number) }}?text=Halo, saya tertarik dengan produk {{ $product->name }}" 
                                target="_blank"
                                class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-sm"
                            >
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full mx-auto mb-4 flex items-center justify-center">
                <i class="fas fa-search text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Produk Tidak Ditemukan</h3>
            <p class="text-gray-600 mb-4">
                @if(request('my_products'))
                    @if(request('search'))
                        Tidak ada produk Anda yang cocok dengan pencarian "{{ request('search') }}"
                    @elseif($selectedSubSektor)
                        Anda belum memiliki produk di kategori {{ $selectedSubSektor->title }}
                    @else
                        Anda belum memiliki produk. <a href="{{ route('mitra.products.create') }}" class="text-orange-600 hover:underline">Tambah produk sekarang</a>
                    @endif
                @elseif(request('search'))
                    Tidak ada produk yang cocok dengan pencarian "{{ request('search') }}"
                @elseif($selectedSubSektor)
                    Belum ada produk di kategori {{ $selectedSubSektor->title }}
                @else
                    Belum ada produk yang tersedia
                @endif
            </p>
            <a href="{{ route('mitra.katalog') }}" class="inline-block px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                <i class="fas fa-redo mr-2"></i>
                Lihat Semua Produk
            </a>
        </div>
    @endif
</div>
@endsection
