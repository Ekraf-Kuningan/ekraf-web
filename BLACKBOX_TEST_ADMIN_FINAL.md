# Black Box Testing - Admin Panel

**Tanggal Testing**: 21 Desember 2025  
**Tester**: [Nama Tester]  
**Versi Aplikasi**: 1.0  
**URL Admin**: `/admin`

---

## 1. Login Admin

### Test Case 1.1: Login Admin dengan Kredensial Valid
| ID | TC-ADM-LOGIN-001 |
|----|------------------|
| **Deskripsi** | Admin login dengan email dan password yang benar |
| **Pre-kondisi** | User sudah terdaftar sebagai admin di database |
| **Test Steps** | 1. Buka halaman `/admin/login`<br>2. Isi email dan password admin<br>3. Klik tombol "Sign in" |
| **Input Data** | - Email: `admin@ekraf.com`<br>- Password: `password` |
| **Expected Result** | ✅ Login berhasil<br>✅ Redirect ke Dashboard Admin (`/admin`)<br>✅ Nama admin tampil di pojok kanan atas |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 1.2: Login dengan Password Salah
| ID | TC-ADM-LOGIN-002 |
|----|------------------|
| **Deskripsi** | Admin login dengan password yang salah |
| **Pre-kondisi** | - |
| **Test Steps** | 1. Buka halaman `/admin/login`<br>2. Isi email benar, password salah<br>3. Klik tombol "Sign in" |
| **Input Data** | - Email: `admin@ekraf.com`<br>- Password: `wrongpassword` |
| **Expected Result** | ❌ Login gagal<br>✅ Muncul pesan error: "These credentials do not match our records."<br>✅ User tetap di halaman login |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 2. Dashboard Admin

### Test Case 2.1: Akses Dashboard
| ID | TC-ADM-DASH-001 |
|----|-----------------|
| **Deskripsi** | Admin mengakses dashboard setelah login |
| **Pre-kondisi** | User sudah login sebagai admin |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Dashboard" |
| **Input Data** | - |
| **Expected Result** | ✅ Dashboard tampil<br>✅ Menampilkan widget statistik (Total Produk, Pelaku Ekraf, dll)<br>✅ Menu navigasi sidebar tampil lengkap |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 3. Verifikasi Produk

### Test Case 3.1: Lihat Daftar Produk Pending
| ID | TC-ADM-PROD-001 |
|----|-----------------|
| **Deskripsi** | Admin melihat daftar produk yang menunggu verifikasi |
| **Pre-kondisi** | Ada produk dengan status "pending" di database |
| **Test Steps** | 1. Akses menu "Produk"<br>2. Cek tabel produk |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar produk<br>✅ Kolom status menunjukkan badge "Menunggu" (warna kuning)<br>✅ Bisa difilter berdasarkan status "Menunggu" |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 3.2: Approve Produk (Setujui)
| ID | TC-ADM-PROD-002 |
|----|-----------------|
| **Deskripsi** | Admin menyetujui produk yang statusnya pending |
| **Pre-kondisi** | Ada produk dengan status "pending" |
| **Test Steps** | 1. Akses menu "Produk"<br>2. Klik tombol action "Setujui" (icon checklist) pada baris produk<br>3. Konfirmasi di modal dialog "Ya, Setujui" |
| **Input Data** | - |
| **Expected Result** | ✅ Status produk berubah menjadi "approved" (Disetujui)<br>✅ Muncul notifikasi sukses "Produk Disetujui"<br>✅ Produk muncul di katalog publik |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 3.3: Reject Produk (Tolak)
| ID | TC-ADM-PROD-003 |
|----|-----------------|
| **Deskripsi** | Admin menolak produk |
| **Pre-kondisi** | Ada produk dengan status "pending" |
| **Test Steps** | 1. Akses menu "Produk"<br>2. Klik tombol action "Tolak" (icon silang) pada baris produk<br>3. Konfirmasi di modal dialog "Ya, Tolak" |
| **Input Data** | - |
| **Expected Result** | ✅ Status produk berubah menjadi "rejected" (Ditolak)<br>✅ Muncul notifikasi "Produk Ditolak"<br>✅ Produk tidak muncul di katalog publik |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 3.4: Bulk Approve Produk
| ID | TC-ADM-PROD-004 |
|----|-----------------|
| **Deskripsi** | Admin menyetujui beberapa produk sekaligus |
| **Pre-kondisi** | Ada minimal 2 produk pending |
| **Test Steps** | 1. Centang checkbox pada beberapa produk pending<br>2. Klik tombol "Bulk Actions" (di header tabel)<br>3. Pilih "Setujui Terpilih"<br>4. Konfirmasi |
| **Input Data** | - |
| **Expected Result** | ✅ Semua produk yang dipilih berubah status menjadi "approved"<br>✅ Muncul notifikasi sukses dengan jumlah produk yang disetujui |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 4. Manajemen Pelaku Ekraf

