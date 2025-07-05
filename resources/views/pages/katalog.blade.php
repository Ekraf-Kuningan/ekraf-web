@extends('layouts.app')
@section('title', 'EKRAF KUNINGAN')

@section('content')
    <div class="relative h-44 md:h-15 bg-center bg-cover flex items-center"
        style="background-image: url('{{ asset('assets/img/BGKontak.png') }}');">
        <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white text-left px-6 md:px-12">
            <p class="mt-2 text-base md:text-lg">
                <a href="/" class="hover:underline">Home</a> > Katalog
            </p>
            <h1 class="text-3xl md:text-5xl font-bold">KATALOG</h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <div class="flex space-x-2 mb-4 md:mb-0">
                <a href="{{ route('katalog') }}"
                    class="flex items-center px-4 py-1 border rounded-full text-sm hover:bg-orange-500 hover:text-white 
            {{ !request('sort') ? 'bg-orange-400 text-white' : 'bg-gray-100 text-gray-700' }}">
                    <i class="fas fa-list mr-2"></i> Semua
                </a>
                <a href="{{ route('katalog', ['sort' => 'terbaru', 'subsektor' => request('subsektor')]) }}"
                    class="flex items-center px-4 py-1 border rounded-full text-sm hover:bg-orange-500 hover:text-white 
                {{ request('sort') == 'terbaru' ? 'bg-orange-400 text-white' : 'bg-gray-100 text-gray-700' }}">
                    <i class="fas fa-clock mr-2"></i> Terbaru
                </a>
            </div>

            <form method="GET" class="flex items-center space-x-2">
                <select name="subsektor" onchange="this.form.submit()" class="border-gray-300 rounded px-4 py-2 text-sm">
                    <option value="">Pilih Sub Sektor</option>
                    @foreach ($subsektors as $sub)
                        <option value="{{ $sub->id }}" {{ request('subsektor') == $sub->id ? 'selected' : '' }}>
                            {{ $sub->title }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($katalogs as $katalog)
                <a href="{{ route('katalog.show', $katalog->slug) }}">
                    <div
                        class="bg-white rounded-xl overflow-hidden shadow hover:shadow-lg transition transform hover:scale-105 duration-300">
                        @if($katalog->image && file_exists(public_path('storage/' . $katalog->image)))
                            <img src="{{ asset('storage/' . $katalog->image) }}" alt="{{ $katalog->title }}"
                                class="w-full h-40 object-cover">
                        @else
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                <div class="text-center text-gray-400">
                                    <i class="fas fa-image text-2xl mb-1"></i>
                                    <p class="text-xs">No Image</p>
                                </div>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-base font-bold text-orange-600 mb-1">{{ $katalog->title }}</h3>
                            <p class="text-xs text-gray-600 mb-3">{{ Str::limit(strip_tags($katalog->content), 80) }}</p>
                            <span class="inline-block bg-gray-100 text-[10px] px-2 py-1 rounded-full">
                                {{ $katalog->subSektor->title ?? '-' }}
                            </span>
                        </div>
                    </div>
                </a>

            @empty
                <div class="col-span-3 text-center text-gray-500">Data katalog tidak ditemukan.</div>
            @endforelse
        </div>

        {{-- Info kecil --}}
        <div class="text-center text-xs text-gray-600 mt-6">
            Menampilkan {{ $katalogs->count() }} dari total {{ $katalogs->total() }} produk
        </div>

        {{-- Numbered pagination --}}
        <div class="mt-4 flex justify-center">
            {{ $katalogs->onEachSide(1)->links() }}
        </div>
    </div>
    {{-- Yuk beres  yuk--}}
@endsection
