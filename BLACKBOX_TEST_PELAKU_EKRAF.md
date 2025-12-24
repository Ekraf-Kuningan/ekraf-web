# Black Box Testing - Pelaku Ekraf

**Tanggal Testing**: 21 Desember 2025  
**Tester**: [Nama Tester]  
**Versi Aplikasi**: 1.0

---

## 1. Registrasi Pelaku Ekraf

### Test Case 1.1: Registrasi dengan Data Valid
| ID | TC-PE-REG-001 |
|----|---------------|
| **Deskripsi** | User melakukan registrasi dengan data yang valid |
| **Pre-kondisi** | User belum terdaftar |
| **Test Steps** | 1. Buka halaman `/register`<br>2. Pilih role "Pelaku Ekraf"<br>3. Isi form: nama, email, password, business_name, sub_sektor, deskripsi<br>4. Klik tombol "Daftar" |
| **Input Data** | - Email: `pelaku1@test.com`<br>- Password: `Password123!`<br>- Business Name: `Kerajinan Tangan Jaya`<br>- Sub Sektor: (pilih salah satu)<br>- Deskripsi: `Usaha kerajinan tangan lokal` |
| **Expected Result** | ✅ Registrasi berhasil<br>✅ Redirect ke dashboard pelaku ekraf<br>✅ Data tersimpan di database |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |
| **Screenshot** | _(Lampirkan screenshot)_ |

### Test Case 1.2: Registrasi dengan Email Duplikat
| ID | TC-PE-REG-002 |
|----|---------------|
| **Deskripsi** | User mencoba registrasi dengan email yang sudah terdaftar |
| **Pre-kondisi** | Email `pelaku1@test.com` sudah terdaftar |
| **Test Steps** | 1. Buka halaman `/register`<br>2. Pilih role "Pelaku Ekraf"<br>3. Isi form dengan email yang sama<br>4. Klik tombol "Daftar" |
| **Input Data** | - Email: `pelaku1@test.com` (duplikat)<br>- Data lainnya valid |
| **Expected Result** | ❌ Registrasi gagal<br>✅ Muncul error message: "Email sudah terdaftar"<br>✅ User tetap di halaman register |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 1.3: Registrasi dengan Data Invalid
| ID | TC-PE-REG-003 |
|----|---------------|
| **Deskripsi** | User mencoba registrasi dengan data tidak lengkap/invalid |
| **Pre-kondisi** | - |
| **Test Steps** | 1. Buka halaman `/register`<br>2. Kosongkan field mandatory<br>3. Klik tombol "Daftar" |
| **Input Data** | - Email: _(kosong)_<br>- Password: `123` (terlalu pendek)<br>- Business Name: _(kosong)_ |
| **Expected Result** | ❌ Registrasi gagal<br>✅ Muncul validation error untuk setiap field<br>✅ Form tidak tersubmit |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 2. Login Pelaku Ekraf

### Test Case 2.1: Login dengan Kredensial Valid
| ID | TC-PE-LOGIN-001 |
|----|-----------------|
| **Deskripsi** | User login dengan email dan password yang benar |
| **Pre-kondisi** | User sudah terdaftar sebagai pelaku ekraf |
| **Test Steps** | 1. Buka halaman `/login`<br>2. Isi email dan password<br>3. Klik tombol "Login" |
| **Input Data** | - Email: `pelaku1@test.com`<br>- Password: `Password123!` |
| **Expected Result** | ✅ Login berhasil<br>✅ Redirect ke `/pelaku-ekraf` (dashboard)<br>✅ Session tersimpan |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 2.2: Login dengan Password Salah
| ID | TC-PE-LOGIN-002 |
|----|-----------------|
| **Deskripsi** | User login dengan password yang salah |
| **Pre-kondisi** | User sudah terdaftar |
| **Test Steps** | 1. Buka halaman `/login`<br>2. Isi email benar, password salah<br>3. Klik tombol "Login" |
| **Input Data** | - Email: `pelaku1@test.com`<br>- Password: `WrongPassword123!` |
| **Expected Result** | ❌ Login gagal<br>✅ Muncul error: "Kredensial tidak valid"<br>✅ User tetap di halaman login |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 3. Dashboard Pelaku Ekraf

