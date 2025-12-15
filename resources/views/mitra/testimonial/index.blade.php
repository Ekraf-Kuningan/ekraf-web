@extends('layouts.mitra')

@section('title', 'Testimoni & Saran')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Testimoni & Saran</h1>
            <p class="text-gray-600">Bagikan pengalaman Anda bergabung dengan Ekraf Kuningan</p>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                <p class="font-medium">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Info Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Mengapa Testimoni Penting?</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Membantu calon pelaku EKRAF lain memahami manfaat bergabung</li>
                        <li>• Testimoni yang disetujui akan ditampilkan di halaman "Pelajari Manfaat"</li>
                        <li>• Saran Anda membantu kami meningkatkan layanan</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Status Badge -->
        @if($testimonial)
            <div class="mb-6">
                <div class="flex items-center justify-between bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div>
                        <span class="text-sm font-medium text-gray-700">Status Testimoni:</span>
                        @if($testimonial->status === 'approved')
                            <span class="ml-2 px-3 py-1 bg-green-100 text-green-700 text-sm font-semibold rounded-full">
                                <i class="fas fa-check-circle mr-1"></i>Disetujui
                            </span>
                        @elseif($testimonial->status === 'pending')
                            <span class="ml-2 px-3 py-1 bg-yellow-100 text-yellow-700 text-sm font-semibold rounded-full">
                                <i class="fas fa-clock mr-1"></i>Menunggu Persetujuan
                            </span>
                        @else
                            <span class="ml-2 px-3 py-1 bg-red-100 text-red-700 text-sm font-semibold rounded-full">
                                <i class="fas fa-times-circle mr-1"></i>Ditolak
                            </span>
                        @endif
                    </div>
                    @if($testimonial->status === 'approved')
                        <div class="text-sm text-gray-600">
                            <i class="fas fa-eye mr-1"></i>Ditampilkan di halaman publik
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
            <form action="{{ route('mitra.testimonial.store') }}" method="POST">
                @csrf

                <!-- Tipe -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-orange-300
                            {{ old('type', $testimonial->type ?? 'testimoni') === 'testimoni' ? 'border-orange-500 bg-orange-50' : 'border-gray-200' }}">
                            <input type="radio" name="type" value="testimoni" 
                                {{ old('type', $testimonial->type ?? 'testimoni') === 'testimoni' ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="text-center">
                                <i class="fas fa-star text-2xl mb-2 {{ old('type', $testimonial->type ?? 'testimoni') === 'testimoni' ? 'text-orange-500' : 'text-gray-400' }}"></i>
                                <div class="text-sm font-medium {{ old('type', $testimonial->type ?? 'testimoni') === 'testimoni' ? 'text-orange-700' : 'text-gray-600' }}">
                                    Testimoni
                                </div>
                            </div>
                        </label>

                        <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-orange-300
                            {{ old('type', $testimonial->type ?? '') === 'saran' ? 'border-orange-500 bg-orange-50' : 'border-gray-200' }}">
                            <input type="radio" name="type" value="saran" 
                                {{ old('type', $testimonial->type ?? '') === 'saran' ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="text-center">
                                <i class="fas fa-lightbulb text-2xl mb-2 {{ old('type', $testimonial->type ?? '') === 'saran' ? 'text-orange-500' : 'text-gray-400' }}"></i>
                                <div class="text-sm font-medium {{ old('type', $testimonial->type ?? '') === 'saran' ? 'text-orange-700' : 'text-gray-600' }}">
                                    Saran
                                </div>
                            </div>
                        </label>

                        <label class="relative flex items-center justify-center p-4 border-2 rounded-lg cursor-pointer transition-all hover:border-orange-300
                            {{ old('type', $testimonial->type ?? '') === 'masukan' ? 'border-orange-500 bg-orange-50' : 'border-gray-200' }}">
                            <input type="radio" name="type" value="masukan" 
                                {{ old('type', $testimonial->type ?? '') === 'masukan' ? 'checked' : '' }}
                                class="sr-only peer">
                            <div class="text-center">
                                <i class="fas fa-comment-dots text-2xl mb-2 {{ old('type', $testimonial->type ?? '') === 'masukan' ? 'text-orange-500' : 'text-gray-400' }}"></i>
                                <div class="text-sm font-medium {{ old('type', $testimonial->type ?? '') === 'masukan' ? 'text-orange-700' : 'text-gray-600' }}">
                                    Masukan
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Usaha -->
                <div class="mb-6">
                    <label for="business_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Usaha (Opsional)
                    </label>
                    <input type="text" id="business_name" name="business_name"
                        value="{{ old('business_name', $testimonial->business_name ?? '') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                        placeholder="Contoh: Kerajinan Bambu Makmur">
                    @error('business_name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Rating <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-2">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="{{ $i }}" 
                                    {{ old('rating', $testimonial->rating ?? 5) == $i ? 'checked' : '' }}
                                    class="sr-only peer" required>
                                <i class="fas fa-star text-3xl text-gray-300 peer-checked:text-yellow-500 hover:text-yellow-400 transition-colors"></i>
                            </label>
                        @endfor
                        <span class="ml-3 text-sm text-gray-600" id="rating-text">
                            {{ old('rating', $testimonial->rating ?? 5) }} dari 5 bintang
                        </span>
                    </div>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message -->
                <div class="mb-6">
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">
                        Pesan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="message" name="message" rows="6" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
                        placeholder="Ceritakan pengalaman Anda bergabung dengan EKRAF Kuningan..."
                    >{{ old('message', $testimonial->message ?? '') }}</textarea>
                    <div class="mt-2 flex justify-between items-center">
                        <p class="text-sm text-gray-500">
                            Minimal 10 karakter, maksimal 1000 karakter
                        </p>
                        <span class="text-sm text-gray-500" id="char-count">0 / 1000</span>
                    </div>
                    @error('message')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        {{ $testimonial ? 'Perbarui Testimoni' : 'Kirim Testimoni' }}
                    </button>

                    @if($testimonial)
                        <button type="button" onclick="confirmDelete()"
                            class="sm:w-auto bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
                            <i class="fas fa-trash mr-2"></i>
                            Hapus
                        </button>
                    @endif
                </div>
            </form>

            @if($testimonial)
                <form id="delete-form" action="{{ route('mitra.testimonial.destroy') }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endif
        </div>
    </div>
</div>

<script>
// Character counter
const messageTextarea = document.getElementById('message');
const charCount = document.getElementById('char-count');

if (messageTextarea) {
    function updateCharCount() {
        const count = messageTextarea.value.length;
        charCount.textContent = `${count} / 1000`;
        
        if (count > 1000) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    }
    
    messageTextarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Initial count
}

// Rating text update
const ratingInputs = document.querySelectorAll('input[name="rating"]');
const ratingText = document.getElementById('rating-text');

ratingInputs.forEach(input => {
    input.addEventListener('change', function() {
        ratingText.textContent = `${this.value} dari 5 bintang`;
    });
});

// Confirm delete
function confirmDelete() {
    if (confirm('Apakah Anda yakin ingin menghapus testimoni ini?')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endsection
