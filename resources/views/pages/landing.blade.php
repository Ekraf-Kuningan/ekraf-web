@extends('layouts.app')
@section('title', 'EKRAF KUNINGAN')
@section('content')
    <!-- Hero Section -->
    <div class="relative h-64 md:h-96 lg:h-[500px] bg-center bg-cover flex items-center"
        style="background-image: url('{{ asset('assets/img/BGKontak.png') }}');">
        <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0"></div>
        <div class="relative z-10 text-white text-center px-6 md:px-12 max-w-6xl mx-auto">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">EKRAF KUNINGAN</h1>
            <p class="text-lg md:text-xl lg:text-2xl mb-6 max-w-3xl mx-auto">
                Platform Ekonomi Kreatif Kabupaten Kuningan
            </p>
            <p class="text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
                Bergabunglah dengan komunitas kreatif Kuningan untuk mengembangkan potensi dan menciptakan peluang bisnis yang inovatif
            </p>
        </div>
    </div>

   
    <!-- Section Ekonomi Kreatif -->
    <section class="max-w-6xl mx-auto py-14 px-6 grid md:grid-cols-2 gap-8 items-start">
        <div>
            <h2 class="text-orange-500 font-bold text-xl mb-4">Ekonomi Kreatif (Ekraf)</h2>
            <p class="text-justify text-sm leading-relaxed text-gray-700 mb-4">
                Ekonomi Kreatif, atau yang sering disingkat sebagai Ekraf, merupakan sektor ekonomi yang bertumpu pada
                kreativitas individu, inovasi, dan pemanfaatan nilai budaya sebagai fondasi utama dalam menciptakan produk
                dan jasa. Dalam ekonomi ini, ide dan gagasan menjadi aset utama yang memiliki nilai jual tinggi, bahkan
                sering kali lebih penting dibandingkan sumber daya alam atau modal fisik.
            </p>
            <p class="text-justify text-sm leading-relaxed text-gray-700 mb-4">
                Ekonomi kreatif mencakup berbagai bidang, seperti seni rupa, desain, musik, film, periklanan, kuliner,
                fashion, arsitektur, hingga pengembangan aplikasi dan permainan digital. Sektor ini berkembang pesat seiring
                kemajuan teknologi dan meningkatnya kebutuhan masyarakat akan produk dan layanan yang unik, personal, serta
                sarat nilai estetika dan budaya.
            </p>
            <p class="text-justify text-sm leading-relaxed text-gray-700 mb-4">
                Salah satu ciri khas dari ekonomi kreatif adalah kemampuannya untuk terus berinovasi. Pelaku ekonomi kreatif
                tidak hanya menciptakan sesuatu yang baru, tetapi juga mengolah kembali unsur-unsur budaya lokal dan
                mengadaptasinya sesuai kebutuhan zaman. Oleh karena itu, ekonomi kreatif juga berperan penting dalam
                pelestarian budaya sekaligus peningkatan daya saing bangsa di era global.
            </p>
            <p class="text-justify text-sm leading-relaxed text-gray-700">
                Pemerintah Indonesia pun memberikan perhatian serius terhadap pengembangan sektor ini, karena dinilai mampu
                menjadi salah satu motor penggerak ekonomi nasional, membuka lapangan pekerjaan, serta meningkatkan
                kesejahteraan masyarakat.
            </p>
        </div>
        <div class="flex justify-center">
            <img src="{{ asset('assets/img/Lobby.png') }}" alt="Lobby"
                class="rounded-lg shadow-md w-[300px] object-cover">
        </div>
    </section>


    <!-- Section Produk -->
    <section class="py-14 border-t">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-2xl font-bold text-orange-500 mb-6">Produk</h2>

            <div class="flex flex-wrap justify-center items-center text-sm text-gray-700 mb-10 space-x-2">
                <a href="{{ route('katalog') }}" class="hover:text-orange-500">All</a>
                <span>|</span>
                @foreach ($subsektors as $key => $sub)
                    <a href="{{ route('katalog.subsektor', $sub->slug) }}"
                        class="hover:text-orange-500">{{ $sub->title }}</a>
                    @if (!$loop->last)
                        <span>|</span>
                    @endif
                @endforeach
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-8">
                @foreach ($katalogs as $kat)
                    <a href="{{ route('katalog.show', $kat->slug) }}" class="block transform hover:scale-105 transition duration-300">
                        <div class="bg-white rounded-xl shadow-md hover:shadow-lg border border-gray-100 overflow-hidden">
                            @if($kat->image && file_exists(public_path('storage/' . $kat->image)))
                                <img src="{{ asset('storage/' . $kat->image) }}" alt="{{ $kat->title }}"
                                    class="h-48 w-full object-cover">
                            @else
                                <div class="h-48 w-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    <div class="text-center text-gray-400">
                                        <i class="fas fa-image text-3xl mb-2"></i>
                                        <p class="text-sm">No Image</p>
                                    </div>
                                </div>
                            @endif
                            <div class="p-4 text-left">
                                <h3 class="text-base font-bold text-orange-600 mb-2 line-clamp-2">{{ $kat->title }}</h3>
                                <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                                    {{ Str::limit(strip_tags($kat->content), 80) ?: 'Koleksi produk kreatif dari pelaku UMKM lokal' }}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span class="inline-block px-3 py-1 text-xs bg-orange-100 text-orange-700 rounded-full font-medium">
                                        {{ $kat->subSektor->title ?? 'Sub Sektor' }}
                                    </span>
                                    @if($kat->products->count() > 0)
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-box text-[10px] mr-1"></i>
                                            {{ $kat->products->count() }} produk
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <button onclick="window.location.href='{{ route('katalog') }}'"
                class="px-6 py-2 bg-orange-500 text-xs text-white rounded hover:bg-orange-600 transition">
                Produk Lainnya
            </button>
        </div>
    </section>


    <!-- Section Manfaat -->
    <section class="max-w-6xl mx-auto py-14 px-6">
        <h2 class="text-center text-orange-500 font-semibold text-xl mb-12">Manfaat Menjadi Anggota ekraf Kuningan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10 text-gray-700">
            <div class="space-y-8">
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">1.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Sinergi dengan Pelaku Kreatif</h3>
                        <p class="text-sm leading-relaxed">Menjadi anggota forum ini membuka peluang untuk bekerja sama
                            dengan berbagai insan kreatif di Bandung Barat, sehingga memperkaya wawasan dan pengalaman Anda.
                        </p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">3.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Dukungan untuk Pertumbuhan Usaha</h3>
                        <p class="text-sm leading-relaxed">Forum ini menjadi sarana untuk memperkenalkan bisnis Anda kepada
                            audiens yang tepat, sekaligus memperoleh bimbingan dalam mengembangkan usaha lebih lanjut.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">5.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Komunitas yang Mendukung</h3>
                        <p class="text-sm leading-relaxed">Anda akan menjadi bagian dari komunitas yang saling membantu,
                            memberikan semangat saat menghadapi tantangan, dan ikut merayakan setiap pencapaian Anda.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">7.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Meningkatkan Citra dan Eksistensi Usaha</h3>
                        <p class="text-sm leading-relaxed">Dengan aktif terlibat dalam kegiatan forum dan berkolaborasi
                            dengan sesama anggota, Anda bisa memperkuat brand awareness dan eksistensi bisnis Anda.</p>
                    </div>
                </div>
            </div>
            <div class="space-y-8">
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">2.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Perluasan Relasi Profesional</h3>
                        <p class="text-sm leading-relaxed">Keanggotaan membantu Anda memperluas koneksi, menjalin hubungan
                            baru, dan membuka akses ke berbagai peluang usaha dan sumber daya.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">4.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Kesempatan Belajar dan Mengasah Skill</h3>
                        <p class="text-sm leading-relaxed">Nikmati berbagai program pelatihan, workshop, dan kegiatan
                            edukatif yang disediakan forum untuk meningkatkan keahlian di sektor ekonomi kreatif.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">6.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Informasi Terkini</h3>
                        <p class="text-sm leading-relaxed">Dapatkan update terbaru mengenai tren industri, peluang usaha,
                            serta event kreatif di kawasan Bandung Barat.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-4">
                    <span class="text-3xl font-bold">8.</span>
                    <div>
                        <h3 class="text-base font-semibold mb-2">Akses Fasilitas Pendukung Usaha</h3>
                        <p class="text-sm leading-relaxed">Sebagai anggota, Anda bisa mengakses fasilitas bersama seperti
                            ruang kerja, alat-alat kreatif, dan sumber daya lainnya yang mendukung efisiensi usaha Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
