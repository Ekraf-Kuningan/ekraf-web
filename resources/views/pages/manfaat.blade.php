@extends('layouts.app')

@section('title', 'Manfaat Bergabung - EKRAF Kuningan')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-orange-500 to-orange-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Manfaat Bergabung dengan EKRAF Kuningan</h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto">
                Daftarkan usaha kreatif Anda dan nikmati berbagai keuntungan untuk mengembangkan bisnis ke tingkat yang lebih tinggi
            </p>
        </div>
    </section>

    <!-- Manfaat Utama -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Harus Bergabung?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Dengan mendaftarkan produk Anda di Galeri EKRAF Kuningan, Anda akan mendapatkan akses ke berbagai fasilitas dan peluang pengembangan bisnis
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Manfaat 1 -->
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-store text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Promosi Produk Gratis</h3>
                    <p class="text-gray-700">
                        Produk Anda akan dipromosikan secara gratis melalui website resmi EKRAF Kuningan yang dikunjungi ribuan pengunjung setiap bulannya
                    </p>
                </div>

                <!-- Manfaat 2 -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Jangkauan Pasar Lebih Luas</h3>
                    <p class="text-gray-700">
                        Perluas jangkauan pasar Anda hingga ke seluruh Indonesia bahkan mancanegara melalui platform digital yang terintegrasi
                    </p>
                </div>

                <!-- Manfaat 3 -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-graduation-cap text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pelatihan & Workshop</h3>
                    <p class="text-gray-700">
                        Akses gratis ke berbagai pelatihan, workshop, dan seminar untuk meningkatkan kualitas produk dan keterampilan bisnis Anda
                    </p>
                </div>

                <!-- Manfaat 4 -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-handshake text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Networking & Kolaborasi</h3>
                    <p class="text-gray-700">
                        Kesempatan untuk berkolaborasi dengan pelaku Ekraf lainnya dan membangun jaringan bisnis yang lebih kuat
                    </p>
                </div>

                <!-- Manfaat 5 -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-trophy text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Akses ke Event & Pameran</h3>
                    <p class="text-gray-700">
                        Prioritas untuk mengikuti event, pameran, dan festival EKRAF baik di tingkat lokal maupun nasional
                    </p>
                </div>

                <!-- Manfaat 6 -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-certificate text-2xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Sertifikasi & Legalitas</h3>
                    <p class="text-gray-700">
                        Bantuan dalam mengurus legalitas usaha, sertifikasi produk, dan izin-izin yang diperlukan untuk pengembangan bisnis
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistik -->
    <section class="py-16 bg-gradient-to-r from-orange-500 to-orange-600 text-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">EKRAF Kuningan dalam Angka</h2>
                <p class="text-lg opacity-90">Bergabunglah dengan komunitas yang terus berkembang</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-5xl font-bold mb-2">500+</div>
                    <div class="text-lg opacity-90">Pelaku EKRAF Terdaftar</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">1000+</div>
                    <div class="text-lg opacity-90">Produk Kreatif</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">50+</div>
                    <div class="text-lg opacity-90">Event Tahunan</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">15+</div>
                    <div class="text-lg opacity-90">Sub Sektor EKRAF</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Mendaftar -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Mendaftar</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Proses pendaftaran mudah dan cepat, ikuti langkah-langkah berikut
                </p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
                        1
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Daftar Akun</h3>
                    <p class="text-gray-600 text-sm">
                        Klik tombol "Daftar Sekarang" dan isi formulir pendaftaran dengan data yang lengkap
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
                        2
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Verifikasi Email</h3>
                    <p class="text-gray-600 text-sm">
                        Cek email Anda dan klik link verifikasi yang kami kirimkan
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
                        3
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Lengkapi Profil</h3>
                    <p class="text-gray-600 text-sm">
                        Login dan lengkapi profil usaha Anda dengan informasi detail
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-3xl font-bold">
                        4
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Upload Produk</h3>
                    <p class="text-gray-600 text-sm">
                        Tambahkan produk kreatif Anda dan mulai promosikan ke ribuan pengunjung
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Kata Mereka</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Dengarkan pengalaman pelaku EKRAF yang telah bergabung dengan kami
                </p>
            </div>

            @if($testimonials->count() > 0)
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($testimonials as $testimonial)
                        <div class="bg-gray-50 rounded-xl p-6 shadow-md hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                @php
                                    $colors = ['orange', 'blue', 'green', 'purple', 'red', 'indigo'];
                                    $color = $colors[$loop->index % count($colors)];
                                    $initial = strtoupper(substr($testimonial->name, 0, 1));
                                @endphp
                                <div class="w-12 h-12 bg-{{ $color }}-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                    {{ $initial }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $testimonial->name }}</h4>
                                    @if($testimonial->business_name)
                                        <p class="text-sm text-gray-600">{{ $testimonial->business_name }}</p>
                                    @else
                                        <p class="text-sm text-gray-600">Pelaku Ekraf</p>
                                    @endif
                                </div>
                            </div>
                            <p class="text-gray-700 italic mb-4">
                                "{{ $testimonial->message }}"
                            </p>
                            <div class="flex text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Testimoni Default jika belum ada dari database -->
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Testimoni 1 -->
                    <div class="bg-gray-50 rounded-xl p-6 shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                A
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Ahmad Fauzi</h4>
                                <p class="text-sm text-gray-600">Kerajinan Kayu</p>
                            </div>
                        </div>
                        <p class="text-gray-700 italic">
                            "Sejak bergabung dengan EKRAF Kuningan, penjualan saya meningkat 3x lipat. Platform ini sangat membantu memperluas jangkauan pasar."
                        </p>
                        <div class="flex text-yellow-500 mt-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>

                    <!-- Testimoni 2 -->
                    <div class="bg-gray-50 rounded-xl p-6 shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                S
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Siti Nurhaliza</h4>
                                <p class="text-sm text-gray-600">Fashion & Batik</p>
                            </div>
                        </div>
                        <p class="text-gray-700 italic">
                            "Pelatihan dan workshop yang diberikan sangat bermanfaat. Saya jadi lebih paham cara memasarkan produk secara online."
                        </p>
                        <div class="flex text-yellow-500 mt-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>

                    <!-- Testimoni 3 -->
                    <div class="bg-gray-50 rounded-xl p-6 shadow-md">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white font-bold text-lg mr-3">
                                B
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">Budi Santoso</h4>
                                <p class="text-sm text-gray-600">Kuliner Tradisional</p>
                            </div>
                        </div>
                        <p class="text-gray-700 italic">
                            "Networking yang saya dapatkan dari komunitas EKRAF sangat membantu. Sekarang produk saya sudah dijual hingga ke luar kota."
                        </p>
                        <div class="flex text-yellow-500 mt-4">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            @endif

            @if($testimonials->count() > 0)
                <div class="text-center mt-8">
                    <p class="text-sm text-gray-500">
                        Menampilkan {{ $testimonials->count() }} testimoni terbaru dari {{ \App\Models\Testimonial::approved()->byType('testimoni')->count() }} total testimoni
                    </p>
                </div>
            @endif
        </div>
    </section>

   
@endsection
