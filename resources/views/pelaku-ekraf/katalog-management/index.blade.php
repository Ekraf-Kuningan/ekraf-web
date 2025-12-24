@extends('layouts.pelaku-ekraf')

@section('title', 'Katalog Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
            <i class="fas fa-clipboard-list text-orange-500 mr-2"></i>
            Katalog Saya
        </h1>
        <p class="text-gray-600">Kelola katalog produk Anda</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Katalog Grid -->
    @if($katalogs->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($katalogs as $katalog)
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
            <!-- Image -->
            <div class="relative h-48 overflow-hidden bg-gray-100">
                <img src="{{ $katalog->image_url }}" 
                     alt="{{ $katalog->title }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                <div class="absolute top-3 right-3">
                    <span class="px-3 py-1 bg-orange-500 text-white text-xs font-semibold rounded-full shadow-lg">
                        {{ $katalog->subSektor->title }}
                    </span>
                </div>
            </div>

            <!-- Content -->
            <div class="p-5">
                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-orange-600 transition">
                    {{ $katalog->title }}
                </h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                    {{ strip_tags($katalog->content) }}
                </p>

                <!-- Stats -->
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-box mr-1.5"></i>
                        <span>{{ $katalog->products->count() }} Produk</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex gap-2">
                    <a href="{{ route('pelaku-ekraf.katalog-management.show', $katalog) }}" 
                       class="flex-1 py-2 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-lg text-center font-medium transition text-sm">
                        <i class="fas fa-eye mr-1"></i>Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $katalogs->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-16 bg-white rounded-2xl shadow-sm">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-orange-100 rounded-full mb-6">
            <i class="fas fa-clipboard-list text-4xl text-orange-500"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Katalog</h3>
        <p class="text-gray-600 mb-6 max-w-md mx-auto">
            Katalog Anda akan muncul di sini setelah ditambahkan oleh admin.
        </p>
    </div>
    @endif
</div>
@endsection
