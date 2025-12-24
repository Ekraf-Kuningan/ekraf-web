@extends('layouts.pelaku-ekraf')

@section('title', 'Daftar Produk')
@section('page_title', 'Produk Pelaku Ekraf')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <!-- Alert untuk Produk Ditolak -->
    @if($stats['rejected'] > 0)
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
            </div>
            <div class="ml-3 flex-1">
                <h3 class="text-sm font-bold text-red-800">
                    Anda memiliki {{ $stats['rejected'] }} produk yang ditolak
                </h3>
                <p class="text-sm text-red-700 mt-1">
                    Silakan cek alasan penolakan pada setiap produk dan lakukan perbaikan. Setelah diperbaiki, produk akan otomatis masuk ke tahap verifikasi ulang.
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Daftar Produk</h1>
        <p class="text-gray-600 mt-1">Kelola semua produk Anda di sini</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Produk</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Aktif</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['active'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-orange-600 mt-1">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['rejected'] }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('pelaku-ekraf.products') }}" class="space-y-4 md:space-y-0 md:flex md:items-end md:gap-4">
            
            <!-- Search -->
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Produk</label>
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari nama atau deskripsi produk..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Status Filter -->
            <div class="md:w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aktif</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Category Filter -->
            <div class="md:w-48">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort -->
            <div class="md:w-40">
                <label class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    <option value="uploaded_at" {{ request('sort') == 'uploaded_at' ? 'selected' : '' }}>Terbaru</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga</option>
                    <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stok</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('pelaku-ekraf.products') }}" class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-6 mb-6">
            @foreach($products as $product)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group cursor-pointer" onclick="openProductModal('{{ $product->id }}')">
                    <!-- Product Image -->
                    <div class="relative h-48 bg-gray-100 overflow-hidden">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><i class=\'fas fa-image text-gray-300 text-5xl\'></i></div>'">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-gray-300 text-5xl"></i>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            @if($product->status == 'approved')
                                <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full shadow-lg">
                                    Aktif
                                </span>
                            @elseif($product->status == 'pending')
                                <span class="px-3 py-1 bg-orange-500 text-white text-xs font-semibold rounded-full shadow-lg">
                                    Pending
                                </span>
                            @else
                                <span class="px-3 py-1 bg-red-500 text-white text-xs font-semibold rounded-full shadow-lg">
                                    Ditolak
                                </span>
                            @endif
                        </div>

                        <!-- Rejection Reason Badge (jika ada) -->
                        @if($product->status == 'rejected' && $product->rejection_reason)
                        <div class="absolute bottom-3 left-3 right-3">
                            <div class="bg-red-500 text-white text-xs p-2 rounded-lg shadow-lg">
                                <p class="font-semibold mb-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Alasan Penolakan:
                                </p>
                                <p class="line-clamp-2">{{ $product->rejection_reason }}</p>
                            </div>
                        </div>
                        @endif

                        <!-- Quick Actions -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-300 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100">
                            <button onclick="event.stopPropagation(); openProductModal('{{ $product->id }}')" 
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-green-600 hover:bg-green-600 hover:text-white transition"
                                    title="Detail Produk">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="event.stopPropagation(); window.location.href='{{ route('pelaku-ekraf.products.edit', $product) }}'" 
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-blue-600 hover:bg-blue-600 hover:text-white transition"
                                    title="Edit Produk">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="event.stopPropagation(); confirmDelete('{{ $product->id }}')" 
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-red-600 hover:bg-red-600 hover:text-white transition"
                                    title="Hapus Produk">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <!-- Category -->
                        <p class="text-xs text-orange-600 font-semibold mb-1">
                            {{ $product->subSektor->title ?? 'Tanpa Kategori' }}
                        </p>

                        <!-- Product Name -->
                        <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 min-h-[3rem]">
                            {{ $product->name }}
                        </h3>

                        <!-- Price & Stock -->
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-lg font-bold text-orange-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-box-open mr-1"></i>{{ $product->stock ?? 0 }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <button onclick="event.stopPropagation(); openProductModal('{{ $product->id }}')" 
                                    class="flex-1 py-2 bg-green-50 hover:bg-green-100 text-green-600 rounded-lg text-center font-medium transition text-sm">
                                <i class="fas fa-eye mr-1"></i>Detail
                            </button>
                            <button onclick="event.stopPropagation(); window.location.href='{{ route('pelaku-ekraf.products.edit', $product) }}'" 
                                    class="flex-1 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-center font-medium transition text-sm">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </button>
                            <button onclick="event.stopPropagation(); confirmDelete('{{ $product->id }}')" 
                                    class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg font-medium transition text-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Delete Form (Hidden) -->
                <form id="delete-form-{{ $product->id }}" 
                      action="{{ route('pelaku-ekraf.products.destroy', $product) }}" 
                      method="POST" 
                      class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-white rounded-xl shadow-sm p-4">
            {{ $products->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-box-open text-gray-400 text-5xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Produk</h3>
            <p class="text-gray-600 mb-6">
                @if(request()->has('search') || request()->has('status') || request()->has('category'))
                    Tidak ada produk yang sesuai dengan filter yang Anda pilih.
                @else
                    Mulai tambahkan produk pertama Anda sekarang!
                @endif
            </p>
            <div class="flex gap-3 justify-center">
                @if(request()->has('search') || request()->has('status') || request()->has('category'))
                    <a href="{{ route('pelaku-ekraf.products') }}" 
                       class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition">
                        <i class="fas fa-redo mr-2"></i>Reset Filter
                    </a>
                @endif
                <a href="{{ route('pelaku-ekraf.products.create') }}" 
                   class="px-6 py-3 bg-gradient-to-r from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-600 text-white rounded-lg font-medium shadow-lg transition">
                    <i class="fas fa-plus mr-2"></i>Tambah Produk
                </a>
            </div>
        </div>
    @endif

</div>

<!-- Modal Detail Produk -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" onclick="closeProductModal()">
    <div class="flex min-h-screen items-start justify-center p-4 pt-20">
        <div id="modalBox" class="bg-white rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden shadow-2xl transform transition-all duration-300" onclick="event.stopPropagation()">
            <!-- Modal Header (Sticky) -->
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between rounded-t-2xl z-20 shadow-sm">
                <h3 class="text-xl font-bold text-gray-900">Detail Produk</h3>
                <button onclick="closeProductModal()" class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center transition">
                    <i class="fas fa-times text-gray-600 text-xl"></i>
                </button>
            </div>

            <!-- Modal Body (Scrollable) -->
            <div id="modalContent" class="overflow-y-auto pb-20 md:pb-6" style="max-height: calc(90vh - 5rem);">
                <div class="p-6">
                    <!-- Content will be loaded dynamically -->
                    <div class="flex items-center justify-center py-12">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-orange-500"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Script -->
<script>
function confirmDelete(productId) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        document.getElementById('delete-form-' + productId).submit();
    }
}