### Test Case 3.1: Akses Dashboard
| ID | TC-PE-DASH-001 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf mengakses dashboard setelah login |
| **Pre-kondisi** | User sudah login sebagai pelaku ekraf |
| **Test Steps** | 1. Login sebagai pelaku ekraf<br>2. Akses URL `/pelaku-ekraf` |
| **Input Data** | - |
| **Expected Result** | ✅ Dashboard tampil<br>✅ Menampilkan statistik: jumlah produk, views katalog, dll<br>✅ Menu navigasi tampil |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 4. Manajemen Produk (CRUD)

### Test Case 4.1: Tambah Produk dengan Data Valid
| ID | TC-PE-PROD-001 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf menambahkan produk baru dengan data lengkap |
| **Pre-kondisi** | User sudah login sebagai pelaku ekraf |
| **Test Steps** | 1. Akses `/pelaku-ekraf/products/create`<br>2. Isi semua field yang required<br>3. Upload gambar produk (JPG/PNG, max 2MB)<br>4. Klik tombol "Simpan" |
| **Input Data** | - Nama Produk: `Tas Rajut Handmade`<br>- Kategori: `Kerajinan Tangan`<br>- Harga: `150000`<br>- Deskripsi: `Tas rajut berkualitas`<br>- Gambar: (file valid) |
| **Expected Result** | ✅ Produk berhasil dibuat<br>✅ Gambar ter-upload ke Cloudinary<br>✅ Redirect ke halaman daftar produk<br>✅ Muncul notifikasi sukses<br>✅ Status produk = "pending" (menunggu verifikasi admin) |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.2: Tambah Produk dengan Nama Duplikat
| ID | TC-PE-PROD-002 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf mencoba menambahkan produk dengan nama yang sudah ada |
| **Pre-kondisi** | Produk "Tas Rajut Handmade" sudah ada di database |
| **Test Steps** | 1. Akses `/pelaku-ekraf/products/create`<br>2. Isi nama produk yang sama<br>3. Klik tombol "Simpan" |
| **Input Data** | - Nama Produk: `Tas Rajut Handmade` (duplikat) |
| **Expected Result** | ❌ Produk gagal dibuat<br>✅ Muncul error: "Nama produk sudah digunakan"<br>✅ User tetap di halaman create |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.3: Tambah Produk tanpa Gambar
| ID | TC-PE-PROD-003 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf mencoba menambahkan produk tanpa upload gambar |
| **Pre-kondisi** | User sudah login |
| **Test Steps** | 1. Akses `/pelaku-ekraf/products/create`<br>2. Isi semua field kecuali gambar<br>3. Klik tombol "Simpan" |
| **Input Data** | - Semua field terisi kecuali gambar |
| **Expected Result** | ❌ Produk gagal dibuat<br>✅ Muncul validation error: "Gambar produk wajib diisi" |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.4: Tambah Produk dengan File Invalid
| ID | TC-PE-PROD-004 |
|----|----------------|
| **Deskripsi** | Upload file dengan format atau ukuran tidak sesuai |
| **Pre-kondisi** | User sudah login |
| **Test Steps** | 1. Akses `/pelaku-ekraf/products/create`<br>2. Upload file PDF atau file > 2MB<br>3. Klik tombol "Simpan" |
| **Input Data** | - Gambar: file PDF atau file 5MB |
| **Expected Result** | ❌ Upload gagal<br>✅ Muncul error: "File harus berupa gambar (JPG/PNG)" atau "Ukuran file maksimal 2MB" |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.5: Lihat Daftar Produk
| ID | TC-PE-PROD-005 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf melihat daftar semua produknya |
| **Pre-kondisi** | User sudah menambahkan beberapa produk |
| **Test Steps** | 1. Akses `/pelaku-ekraf/products` |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar produk milik user<br>✅ Menampilkan: gambar, nama, harga, status verifikasi<br>✅ Ada tombol Edit dan Delete untuk setiap produk |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.6: Edit Produk dengan Data Valid
| ID | TC-PE-PROD-006 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf mengedit data produk yang sudah ada |
| **Pre-kondisi** | Produk sudah ada |
| **Test Steps** | 1. Akses `/pelaku-ekraf/products/{id}/edit`<br>2. Ubah data (misal: harga, deskripsi)<br>3. Klik tombol "Update" |
| **Input Data** | - Harga baru: `175000`<br>- Deskripsi baru: `Tas rajut premium berkualitas tinggi` |
| **Expected Result** | ✅ Produk berhasil diupdate<br>✅ Data baru tersimpan di database<br>✅ Redirect ke halaman daftar produk<br>✅ Muncul notifikasi sukses |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.7: Hapus Produk
| ID | TC-PE-PROD-007 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf menghapus produk |
| **Pre-kondisi** | Produk sudah ada |
| **Test Steps** | 1. Akses `/pelaku-ekraf/products`<br>2. Klik tombol "Delete" pada produk tertentu<br>3. Konfirmasi penghapusan |
| **Input Data** | - |
| **Expected Result** | ✅ Produk terhapus dari database<br>✅ Gambar terhapus dari Cloudinary<br>✅ Produk tidak muncul di daftar<br>✅ Muncul notifikasi sukses |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.8: Validasi Real-time Nama Produk (AJAX)
| ID | TC-PE-PROD-008 |
|----|----------------|
| **Deskripsi** | Sistem melakukan validasi nama produk secara real-time saat user mengetik |
| **Pre-kondisi** | Produk "Tas Rajut Handmade" sudah ada |
| **Test Steps** | 1. Akses `/pelaku-ekraf/products/create`<br>2. Ketik nama produk yang sudah ada di field nama<br>3. Blur dari field (pindah ke field lain) |
| **Input Data** | - Nama Produk: `Tas Rajut Handmade` |
| **Expected Result** | ✅ Muncul pesan error secara real-time (tanpa submit form)<br>✅ Pesan: "Nama produk sudah digunakan" |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 5. Manajemen Profile

