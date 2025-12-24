@extends('layouts.pelaku-ekraf')

@section('title', 'Detail Katalog')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('pelaku-ekraf.katalog-management.index') }}" 
           class="inline-flex items-center text-gray-600 hover:text-orange-600 transition mb-4">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Katalog
        </a>
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    {{ $katalog->title }}
                </h1>
                <div class="flex items-center gap-4 text-sm text-gray-600">
                    <span class="flex items-center">
                        <i class="fas fa-tag mr-1.5 text-orange-500"></i>
                        {{ $katalog->subSektor->title }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-box mr-1.5 text-orange-500"></i>
                        {{ $katalog->products->count() }} Produk
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Cover Image -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="relative h-96 bg-gray-100">
                    <img src="{{ $katalog->image_url }}" 
                         alt="{{ $katalog->title }}" 
                         class="w-full h-full object-cover"
                         onerror="this.src='https://via.placeholder.com/800x600?text=No+Image'">
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-orange-500 mr-2"></i>
                    Deskripsi
                </h2>
                <div class="prose max-w-none text-gray-700 whitespace-pre-line">
                    {{ strip_tags($katalog->content) }}
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-box text-orange-500 mr-2"></i>
                    Produk dalam Katalog ({{ $katalog->products->count() }})
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($katalog->products as $product)
                        <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-orange-500 transition">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-24 h-24 object-cover rounded-lg"
                                             onerror="this.src='https://via.placeholder.com/100?text=No+Image'">
                                    @else
                                        <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-3xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 mb-1">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $product->description }}</p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-orange-600 font-bold">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        <span class="text-xs px-2 py-1 rounded-full
                                            {{ $product->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $product->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $product->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ ucfirst($product->status) }}
                                        </span>
                                    </div>
                                    <div class="mt-2 text-xs text-gray-500">
                                        <i class="fas fa-warehouse mr-1"></i>
                                        Stok: {{ $product->stock }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-8 text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-3"></i>
                            <p>Tidak ada produk dalam katalog ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Katalog Info -->
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-orange-500 mr-2"></i>
                    Informasi Katalog
                </h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Slug</label>
                        <p class="text-gray-900 font-mono text-sm break-all">{{ $katalog->slug }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Sub Sektor</label>
                        <p class="text-gray-900">{{ $katalog->subSektor->title }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Total Produk</label>
                        <p class="text-gray-900">{{ $katalog->products->count() }} Produk</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Dibuat</label>
                        <p class="text-gray-900">{{ $katalog->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Terakhir Diperbarui</label>
                        <p class="text-gray-900">{{ $katalog->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            @if($katalog->instagram || $katalog->shopee || $katalog->tokopedia || $katalog->lazada)
            <div class="bg-white rounded-2xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-share-alt text-orange-500 mr-2"></i>
                    Media Sosial & Toko Online
                </h3>
                <div class="space-y-3">
                    @if($katalog->instagram)
                    <a href="{{ $katalog->instagram }}" target="_blank" 
                       class="flex items-center gap-3 p-3 bg-pink-50 hover:bg-pink-100 rounded-lg transition group">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg flex items-center justify-center text-white">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Instagram</p>
                            <p class="text-xs text-gray-500 truncate">{{ $katalog->instagram }}</p>
                        </div>
                        <i class="fas fa-external-link-alt text-gray-400 group-hover:text-pink-500"></i>
                    </a>
                    @endif

                    @if($katalog->shopee)
                    <a href="{{ $katalog->shopee }}" target="_blank" 
                       class="flex items-center gap-3 p-3 bg-orange-50 hover:bg-orange-100 rounded-lg transition group">
                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center text-white">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Shopee</p>
                            <p class="text-xs text-gray-500 truncate">{{ $katalog->shopee }}</p>
                        </div>
                        <i class="fas fa-external-link-alt text-gray-400 group-hover:text-orange-500"></i>
                    </a>
                    @endif

                    @if($katalog->tokopedia)
                    <a href="{{ $katalog->tokopedia }}" target="_blank" 
                       class="flex items-center gap-3 p-3 bg-green-50 hover:bg-green-100 rounded-lg transition group">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center text-white">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Tokopedia</p>
                            <p class="text-xs text-gray-500 truncate">{{ $katalog->tokopedia }}</p>
                        </div>
                        <i class="fas fa-external-link-alt text-gray-400 group-hover:text-green-500"></i>
                    </a>
                    @endif

                    @if($katalog->lazada)
                    <a href="{{ $katalog->lazada }}" target="_blank" 
                       class="flex items-center gap-3 p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition group">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center text-white">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Lazada</p>
                            <p class="text-xs text-gray-500 truncate">{{ $katalog->lazada }}</p>
                        </div>
                        <i class="fas fa-external-link-alt text-gray-400 group-hover:text-blue-500"></i>
                    </a>
                    @endif
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-md p-6 text-white">
                <h3 class="text-lg font-bold mb-4 flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat Katalog
                </h3>
                <a href="{{ route('katalog.show', $katalog->slug) }}" 
                   target="_blank"
                   class="block w-full py-2.5 px-4 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-lg text-center font-medium transition">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Buka di Website Publik
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
