@extends('layouts.app')
@section('title', $katalog->title)

@section('content')
    <!-- Banner -->
    <div class="relative h-44 md:h-64 bg-center bg-cover flex items-center"
        style="background-image: url('{{ asset('assets/img/Katalog.png') }}');">
        <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white text-left px-6 md:px-12">
            <p class="mt-2 text-base md:text-lg">
                <a href="/" class="hover:underline">Home</a> > <a href="/katalog" class="hover:underline">Katalog</a> >
                {{ $katalog->title }}
            </p>
            <h1 class="text-3xl md:text-5xl font-bold">{{ $katalog->title }}</h1>
        </div>
    </div>

    <!-- Detail Produk -->
    <div class="max-w-6xl mx-auto py-10 px-6">
        <div class="grid md:grid-cols-2 gap-8 mb-8 items-start">
            <div class="bg-white rounded-2xl p-6 shadow border text-gray-700">
                <h2 class="text-lg font-bold text-orange-600 mb-2">{{ $katalog->title ?? 'Judul tidak tersedia' }}</h2>
                <p class="text-sm leading-relaxed mb-6 whitespace-pre-line">
                    {{ strip_tags($katalog->content ?? 'Deskripsi katalog tidak tersedia.') }}
                </p>

                <h3 class="text-orange-500 font-bold text-md mb-2">Sub Sektor</h3>
                <p class="text-sm mb-4">{{ $katalog->subSektor->title ?? 'Sub sektor tidak tersedia' }}</p>

                <h3 class="text-orange-500 font-bold text-md mb-2">Produk dalam Katalog</h3>
                @if($katalog->products->count() > 0)
                    <p class="text-sm text-gray-600 mb-4">
                        <i class="fas fa-box mr-1"></i>
                        {{ $katalog->products->count() }} produk tersedia
                    </p>
                @else
                    <p class="text-sm text-gray-500 italic mb-4">Belum ada produk dalam katalog ini</p>
                @endif

                <!-- Kontak Informasi -->
                @if($katalog->contact || $katalog->phone_number || $katalog->email || $katalog->instagram || $katalog->shopee || $katalog->tokopedia || $katalog->lazada)
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <h3 class="text-orange-500 font-bold text-md mb-3">Informasi Kontak</h3>
                        
                        @if($katalog->contact)
                            <div class="mb-2">
                                <span class="text-xs text-gray-500">Kontak:</span>
                                <p class="text-sm">{{ $katalog->contact }}</p>
                            </div>
                        @endif
                        
                        @if($katalog->phone_number)
                            <div class="mb-2">
                                <span class="text-xs text-gray-500">Nomor Telepon:</span>
                                <p class="text-sm">{{ $katalog->phone_number }}</p>
                                <a href="https://wa.me/62{{ $katalog->phone_number }}" target="_blank"
                                   class="inline-flex items-center text-green-600 hover:text-green-800 transition text-sm mt-1">
                                    <i class="fab fa-whatsapp mr-1"></i>
                                    Chat WhatsApp
                                </a>
                            </div>
                        @endif
                        
                        @if($katalog->email)
                            <div class="mb-3">
                                <span class="text-xs text-gray-500">Email:</span>
                                <p class="text-sm">
                                    <a href="mailto:{{ $katalog->email }}" class="text-blue-600 hover:text-blue-800 transition">
                                        {{ $katalog->email }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        <!-- Media Sosial & Toko Online -->
                        @if($katalog->instagram || $katalog->shopee || $katalog->tokopedia || $katalog->lazada)
                            <div class="mt-4 pt-3 border-t border-gray-100">
                                <h4 class="text-orange-400 font-semibold text-sm mb-2">Media Sosial & Toko Online</h4>
                                <div class="flex flex-wrap gap-2">
                                    @if($katalog->instagram)
                                        <a href="{{ $katalog->instagram }}" target="_blank"
                                           class="inline-flex items-center px-3 py-1 text-xs bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full hover:from-purple-600 hover:to-pink-600 transition">
                                            <i class="fab fa-instagram mr-1"></i>
                                            Instagram
                                        </a>
                                    @endif
                                    
                                    @if($katalog->shopee)
                                        <a href="{{ $katalog->shopee }}" target="_blank"
                                           class="inline-flex items-center px-3 py-1 text-xs bg-orange-500 text-white rounded-full hover:bg-orange-600 transition">
                                            <i class="fas fa-shopping-bag mr-1"></i>
                                            Shopee
                                        </a>
                                    @endif
                                    
                                    @if($katalog->tokopedia)
                                        <a href="{{ $katalog->tokopedia }}" target="_blank"
                                           class="inline-flex items-center px-3 py-1 text-xs bg-green-500 text-white rounded-full hover:bg-green-600 transition">
                                            <i class="fas fa-store mr-1"></i>
                                            Tokopedia
                                        </a>
                                    @endif
                                    
                                    @if($katalog->lazada)
                                        <a href="{{ $katalog->lazada }}" target="_blank"
                                           class="inline-flex items-center px-3 py-1 text-xs bg-blue-500 text-white rounded-full hover:bg-blue-600 transition">
                                            <i class="fas fa-shopping-cart mr-1"></i>
                                            Lazada
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div>
                <img src="{{ $katalog->image_url }}" alt="{{ $katalog->title }}"
                    class="rounded-2xl shadow w-full object-cover">
            </div>
        </div>

        <!-- Produk dalam Katalog -->
        <section class="mb-12">
            <h2 class="text-2xl font-bold text-orange-600 mb-6">
                <i class="fas fa-shopping-bag mr-2"></i>Produk dalam Katalog Ini
            </h2>
            
            @if($katalog->products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($katalog->products as $product)
                <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100">
                    <!-- Product Image -->
                    <div class="relative">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                            class="w-full h-48 object-cover">

                        <!-- Category Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="inline-block bg-white/90 backdrop-blur text-xs px-2 py-1 rounded-full font-medium text-gray-700 shadow-sm">
                                {{ $product->businessCategory->name ?? 'Kategori' }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="p-4 space-y-3">
                        <!-- Product Name -->
                        <div>
                            <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1 line-clamp-2">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs text-gray-500 font-medium">
                                <i class="fas fa-user text-[10px] mr-1"></i>
                                {{ $product->user->name }}
                            </p>
                        </div>
                        
                        <!-- Price & Stock -->
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-600 font-bold text-sm">
                                    {{ $product->price ? 'Rp ' . number_format($product->price, 0, ',', '.') : 'Hubungi Penjual' }}
                                </p>
                            </div>
                            
                        </div>
                        
                        {{-- <!-- Description -->
                        @if($product->description)
                            <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">
                                {{ Str::limit(strip_tags($product->description), 80) }}
                            </p>
                        @endif --}}

                        <!-- Detail Button -->
                        <button 
                            onclick="openProductModal('{{ $product->id }}')"
                            class="w-full mt-2 px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-sm font-medium rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all duration-200 shadow-sm hover:shadow-md">
                            <i class="fas fa-eye mr-2"></i>
                            Lihat Produk
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
                <!-- Empty State -->
                <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-12 text-center">
                    <div class="max-w-sm mx-auto">
                        <i class="fas fa-box-open text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Produk</h3>
                        <p class="text-gray-500 text-sm">
                            Katalog ini belum memiliki produk yang ditampilkan. Produk akan muncul di sini setelah ditambahkan.
                        </p>
                    </div>
                </div>
            @endif
        </section>

    </div>

    <!-- Produk Lainnya -->
    <section class="max-w-7xl mx-auto pb-12 px-6">
        <h2 class="text-center text-orange-500 font-semibold text-md mb-8">Katalog Lainnya</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-8">
            @foreach ($others as $kat)
                <a href="{{ route('katalog.show', $kat->slug) }}">
                    <div
                        class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition transform hover:scale-105 duration-300">
                        <img src="{{ $kat->image_url }}" alt="{{ $kat->title }}"
                            class="w-full h-40 object-cover">
                        <div class="p-4">
                            <h3 class="text-base font-bold text-orange-600 mb-1">{{ $kat->title }}</h3>
                            <p class="text-xs text-gray-600 mb-3">{{ Str::limit(strip_tags($kat->content), 80) }}</p>
                            <span class="inline-block bg-gray-100 text-[10px] px-2 py-1 rounded-full">
                                {{ $kat->subSektor->title ?? '-' }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Product Detail Modal -->
    <div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" onclick="closeProductModal()">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div id="modalBox" class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden shadow-2xl transform transition-all duration-300" onclick="event.stopPropagation()">
                <!-- Modal Header (Sticky) -->
                <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl z-20 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900">Produk Terkait</h3>
                    <button onclick="closeProductModal()" class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center transition">
                        <i class="fas fa-times text-gray-600 text-xl"></i>
                    </button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div id="modalContent" class="overflow-y-auto" style="max-height: calc(90vh - 5rem);">
                    <div class="p-6">
                        <!-- Loading spinner -->
                        <div class="flex items-center justify-center py-12">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Product data for modal
    const productsData = {!! json_encode($katalog->products->mapWithKeys(function($p) {
        return [$p->id => [
            'id' => $p->id,
            'name' => $p->name,
            'description' => $p->description,
            'price' => $p->price,
            'stock' => $p->stock,
            'phone_number' => $p->user->phone_number ?? '-',
            'user_name' => $p->user->name ?? '-',
            'image' => $p->image_url,
            'category' => optional($p->subSektor)->title ?? 'Tanpa Kategori',
            'business_category' => optional($p->businessCategory)->name ?? null,
        ]];
    })) !!};

    function openProductModal(productId) {
        const modal = document.getElementById('productModal');
        const modalContent = document.getElementById('modalContent');
        const product = productsData[productId];
        
        if (!product) return;
        
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
                        <!-- Category -->
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="px-4 py-2 bg-orange-50 text-orange-700 text-sm font-semibold rounded-full">
                                <i class="fas fa-tag mr-1"></i>${product.category}
                            </span>
                        </div>

                        <!-- Product Name -->
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-2">${product.name}</h2>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-user mr-1"></i>
                                ${product.user_name}
                            </p>
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
                            <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-phone text-green-500 mr-2"></i>
                                Kontak Penjual
                            </h4>
                            <a href="https://wa.me/${product.phone_number.replace(/[^0-9]/g, '')}?text=Halo, saya tertarik dengan produk ${product.name}" 
                               target="_blank"
                               class="block w-full py-3 px-4 bg-green-500 hover:bg-green-600 text-white text-center rounded-lg font-semibold transition">
                                <i class="fab fa-whatsapp mr-2"></i>
                                Chat via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Show modal with animation
        modal.classList.remove('hidden');
        const modalBox = document.getElementById('modalBox');
        
        // Reset position for animation
        modalBox.style.transform = 'translateY(-100px)';
        modalBox.style.opacity = '0';
        
        // Trigger slide down animation
        setTimeout(() => {
            modalBox.style.transform = 'translateY(0)';
            modalBox.style.opacity = '1';
        }, 10);
        
        document.body.style.overflow = 'hidden';
    }

    function closeProductModal() {
        const modal = document.getElementById('productModal');
        const modalBox = document.getElementById('modalBox');
        
        // Slide up animation before close
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