### Test Case 5.1: Update Profile dengan Data Valid
| ID | TC-PE-PROF-001 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf mengupdate informasi profil |
| **Pre-kondisi** | User sudah login |
| **Test Steps** | 1. Akses `/pelaku-ekraf/profile`<br>2. Ubah data: business_name, deskripsi, sub_sektor<br>3. Klik tombol "Update Profile" |
| **Input Data** | - Business Name: `Kerajinan Tangan Jaya Premium`<br>- Deskripsi: `Usaha kerajinan dengan bahan berkualitas` |
| **Expected Result** | ✅ Profile berhasil diupdate<br>✅ Data baru tersimpan<br>✅ Muncul notifikasi sukses |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 5.2: Upload Profile Image
| ID | TC-PE-PROF-002 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf mengupload foto profil |
| **Pre-kondisi** | User sudah login |
| **Test Steps** | 1. Akses `/pelaku-ekraf/profile`<br>2. Upload gambar profil (JPG/PNG)<br>3. Klik tombol "Update Profile" |
| **Input Data** | - File gambar valid (< 2MB) |
| **Expected Result** | ✅ Gambar ter-upload ke Cloudinary<br>✅ Profile image URL tersimpan di database<br>✅ Gambar tampil di profil |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 5.3: Delete Profile Image
| ID | TC-PE-PROF-003 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf menghapus foto profil |
| **Pre-kondisi** | User sudah punya foto profil |
| **Test Steps** | 1. Akses `/pelaku-ekraf/profile`<br>2. Klik tombol "Delete Image" |
| **Input Data** | - |
| **Expected Result** | ✅ Gambar terhapus dari Cloudinary<br>✅ Profile image = NULL di database<br>✅ Tampil placeholder/default image |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 5.4: Update Password
| ID | TC-PE-PROF-004 |
|----|----------------|
| **Deskripsi** | Pelaku ekraf mengubah password |
| **Pre-kondisi** | User sudah login |
| **Test Steps** | 1. Akses `/pelaku-ekraf/profile`<br>2. Isi current password, new password, confirm password<br>3. Klik tombol "Update Password" |
| **Input Data** | - Current Password: `Password123!`<br>- New Password: `NewPassword456!`<br>- Confirm: `NewPassword456!` |
| **Expected Result** | ✅ Password berhasil diubah<br>✅ Password ter-hash di database<br>✅ Bisa login dengan password baru |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 5.5: Update Password dengan Current Password Salah
| ID | TC-PE-PROF-005 |
|----|----------------|
| **Deskripsi** | User input current password yang salah |
| **Pre-kondisi** | User sudah login |
| **Test Steps** | 1. Akses `/pelaku-ekraf/profile`<br>2. Isi current password yang salah<br>3. Klik tombol "Update Password" |
| **Input Data** | - Current Password: `WrongPassword!` |
| **Expected Result** | ❌ Update gagal<br>✅ Muncul error: "Current password salah" |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 6. Browse Katalog Produk