### Test Case 4.1: Lihat Daftar Pelaku Ekraf
| ID | TC-ADM-PE-001 |
|----|---------------|
| **Deskripsi** | Admin melihat daftar pelaku ekraf yang terdaftar |
| **Pre-kondisi** | Ada data pelaku ekraf |
| **Test Steps** | 1. Akses menu "Pelaku Ekraf"<br>2. Cek data tabel |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar pelaku ekraf<br>✅ Menampilkan nama bisnis, sub sektor, dan pemilik |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.2: Edit Pelaku Ekraf
| ID | TC-ADM-PE-002 |
|----|---------------|
| **Deskripsi** | Admin mengedit data pelaku ekraf |
| **Pre-kondisi** | Pelaku Ekraf ada |
| **Test Steps** | 1. Akses menu "Pelaku Ekraf"<br>2. Klik tombol "Edit" pada salah satu data<br>3. Ubah data (misal: Nama Bisnis)<br>4. Klik "Save changes" |
| **Input Data** | - Business Name: `Update Nama Bisnis` |
| **Expected Result** | ✅ Data berhasil disimpan<br>✅ Muncul notifikasi sukses |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 5. Manajemen Testimoni & Saran

### Test Case 5.1: Moderasi Testimoni
| ID | TC-ADM-TESTI-001 |
|----|------------------|
| **Deskripsi** | Admin menyetujui testimoni pengguna |
| **Pre-kondisi** | Ada testimoni baru dengan status Pending |
| **Test Steps** | 1. Akses menu "Testimoni & Saran"<br>2. Cari testimoni dengan status Pending<br>3. Klik action "Setujui" |
| **Input Data** | - |
| **Expected Result** | ✅ Status berubah jadi "Disetujui"<br>✅ Testimoni tampil di landing page |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 5.2: Filter Jenis Testimoni/Saran
| ID | TC-ADM-TESTI-002 |
|----|------------------|
| **Deskripsi** | Admin memfilter tampilan berdasarkan jenis (Testimoni atau Saran) |
| **Pre-kondisi** | Ada data tipe Testimoni dan Saran |
| **Test Steps** | 1. Akses menu "Testimoni & Saran"<br>2. Klik Filter icon<br>3. Pilih Jenis: "Saran/Masukan" |
| **Input Data** | - Jenis: `Saran/Masukan` |
| **Expected Result** | ✅ Tabel hanya menampilkan data Saran/Masukan<br>✅ Data Testimoni disembunyikan |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 6. Manajemen User

### Test Case 6.1: Create User Baru
| ID | TC-ADM-USR-001 |
|----|----------------|
| **Deskripsi** | Admin membuat user baru secara manual |
| **Pre-kondisi** | - |
| **Test Steps** | 1. Akses menu "Users"<br>2. Klik "New User"<br>3. Isi Nama, Email, Password, dan Role<br>4. Klik "Create" |
| **Input Data** | - Name: `User Test`<br>- Email: `test@user.com`<br>- Password: `password`<br>- Role: `Pelaku Ekraf` |
| **Expected Result** | ✅ User berhasil dibuat<br>✅ User bisa login dengan kredensial tersebut |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 7. Security & Access Control

### Test Case 7.1: Akses Resource Tanpa Login
| ID | TC-ADM-SEC-001 |
|----|----------------|
| **Deskripsi** | Mencoba akses URL admin tanpa login |
| **Pre-kondisi** | Logout dari admin |
| **Test Steps** | 1. Akses langsung URL `/admin/products` di browser |
| **Input Data** | - |
| **Expected Result** | ❌ Akses ditolak<br>✅ Redirect ke halaman login admin (`/admin/login`) |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## Ringkasan Hasil Testing

| Kategori | Total Test Case | Pass | Fail | Pass Rate |
|----------|-----------------|------|------|-----------|
| Login | 2 | - | - | - |
| Dashboard | 1 | - | - | - |
| Verifikasi Produk | 4 | - | - | - |
| Manajemen Pelaku Ekraf | 2 | - | - | - |
| Testimoni | 2 | - | - | - |
| User | 1 | - | - | - |
| Security | 1 | - | - | - |
| **TOTAL** | **13** | **-** | **-** | **-%** |

---

## Catatan Tambahan
- Test case disusun berdasarkan fitur yang tersedia di `ProductResource`, `TestimonialResource`, dll.
- Fitur Approve/Reject produk tidak memerlukan input alasan (reason), hanya konfirmasi.