// Product Modal Functions
const productsData = {!! json_encode($products->mapWithKeys(function($p) {
    return [$p->id => [
        'id' => $p->id,
        'name' => e($p->name),
        'description' => e($p->description ?? ''),
        'price' => $p->price,
        'stock' => $p->stock,
        'phone_number' => $p->user->phone_number ?? '-',
        'image' => $p->image_url,
        'status' => $p->status,
        'rejection_reason' => e($p->rejection_reason ?? ''),
        'category' => e(optional($p->subSektor)->title ?? 'Tanpa Kategori'),
        'business_category' => e(optional($p->businessCategory)->name ?? ''),
        'uploaded_at' => $p->uploaded_at ? $p->uploaded_at->format('d M Y, H:i') : null,
    ]];
}), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) !!};

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
                        Sub Sektor
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

                <!-- Rejection Reason (jika produk ditolak) -->
                ${product.status === 'rejected' && product.rejection_reason ? `
                <div class="p-4 bg-red-50 border-2 border-red-200 rounded-xl">
                    <h4 class="font-bold text-red-900 mb-2 flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                        Alasan Penolakan
                    </h4>
                    <p class="text-red-700 leading-relaxed">${product.rejection_reason}</p>
                    <div class="mt-3 p-3 bg-white rounded-lg border border-red-200">
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                            <strong>Saran:</strong> Silakan edit produk Anda sesuai dengan alasan penolakan di atas, lalu tunggu verifikasi ulang dari admin.
                        </p>
                    </div>
                </div>
                ` : ''}
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

@endsection
