@extends('layouts.pelaku-ekraf')

@section('title', $product->name . ' - Katalog Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('pelaku-ekraf.katalog') }}" class="inline-flex items-center text-gray-600 hover:text-orange-600 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Katalog
        </a>
    </div>

    <!-- Product Detail -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Product Image -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <img 
                src="{{ $product->image_url }}" 
                alt="{{ $product->name }}"
                class="w-full h-auto object-cover"
                onerror="this.onerror=null; this.src='{{ asset('assets/img/placeholder-product.svg') }}';"
            >
        </div>

        <!-- Product Info -->
        <div class="space-y-6">
            <!-- Title & Category -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="mb-4">
                    <span class="inline-block px-4 py-1 bg-orange-100 text-orange-700 text-sm font-semibold rounded-full">
                        {{ $product->subSektor->title ?? 'Uncategorized' }}
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                
                <!-- Price & Stock -->
                <div class="flex items-center gap-6 mb-4">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Harga</p>
                        <p class="text-3xl font-bold text-orange-600">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="border-l border-gray-200 pl-6">
                        <p class="text-sm text-gray-600 mb-1">Stok Tersedia</p>
                        <p class="text-2xl font-bold {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->stock }} Unit
                        </p>
                    </div>
                </div>

                @if($product->stock <= 0)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                        <span class="text-red-700 font-medium">Produk ini sedang habis stok</span>
                    </div>
                @endif
            </div>

            <!-- Owner Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-store text-orange-500 mr-2"></i>
                    Informasi Penjual
                </h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-user text-gray-400 w-6"></i>
                        <span class="text-gray-700 ml-3">{{ $product->user->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-400 w-6"></i>
                        <span class="text-gray-700 ml-3">{{ $product->user->phone_number }}</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-map-marker-alt text-gray-400 w-6 mt-1"></i>
                        <span class="text-gray-700 ml-3">{{ $product->address }}</span>
                    </div>
                    @if($product->businessCategory)
                        <div class="flex items-center">
                            <i class="fas fa-briefcase text-gray-400 w-6"></i>
                            <span class="text-gray-700 ml-3">{{ $product->businessCategory->title }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Actions -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white">
                <h3 class="text-lg font-bold mb-3">
                    <i class="fab fa-whatsapp mr-2"></i>
                    Hubungi Penjual
                </h3>
                <p class="text-green-100 text-sm mb-4">
                    Tertarik dengan produk ini? Hubungi penjual langsung via WhatsApp
                </p>
                <a 
                    href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $product->user->phone_number) }}?text=Halo, saya tertarik dengan produk {{ $product->name }} dengan harga Rp {{ number_format($product->price, 0, ',', '.') }}" 
                    target="_blank"
                    class="block w-full px-6 py-3 bg-white text-green-600 text-center rounded-lg hover:bg-green-50 transition font-medium"
                >
                    <i class="fab fa-whatsapp mr-2"></i>
                    Chat di WhatsApp
                </a>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            <i class="fas fa-file-alt text-orange-500 mr-2"></i>
            Deskripsi Produk
        </h2>
        <div class="text-gray-700 leading-relaxed whitespace-pre-line">
            {{ $product->description }}
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-layer-group text-orange-500 mr-2"></i>
                    Produk Terkait
                </h2>
                <a href="{{ route('pelaku-ekraf.katalog', ['sub_sektor' => $product->sub_sektor_id]) }}" class="text-orange-600 hover:text-orange-700 font-medium">
                    Lihat Semua
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-gray-100">
                            <img 
                                src="{{ $related->image_url }}" 
                                alt="{{ $related->name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                onerror="this.onerror=null; this.src='{{ asset('assets/img/placeholder-product.svg') }}';"
                            >
                            
                            @if($related->stock <= 0)
                                <div class="absolute top-3 right-3">
                                    <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg">
                                        Habis
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <h3 class="text-base font-bold text-gray-800 mb-1 line-clamp-2 group-hover:text-orange-600 transition">
                                {{ $related->name }}
                            </h3>
                            
                            <p class="text-sm text-gray-600 mb-2 truncate">
                                <i class="fas fa-user text-gray-400 mr-1"></i>
                                {{ $related->user->name }}
                            </p>

                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <p class="text-xs text-gray-500">Harga</p>
                                    <p class="text-base font-bold text-orange-600">
                                        Rp {{ number_format($related->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">Stok</p>
                                    <p class="text-base font-bold {{ $related->stock > 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $related->stock }}
                                    </p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <a 
                                href="{{ route('pelaku-ekraf.katalog.show', $related->id) }}" 
                                class="block w-full px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center rounded-lg hover:from-orange-600 hover:to-orange-700 transition text-sm font-medium"
                            >
                                <i class="fas fa-eye mr-2"></i>
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Share Section -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">
            <i class="fas fa-share-alt text-orange-500 mr-2"></i>
            Bagikan Produk
        </h3>
        <div class="flex flex-wrap gap-3">
            <a 
                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                target="_blank"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
            >
                <i class="fab fa-facebook mr-2"></i>
                Facebook
            </a>
            <a 
                href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($product->name) }}" 
                target="_blank"
                class="px-4 py-2 bg-sky-500 text-white rounded-lg hover:bg-sky-600 transition"
            >
                <i class="fab fa-twitter mr-2"></i>
                Twitter
            </a>
            <a 
                href="https://wa.me/?text={{ urlencode($product->name . ' - ' . url()->current()) }}" 
                target="_blank"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
            >
                <i class="fab fa-whatsapp mr-2"></i>
                WhatsApp
            </a>
            <button 
                onclick="copyToClipboard('{{ url()->current() }}')"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition"
            >
                <i class="fas fa-link mr-2"></i>
                Salin Link
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        alert('Link berhasil disalin!');
    }).catch(() => {
        alert('Gagal menyalin link');
    });
}
</script>
@endpush
@endsection
