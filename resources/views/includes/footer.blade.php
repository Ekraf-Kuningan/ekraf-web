<!-- Section CTA dengan background image + overlay -->
<section class="relative bg-center bg-cover"
    style="background-image: url('{{ asset('assets/img/BackgroundFooter.png') }}')">
    <div class="max-w-4xl mx-auto text-center py-20 text-white px-4">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Bergabunglah dengan Galeri EKRAF Kuningan</h2>
        <p class="mb-6 text-sm md:text-base">Daftarkan usaha kreatif Anda dan dapatkan berbagai manfaat untuk
            mengembangkan bisnis anda ke tingkat yang lebih tinggi</p>
        <div class="flex justify-center gap-4 flex-wrap mb-8">
            <a href="{{ route('register-pelakuekraf') }}"
                class="bg-white text-[#1E293B] font-semibold px-6 py-3 rounded hover:bg-gray-200 flex items-center gap-2">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </a>
            <a href="{{ route('manfaat') }}"
                class="border border-white px-6 py-3 rounded hover:bg-white hover:text-[#1E293B] flex items-center gap-2">
                <i class="fas fa-info-circle"></i> Pelajari Manfaat
            </a>
        </div>
        <div>
            <h3 class="text-sm md:text-base font-semibold mb-4">Berikan Testimoni, Saran, atau Masukan Anda</h3>
            <form id="testimonialForm" class="max-w-2xl mx-auto">
                @csrf
                <div class="grid md:grid-cols-2 gap-3 mb-3">
                    <input type="text" name="name" placeholder="Nama Anda" required
                        class="px-4 py-2 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <input type="email" name="email" placeholder="Email Anda" required
                        class="px-4 py-2 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>
                <div class="grid md:grid-cols-2 gap-3 mb-3">
                    <select name="type" id="testimonialType" required
                        class="px-4 py-2 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">Pilih Jenis</option>
                        <option value="testimoni">Testimoni</option>
                        <option value="saran">Saran/Masukan</option>
                    </select>
                    <div id="ratingSection" class="flex items-center justify-center bg-white rounded px-4 py-2">
                        <span class="text-gray-700 mr-2">Rating:</span>
                        <div class="flex gap-1" id="ratingStars">
                            <i class="fas fa-star text-2xl cursor-pointer text-gray-300 hover:text-yellow-500" data-rating="1"></i>
                            <i class="fas fa-star text-2xl cursor-pointer text-gray-300 hover:text-yellow-500" data-rating="2"></i>
                            <i class="fas fa-star text-2xl cursor-pointer text-gray-300 hover:text-yellow-500" data-rating="3"></i>
                            <i class="fas fa-star text-2xl cursor-pointer text-gray-300 hover:text-yellow-500" data-rating="4"></i>
                            <i class="fas fa-star text-2xl cursor-pointer text-gray-300 hover:text-yellow-500" data-rating="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="ratingInput" value="5">
                    </div>
                </div>
                <textarea name="message" placeholder="Tulis pesan Anda..." required rows="3"
                    class="w-full px-4 py-2 rounded bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-orange-500 mb-3"></textarea>
                <button type="submit" class="w-full md:w-auto px-6 py-2 bg-white text-[#1E293B] rounded hover:bg-gray-200 font-semibold">
                    <i class="fas fa-paper-plane mr-2"></i>Kirim
                </button>
                <div id="testimonialMessage" class="mt-3 hidden"></div>
            </form>
        </div>
    </div>
</section>

