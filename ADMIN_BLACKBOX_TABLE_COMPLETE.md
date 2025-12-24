# Tabel Lengkap Pengujian Black Box - Admin Panel

Berikut adalah hasil pengujian Black Box untuk **semua fitur** pengelolaan yang tersedia di halaman Admin. Tabel ini mencakup manajemen produk, konten, user, dan master data.

| No | Modul / Fitur | Fungsi yang Diuji | Cara Uji | Hasil yang Diharapkan | Tampilan |
|----|--------------|-------------------|----------|-----------------------|----------|
| **1** | **Manajemen Produk** | Verifikasi (Approve) | 1. Buka menu Produk<br>2. Filter status "Pending"<br>3. Klik tombol "Setujui" (Checklist) | Status produk menjadi "Approved", notifikasi sukses muncul, produk tampil di publik | Sesuai Harapan |
| 2 | | Verifikasi (Reject) | 1. Buka menu Produk<br>2. Filter status "Pending"<br>3. Klik tombol "Tolak" (Cross) | Status produk menjadi "Rejected", notifikasi sukses muncul | Sesuai Harapan |
| 3 | | Bulk Approve | 1. Pilih beberapa produk pending (checkbox)<br>2. Klik Bulk Action > "Setujui Terpilih" | Semua produk terpilih menjadi Approved sekaligus | Sesuai Harapan |
| 4 | | Edit Produk | 1. Klik tombol Edit pada produk<br>2. Ubah data (harga/deskripsi)<br>3. Simpan | Data produk berhasil diperbarui di database | Sesuai Harapan |
| **5** | **Manajemen Pelaku Ekraf** | Create Pelaku Ekraf | 1. Buka menu Pelaku Ekraf<br>2. Klik "New"<br>3. Isi data user & bisnis<br>4. Save | User berhasil didaftarkan sebagai Pelaku Ekraf baru | Sesuai Harapan |
| 6 | | Edit Pelaku Ekraf | 1. Pilih Pelaku Ekraf<br>2. Edit data bisnis (Nama/Sub Sektor)<br>3. Save | Perubahan data tersimpan | Sesuai Harapan |
| **7** | **Manajemen Katalog** | Create Katalog | 1. Buka menu Katalog<br>2. Klik "New"<br>3. Pilih Sub Sektor & Produk-produk terkait<br>4. Isi Deskripsi & Link Sosmed<br>5. Save | Katalog berhasil dibuat dan menggabungkan produk-produk yang dipilih | Sesuai Harapan |
| 8 | | Manage Katalog | 1. Buka menu Katalog<br>2. Edit katalog yang ada<br>3. Tambah/Hapus produk dari list | List produk dalam katalog terupdate | Sesuai Harapan |
| **9** | **Manajemen Artikel** | Create Artikel | 1. Buka menu Artikel<br>2. Isi Judul, Kategori, Konten, & Upload Thumbnail<br>3. Save | Artikel berhasil dipublish dan tampil di halaman berita | Sesuai Harapan |
| 10 | | Slug Otomatis | 1. Ketik Judul Artikel saat Create/Edit | Field Slug terisi otomatis sesuai judul (URL friendly) | Sesuai Harapan |
| 11 | | Featured Article | 1. Toggle "Featured" pada artikel | Artikel muncul di bagian highlight/featured | Sesuai Harapan |
| **12** | **Testimoni & Saran** | Moderasi Testimoni | 1. Buka menu Testimoni<br>2. Cek testimoni baru<br>3. Klik "Setujui" | Testimoni tampil di landing page | Sesuai Harapan |
| 13 | | Filter Jenis | 1. Filter tabel berdasarkan jenis "Saran" | Hanya menampilkan masukan internal, menyembunyikan testimoni publik | Sesuai Harapan |
| **14** | **Manajemen Banner** | Set Banner Homepage | 1. Buka menu Banner<br>2. Upload gambar & set status Active<br>3. Save | Banner muncul di slider halaman utama | Sesuai Harapan |
| **15** | **Master Data** | Sub Sektor | 1. Buka menu Sub Sektor<br>2. Tambah/Edit Sub Sektor (misal: "Kriya")<br>3. Upload Icon | Data master Sub Sektor terupdate untuk pilihan registrasi | Sesuai Harapan |
| 16 | | Business Category | 1. Buka menu Business Category<br>2. Tambah Kategori baru di bawah Sub Sektor tertentu | Kategori bisnis baru muncul saat user memilih Sub Sektor terkait | Sesuai Harapan |
| **17** | **Manajemen User** | Create Admin/User | 1. Buka menu User<br>2. Tambah user baru dengan email & password<br>3. Save | User berhasil dibuat dan bisa login sesuai role | Sesuai Harapan |
| **18** | **Keamanan** | Login Validasi | 1. Coba login dengan password salah | Akses ditolak dengan pesan error yang sesuai | Sesuai Harapan |
| 19 | | Akses URL Ilegal | 1. Logout<br>2. Akses URL admin deep link (`/admin/products`) | Redirect paksa ke halaman login | Sesuai Harapan |
