@extends('layouts.mitra')

@section('title', 'Tambah Katalog')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('mitra.katalog-management.index') }}" class="inline-flex items-center text-gray-600 hover:text-orange-600 transition mb-4">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Katalog
        </a>
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">
            <i class="fas fa-plus-circle text-orange-500 mr-2"></i>
            Tambah Katalog Baru
        </h1>
        <p class="text-gray-600 mt-2">Buat katalog untuk mengelompokkan produk Anda</p>
    </div>

    <!-- Form -->
    <form action="{{ route('mitra.katalog-management.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Sub Sektor -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <label for="sub_sector_id" class="block text-sm font-semibold text-gray-900 mb-2">
                Sub Sektor <span class="text-red-500">*</span>
            </label>
            <select name="sub_sector_id" id="sub_sector_id" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('sub_sector_id') border-red-500 @enderror">
                <option value="">Pilih Sub Sektor</option>
                @foreach($subSektors as $subSektor)
                    <option value="{{ $subSektor->id }}" {{ old('sub_sector_id') == $subSektor->id ? 'selected' : '' }}>
                        {{ $subSektor->title }}
                    </option>
                @endforeach
            </select>
            @error('sub_sector_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Title -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">
                Judul Katalog <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('title') border-red-500 @enderror"
                   placeholder="Contoh: Koleksi Batik Premium">
            @error('title')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Products Selection -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <label class="block text-sm font-semibold text-gray-900 mb-2">
                Pilih Produk <span class="text-red-500">*</span>
            </label>
            <p class="text-sm text-gray-600 mb-4">Pilih produk yang akan ditampilkan dalam katalog ini (hanya produk yang sudah disetujui)</p>
            
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto p-4 border border-gray-200 rounded-lg">
                    @foreach($products as $product)
                        <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg hover:border-orange-500 cursor-pointer transition {{ in_array($product->id, old('products', [])) ? 'border-orange-500 bg-orange-50' : '' }}">
                            <input type="checkbox" name="products[]" value="{{ $product->id }}" 
                                   {{ in_array($product->id, old('products', [])) ? 'checked' : '' }}
                                   class="mt-1 h-5 w-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                            <div class="ml-3 flex-1">
                                <div class="flex items-start gap-3">
                                    @if($product->image)
                                        <img src="{{ Storage::disk('public')->url($product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                        <p class="text-xs text-gray-500 mb-1">
                                            <i class="fas fa-user mr-1"></i>{{ $product->user->name }}
                                        </p>
                                        <p class="text-sm text-gray-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Stok: {{ $product->stock }}</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('products')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            @else
                <div class="text-center py-8 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <i class="fas fa-exclamation-circle text-yellow-500 text-3xl mb-3"></i>
                    <p class="text-gray-700 font-medium mb-2">Belum Ada Produk yang Disetujui</p>
                    <p class="text-sm text-gray-600 mb-4">Anda perlu menambahkan dan mendapat persetujuan untuk produk terlebih dahulu sebelum membuat katalog.</p>
                    <a href="{{ route('mitra.products.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Produk
                    </a>
                </div>
            @endif
        </div>

        <!-- Image Upload (Optional) -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <label for="image" class="block text-sm font-semibold text-gray-900 mb-2">
                Gambar Katalog (Opsional)
            </label>
            <p class="text-sm text-gray-600 mb-4">
                Jika tidak diisi, gambar produk pertama yang dipilih akan digunakan sebagai gambar katalog
            </p>
            <input type="file" name="image" id="image" accept="image/*"
                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('image') border-red-500 @enderror">
            <p class="mt-2 text-xs text-gray-500">Format: JPG, PNG, WEBP. Maksimal 8MB</p>
            @error('image')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <label for="content" class="block text-sm font-semibold text-gray-900 mb-2">
                Deskripsi Katalog <span class="text-red-500">*</span>
            </label>
            <textarea name="content" id="content" rows="6" required
                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('content') border-red-500 @enderror"
                      placeholder="Jelaskan tentang katalog ini...">{{ old('content') }}</textarea>
            @error('content')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Social Media Links (Optional) -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-4">Media Sosial & Toko Online (Opsional)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fab fa-instagram text-pink-600 mr-1"></i> Instagram
                    </label>
                    <input type="url" name="instagram" id="instagram" value="{{ old('instagram') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                           placeholder="https://instagram.com/username">
                </div>
                <div>
                    <label for="shopee" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-shopping-bag text-orange-600 mr-1"></i> Shopee
                    </label>
                    <input type="url" name="shopee" id="shopee" value="{{ old('shopee') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                           placeholder="https://shopee.co.id/shop/username">
                </div>
                <div>
                    <label for="tokopedia" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-store text-green-600 mr-1"></i> Tokopedia
                    </label>
                    <input type="url" name="tokopedia" id="tokopedia" value="{{ old('tokopedia') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                           placeholder="https://tokopedia.com/shop-name">
                </div>
                <div>
                    <label for="lazada" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag text-blue-600 mr-1"></i> Lazada
                    </label>
                    <input type="url" name="lazada" id="lazada" value="{{ old('lazada') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                           placeholder="https://lazada.co.id/shop/shop-name">
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
            <a href="{{ route('mitra.katalog-management.index') }}" 
               class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition text-center">
                Batal
            </a>
            <button type="submit" 
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transition shadow-lg">
                <i class="fas fa-save mr-2"></i>
                Simpan Katalog
            </button>
        </div>
    </form>
</div>
@endsection