<script>
    // Rating stars functionality
    const stars = document.querySelectorAll('#ratingStars i');
    const ratingInput = document.getElementById('ratingInput');
    const ratingSection = document.getElementById('ratingSection');
    const testimonialType = document.getElementById('testimonialType');
    let currentRating = 5; // Default 5 stars

    // Toggle rating section based on type
    testimonialType.addEventListener('change', function() {
        if (this.value === 'testimoni') {
            ratingSection.style.display = 'flex';
            ratingInput.setAttribute('required', 'required');
        } else {
            ratingSection.style.display = 'none';
            ratingInput.removeAttribute('required');
        }
    });

    // Hide rating section initially (until testimoni is selected)
    ratingSection.style.display = 'none';

    // Set initial state (5 stars)
    stars.forEach((star, index) => {
        if (index < 5) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-500');
        }
    });

    stars.forEach(star => {
        star.addEventListener('click', function() {
            currentRating = parseInt(this.dataset.rating);
            ratingInput.value = currentRating;
            
            // Update star colors
            stars.forEach((s, index) => {
                if (index < currentRating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-500');
                } else {
                    s.classList.remove('text-yellow-500');
                    s.classList.add('text-gray-300');
                }
            });
        });

        star.addEventListener('mouseenter', function() {
            const hoverRating = parseInt(this.dataset.rating);
            stars.forEach((s, index) => {
                if (index < hoverRating) {
                    s.classList.add('text-yellow-400');
                }
            });
        });

        star.addEventListener('mouseleave', function() {
            stars.forEach(s => {
                s.classList.remove('text-yellow-400');
            });
        });
    });

    // Form submission
    document.getElementById('testimonialForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const messageDiv = document.getElementById('testimonialMessage');
        const submitBtn = this.querySelector('button[type="submit"]');
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
        
        try {
            const response = await fetch('{{ route("testimonial.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                messageDiv.className = 'mt-3 p-4 bg-green-100 text-green-800 rounded';
                messageDiv.textContent = data.message;
                messageDiv.classList.remove('hidden');
                this.reset();
                
                // Reset stars to 5
                currentRating = 5;
                ratingInput.value = 5;
                stars.forEach((s, index) => {
                    if (index < 5) {
                        s.classList.remove('text-gray-300');
                        s.classList.add('text-yellow-500');
                    }
                });
                
                setTimeout(() => {
                    messageDiv.classList.add('hidden');
                }, 5000);
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        } catch (error) {
            messageDiv.className = 'mt-3 p-4 bg-red-100 text-red-800 rounded';
            messageDiv.textContent = 'Terjadi kesalahan: ' + error.message;
            messageDiv.classList.remove('hidden');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Kirim';
        }
    });
</script>


<!-- Footer navy polos -->
<footer class="bg-[#1E293B] text-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 px-6 py-12">
        <div class="space-y-4">
            <img src="{{ asset('assets/img/LogoEkrafPutih.png') }}" alt="Logo" class="h-12">
            <p class="text-sm text-gray-400">
                Mendorong pertumbuhan ekonomi kreatif Kuningan melalui inovasi dan pelestarian budaya lokal.
            </p>
            <div class="flex space-x-4 mt-4 text-xl">
                <a href="#" class="hover:text-orange-400"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com/kuningankreatifgaleri/" class="hover:text-orange-400"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-orange-400"><i class="fab fa-twitter"></i></a>
                <a href="#" class="hover:text-orange-400"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div>
            <h3 class="font-bold mb-4">Tautan Cepat</h3>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li><a href="/" class="hover:text-white">Beranda</a></li>
                <li><a href="/katalog" class="hover:text-white">Katalog Produk</a></li>
                <li><a href="/berita" class="hover:text-white">Artikel & Berita</a></li>
                <li><a href="/tentang" class="hover:text-white">Tentang Kami</a></li>
                <li><a href="/kontak" class="hover:text-white">Kontak</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold mb-4">Layanan</h3>
            <ul class="space-y-2 text-gray-400 text-sm">
                <li><a href="/register-pelakuekraf" class="hover:text-white">Pendaftaran EKRAF</a></li>
                <li><a href="#" class="hover:text-white">Pelatihan & Workshop</a></li>
                <li><a href="#" class="hover:text-white">Konsultasi Bisnis</a></li>
                <li><a href="#" class="hover:text-white">Akses Pendanaan</a></li>
                <li><a href="#" class="hover:text-white">Promosi Produk</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-bold mb-4">Kontak Kami</h3>
            <p class="text-gray-400 text-sm">Jl. Siliwangi No. 88, Kuningan, Jawa Barat 45511</p>
            <p class="text-gray-400 text-sm mt-2">(0232) 8730550</p>
            <p class="text-gray-400 text-sm mt-2">info@ekrafkuningan.id</p>
            <p class="text-gray-400 text-sm mt-2">Senin - Jumat 08.00 - 16.00 WIB</p>
        </div>
    </div>
    <div class="border-t border-gray-700 text-center py-4 text-gray-500 text-sm">
        © 2025 KUNINGAN KREATIF GALERI. All rights reserved by Kelompok 60.
    </div>
</footer>
