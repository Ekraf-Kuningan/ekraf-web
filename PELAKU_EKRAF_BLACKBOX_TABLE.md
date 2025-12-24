# Tabel Pengujian Black Box - Pelaku Ekraf

Berikut adalah hasil pengujian Black Box untuk fitur-fitur di sisi **Pelaku Ekraf**. Tabel ini mencakup alur registrasi, login, pengelolaan produk, hingga profil.

| No | Modul / Fitur | Fungsi yang Diuji | Cara Uji | Hasil yang Diharapkan | Tampilan |
|----|--------------|-------------------|----------|-----------------------|----------|
| **1** | **Registrasi** | Multi-step Register (Step 1) | 1. Buka halaman `/register-pelakuekraf` (Step 1)<br>2. Isi Nama, Email, Password<br>3. Submit | Data tersimpan sementara, sistem mengirim email verifikasi atau lanjut ke langkah berikutnya | Sesuai Harapan |
| 2 | | Complete Profile (Step 3) | 1. Akses link complete profile<br>2. Isi Nama Bisnis, Sub Sektor, dan Deskripsi<br>3. Submit | Registrasi selesai, user diarahkan ke dashboard atau halaman login | Sesuai Harapan |
| **2** | **Login** | Login Valid | 1. Buka halaman Login<br>2. Masukkan email & password pelaku ekraf<br>3. Klik Login | Login berhasil, redirect ke Dashboard Pelaku Ekraf | Sesuai Harapan |
| 3 | | Login Invalid | 1. Masukkan password salah | Muncul pesan error kredensial tidak cocok | Sesuai Harapan |
| **3** | **Dashboard** | View Dashboard | 1. Akses halaman `/pelaku-ekraf`<br>2. Cek widget statistik | Menampilkan ringkasan produk, views, dan status akun | Sesuai Harapan |
| **4** | **Manajemen Produk** | Create Produk Baru | 1. Buka menu Produk > Tambah Produk<br>2. Isi Nama, Harga, Stok, Deskripsi, Kategori<br>3. Upload Gambar<br>4. Simpan | Produk berhasil dibuat dengan status "Pending" (Menunggu Verifikasi Admin) | Sesuai Harapan |
| 5 | | Validasi Nama Produk Unik | 1. Input nama produk yang sudah ada di database sendiri/orang lain | Sistem menolak atau memberi peringatan bahwa nama produk sudah digunakan | Sesuai Harapan |
| 6 | | Edit Produk | 1. Buka list produk<br>2. Edit produk (ubah harga/stok)<br>3. Simpan | Data produk terupdate, status verifikasi mungkin reset ke Pending (tergantung rule) | Sesuai Harapan |
| 7 | | Hapus Produk | 1. Pilih produk<br>2. Klik Hapus<br>3. Konfirmasi | Produk terhapus dari sistem dan tidak tampil lagi | Sesuai Harapan |
| **5** | **Profil Usaha** | Update Profil | 1. Buka menu Profil<br>2. Ubah Nama Bisnis, Deskripsi, atau Sub Sektor<br>3. Update | Informasi profil usaha berhasil diperbarui | Sesuai Harapan |
| 8 | | Ganti Foto Profil | 1. Upload foto baru di halaman Profil<br>2. Update | Foto profil berubah | Sesuai Harapan |
| 9 | | Ganti Password | 1. Input password lama dan password baru<br>2. Simpan | Password berhasil diubah, login berikutnya menggunakan password baru | Sesuai Harapan |
| **6** | **Katalog & Browsing** | Browse Katalog | 1. Buka menu Katalog Produk<br>2. Lihat daftar produk user lain | Menampilkan produk-produk yang sudah Approved saja | Sesuai Harapan |
| 10 | | View Detail Produk | 1. Klik salah satu produk di katalog | Menampilkan detail lengkap produk | Sesuai Harapan |
| **7** | **Testimoni** | Submit Testimoni | 1. Buka menu Testimoni<br>2. Tulis pesan/kesan dan beri rating<br>3. Kirim | Testimoni terkirim dengan status "Pending" | Sesuai Harapan |
| 11 | | Hapus Testimoni | 1. Lihat riwayat testimoni sendiri<br>2. Klik Hapus | Testimoni berhasil ditarik/dihapus | Sesuai Harapan |
| **8** | **Keamanan** | Akses Menu Admin | 1. Coba akses URL `/admin` saat login sebagai Pelaku Ekraf | Akses ditolak (403 Forbidden atau Redirect ke Dashboard Pelaku Ekraf) | Sesuai Harapan |
