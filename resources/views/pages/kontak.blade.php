@extends('layouts.app')
@section('title', 'KONTAK - EKRAF KUNINGAN')

@section('content')
    <!-- Banner -->
    <div class="relative h-44 md:h-15 bg-center bg-cover flex items-center"
        style="background-image: url('{{ asset('assets/img/BGKontak.png') }}');">
        <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white text-left px-6 md:px-12">
            <p class="mt-2 text-base md:text-lg">
                <a href="/" class="hover:underline">Home</a> > Kontak
            </p>
            <h1 class="text-3xl md:text-5xl font-bold">KONTAK</h1>
        </div>
    </div>


    <!-- Kontak -->
    <section class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-8">
            <div class="md:col-span-2 space-y-6">
                <h2 class="text-2xl font-bold text-gray-800">Hubungi Kami !</h2>
                <p class="text-gray-600">Ayo Kolaborasi Dengan Ekraf, Dukung UMKM Dan Wujudkan Ide Kreatif Bersama!</p>
                
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-xl"></i>
                            <p class="font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                            <p class="font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('kontak.send') }}" method="POST" class="space-y-4" id="contactForm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <input type="text" name="name" placeholder="Nama Anda*" value="{{ old('name') }}" required
                                class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input type="text" name="phone" placeholder="Nomor Telepon*" value="{{ old('phone') }}" required
                                class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input type="email" name="email" placeholder="Alamat Email*" value="{{ old('email') }}" required
                                class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input type="text" name="subject" placeholder="Judul*" value="{{ old('subject') }}" required
                                class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-500 @error('subject') border-red-500 @enderror">
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <textarea name="message" placeholder="Tuliskan Pesan*" rows="5" required
                            class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-orange-500 @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-1">Minimal 10 karakter, maksimal 2000 karakter</p>
                    </div>
                    <button type="submit" id="submitBtn"
                        class="bg-orange-500 text-white px-6 py-2 rounded hover:bg-orange-600 transition-colors duration-200 font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>KIRIM
                    </button>
                </form>
            </div>

            <div>
                <h3 class="text-xl font-bold text-orange-500 mb-4">Get in Touch</h3>
                <div class="space-y-4 text-gray-600 text-sm">
                    <div>
                        <h4 class="font-semibold">HUBUNGI KAMI :</h4>
                        <p>(0232) 8730550</p>
                    </div>
                    <div>
                        <h4 class="font-semibold">INSTAGRAM :</h4>
                        <p>@ekrafkuningan.id</p>
                    </div>
                    <div>
                        <h4 class="font-semibold">JAM LAYANAN :</h4>
                        <p>Senin - Jumat 08.00 - 16.00 WIB</p>
                    </div>
                    <div>
                        <h4 class="font-semibold">ALAMAT :</h4>
                        <p>Jl. Siliwangi No. 88, Kuningan, Jawa Barat</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Maps -->
    <section class="w-full">
        <iframe src="https://www.google.com/maps?q=2F9H%2BC7+Kuningan,+Kabupaten+Kuningan,+Jawa+Barat&output=embed"
            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>

    </section>

    <script>
        // Loading state for form submission
        const contactForm = document.getElementById('contactForm');
        const submitBtn = document.getElementById('submitBtn');

        if (contactForm) {
            contactForm.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>MENGIRIM...';
            });
        }

        // Auto hide success/error message after 5 seconds
        @if(session('success') || session('error'))
            setTimeout(function() {
                const alerts = document.querySelectorAll('[role="alert"]');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        @endif
    </script>
@endsection
