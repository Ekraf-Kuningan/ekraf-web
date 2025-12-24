# Tabel Pengujian Black Box - Admin Panel

Berikut adalah hasil pengujian Black Box untuk halaman Admin dalam format tabel. Anda dapat menyalin tabel ini langsung ke Microsoft Word.

| No | Fungsi | Cara Uji | Hasil yang Diharapkan | Tampilan |
|----|--------|----------|-----------------------|----------|
| 1  | Pengujian Login Admin (Valid) | 1. Buka halaman login admin<br>2. Masukkan email `admin@ekraf.com` dan password valid<br>3. Klik tombol Login | Sistem mengarahkan user ke halaman Dashboard Admin dan menampilkan nama admin | Sesuai Harapan |
| 2  | Pengujian Login Admin (Invalid) | 1. Buka halaman login admin<br>2. Masukkan password yang salah<br>3. Klik tombol Login | Sistem menampilkan pesan error "Amnesia? Credential mismatch" dan menolak akses | Sesuai Harapan |
| 3  | Pengujian Dashboard Admin | 1. Login sebagai admin<br>2. Akses menu Dashboard | Menampilkan widget statistik (Total Produk, Pelaku Ekraf) dan grafik kinerja | Sesuai Harapan |
| 4  | Verifikasi Produk (Approve) | 1. Buka menu Produk<br>2. Pilih produk dengan status "Pending"<br>3. Klik tombol "Setujui" (Checklist) | Status produk berubah menjadi "Approved" dan produk muncul di katalog publik | Sesuai Harapan |
| 5  | Verifikasi Produk (Reject) | 1. Buka menu Produk<br>2. Pilih produk dengan status "Pending"<br>3. Klik tombol "Tolak" (Cross) | Status produk berubah menjadi "Rejected" dan produk tidak muncul di publik | Sesuai Harapan |
| 6  | Bulk Action Produk | 1. Pilih beberapa produk pending<br>2. Pilih Bulk Action "Setujui Terpilih" | Semua produk yang dipilih berubah status menjadi "Approved" secara bersamaan | Sesuai Harapan |
| 7  | Manajemen Pelaku Ekraf | 1. Buka menu Pelaku Ekraf<br>2. Edit salah satu data pelaku ekraf<br>3. Simpan perubahan | Data pelaku ekraf berhasil diperbarui di database | Sesuai Harapan |
| 8  | Moderasi Testimoni | 1. Buka menu Testimoni<br>2. Cari testimoni baru<br>3. Klik "Setujui" | Testimoni berubah status menjadi Approved dan tampil di Landing Page | Sesuai Harapan |
| 9  | Filter Testimoni vs Saran | 1. Buka menu Testimoni<br>2. Filter berdasarkan jenis "Saran" | Hanya menampilkan data saran internal, tidak mencampur dengan testimoni publik | Sesuai Harapan |
| 10 | Manajemen User (Create) | 1. Buka menu User<br>2. Tambah user baru dengan role Pelaku Ekraf<br>3. Simpan | User baru berhasil dibuat dan dapat digunakan untuk login | Sesuai Harapan |
| 11 | Manajemen Banner | 1. Buka menu Banner<br>2. Upload gambar banner baru<br>3. Set status Active | Banner baru tampil di slider halaman utama website | Sesuai Harapan |
| 12 | Validasi Keamanan Akses | 1. Logout dari admin<br>2. Coba akses URL `/admin/products` langsung | Sistem menolak akses dan mengarahkan kembali ke halaman Login | Sesuai Harapan |