### Test Case 6.1: Lihat Katalog Produk
| ID | TC-PE-KAT-001 |
|----|---------------|
| **Deskripsi** | Pelaku ekraf browsing katalog produk dari pelaku lain |
| **Pre-kondisi** | Ada produk approved di sistem |
| **Test Steps** | 1. Akses `/pelaku-ekraf/katalog-produk` |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar produk yang sudah approved<br>✅ Menampilkan gambar, nama, harga<br>✅ Bisa klik untuk lihat detail |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.2: Lihat Detail Produk di Katalog
| ID | TC-PE-KAT-002 |
|----|---------------|
| **Deskripsi** | Pelaku ekraf melihat detail produk di katalog |
| **Pre-kondisi** | Produk tersedia di katalog |
| **Test Steps** | 1. Akses `/pelaku-ekraf/katalog-produk`<br>2. Klik salah satu produk |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil detail lengkap produk<br>✅ View count bertambah 1<br>✅ Menampilkan: gambar, nama, harga, deskripsi, info pelaku ekraf |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 7. Authorization & Security

### Test Case 7.1: Akses Dashboard tanpa Login
| ID | TC-PE-SEC-001 |
|----|---------------|
| **Deskripsi** | User yang belum login mencoba akses dashboard |
| **Pre-kondisi** | User belum login |
| **Test Steps** | 1. Akses URL `/pelaku-ekraf` tanpa login |
| **Input Data** | - |
| **Expected Result** | ❌ Akses ditolak<br>✅ Redirect ke halaman `/login` |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 7.2: Pelaku Ekraf Tidak Bisa Edit Produk Orang Lain
| ID | TC-PE-SEC-002 |
|----|---------------|
| **Deskripsi** | Pelaku ekraf mencoba edit produk milik pelaku lain |
| **Pre-kondisi** | Login sebagai Pelaku A, coba akses produk milik Pelaku B |
| **Test Steps** | 1. Login sebagai Pelaku A<br>2. Coba akses `/pelaku-ekraf/products/{id_produk_B}/edit` |
| **Input Data** | - |
| **Expected Result** | ❌ Akses ditolak<br>✅ Muncul error 403 Forbidden atau redirect |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## Ringkasan Hasil Testing

| Kategori | Total Test Case | Pass | Fail | Pass Rate |
|----------|-----------------|------|------|-----------|
| Registrasi | 3 | - | - | - |
| Login | 2 | - | - | - |
| Dashboard | 1 | - | - | - |
| Manajemen Produk | 8 | - | - | - |
| Manajemen Profile | 5 | - | - | - |
| Katalog | 2 | - | - | - |
| Security | 2 | - | - | - |
| **TOTAL** | **23** | **-** | **-** | **-%** |

---

## Catatan Bug/Issue yang Ditemukan

| No | Test Case ID | Deskripsi Bug | Severity | Status |
|----|--------------|---------------|----------|--------|
| 1  | - | - | - | - |
| 2  | - | - | - | - |

**Severity Level:**
- **Critical**: Aplikasi crash/tidak bisa digunakan
- **High**: Fitur utama tidak berfungsi
- **Medium**: Fitur berfungsi tapi ada error
- **Low**: Tampilan/UX issue

---

## Screenshot Evidence

_(Lampirkan screenshot untuk setiap test case yang penting)_

---

**Catatan Tester:**
- _[Tulis observasi umum tentang aplikasi]_
- _[Rekomendasi perbaikan]_
