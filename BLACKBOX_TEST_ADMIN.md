# Black Box Testing - Admin Panel

**Tanggal Testing**: 21 Desember 2025  
**Tester**: [Nama Tester]  
**Versi Aplikasi**: 1.0  
**Environment**: Development/Staging/Production

---

## Daftar Isi
1. [Login Admin](#1-login-admin)
2. [Dashboard Admin](#2-dashboard-admin)
3. [Verifikasi Produk](#3-verifikasi-produk)
4. [Manajemen Pelaku Ekraf](#4-manajemen-pelaku-ekraf)
5. [Manajemen User](#5-manajemen-user)
6. [Manajemen Artikel](#6-manajemen-artikel)
7. [Manajemen Banner](#7-manajemen-banner)
8. [Manajemen Sub Sektor](#8-manajemen-sub-sektor)
9. [Manajemen Kategori Artikel](#9-manajemen-kategori-artikel)
10. [Manajemen Business Category](#10-manajemen-business-category)
11. [Manajemen Author](#11-manajemen-author)
12. [Role-Based Access Control](#12-role-based-access-control)
13. [Pagination & Performance](#13-pagination--performance)
14. [Export Data](#14-export-data)
15. [Widgets & Statistics](#15-widgets--statistics)

---

## 1. Login Admin

### Test Case 1.1: Login Admin dengan Kredensial Valid
| ID | TC-ADM-LOGIN-001 |
|----|------------------|
| **Deskripsi** | Admin login dengan email dan password yang benar |
| **Pre-kondisi** | User sudah terdaftar sebagai admin/superadmin |
| **Test Steps** | 1. Buka halaman `/admin`<br>2. Isi email dan password admin<br>3. Klik tombol "Login" |
| **Input Data** | - Email: `admin@ekraf.com`<br>- Password: `admin123` |
| **Expected Result** | ✅ Login berhasil<br>✅ Redirect ke `/admin` (dashboard admin)<br>✅ Tampil panel Filament |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |
| **Screenshot** | _(Lampirkan screenshot)_ |

### Test Case 1.2: Login Admin dengan Password Salah
| ID | TC-ADM-LOGIN-002 |
|----|------------------|
| **Deskripsi** | Admin login dengan password yang salah |
| **Pre-kondisi** | User terdaftar sebagai admin |
| **Test Steps** | 1. Buka halaman `/admin`<br>2. Isi email benar, password salah<br>3. Klik tombol "Login" |
| **Input Data** | - Email: `admin@ekraf.com`<br>- Password: `wrongpassword` |
| **Expected Result** | ❌ Login gagal<br>✅ Muncul error message<br>✅ User tetap di halaman login |
| **Actual Result** | _(Isi setetah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 1.3: Pelaku Ekraf Tidak Bisa Akses Admin Panel
| ID | TC-ADM-LOGIN-003 |
|----|------------------|
| **Deskripsi** | User dengan role pelaku_ekraf mencoba login ke admin panel |
| **Pre-kondisi** | User terdaftar sebagai pelaku ekraf (bukan admin) |
| **Test Steps** | 1. Buka halaman `/admin`<br>2. Isi kredensial pelaku ekraf<br>3. Klik tombol "Login" |
| **Input Data** | - Email: `pelaku1@test.com`<br>- Password: `Password123!` |
| **Expected Result** | ❌ Login gagal / akses ditolak<br>✅ Muncul error: "Unauthorized" atau redirect |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 2. Dashboard Admin

### Test Case 2.1: Akses Dashboard Admin
| ID | TC-ADM-DASH-001 |
|----|-----------------|
| **Deskripsi** | Admin mengakses dashboard setelah login |
| **Pre-kondisi** | User sudah login sebagai admin |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses URL `/admin` |
| **Input Data** | - |
| **Expected Result** | ✅ Dashboard tampil<br>✅ Menampilkan statistik (jumlah produk, pelaku ekraf, user, dll)<br>✅ Menu navigasi resources tampil |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 3. Verifikasi Produk

### Test Case 3.1: Lihat Daftar Produk Pending
| ID | TC-ADM-PROD-001 |
|----|-----------------|
| **Deskripsi** | Admin melihat daftar produk yang menunggu verifikasi |
| **Pre-kondisi** | Ada produk dengan status "pending" di database |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Produk" di sidebar<br>3. Filter produk dengan status "pending" |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar produk pending<br>✅ Menampilkan: nama produk, pelaku ekraf, tanggal submit, status |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 3.2: Approve Produk (Individual)
| ID | TC-ADM-PROD-002 |
|----|-----------------|
| **Deskripsi** | Admin menyetujui produk yang pending |
| **Pre-kondisi** | Ada produk dengan status "pending" |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Produk"<br>3. Klik produk pending untuk view detail<br>4. Klik action "Approve" |
| **Input Data** | - |
| **Expected Result** | ✅ Status produk berubah menjadi "approved"<br>✅ Produk muncul di katalog publik<br>✅ Muncul notifikasi sukses<br>✅ Data tersimpan di database (status = approved, verified_at = timestamp) |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 3.3: Reject Produk dengan Alasan
| ID | TC-ADM-PROD-003 |
|----|-----------------|
| **Deskripsi** | Admin menolak produk dengan memberikan alasan |
| **Pre-kondisi** | Ada produk dengan status "pending" |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Produk"<br>3. Klik produk pending<br>4. Klik action "Reject"<br>5. Isi alasan penolakan<br>6. Confirm |
| **Input Data** | - Alasan: `Gambar produk tidak sesuai standar` |
| **Expected Result** | ✅ Status produk berubah menjadi "rejected"<br>✅ Rejection reason tersimpan<br>✅ Produk tidak muncul di katalog<br>✅ Pelaku ekraf bisa lihat alasan penolakan |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 3.4: Reject Produk tanpa Alasan
| ID | TC-ADM-PROD-004 |
|----|-----------------|
| **Deskripsi** | Admin mencoba reject produk tanpa mengisi alasan |
| **Pre-kondisi** | Ada produk pending |
| **Test Steps** | 1. Login sebagai admin<br>2. Klik action "Reject"<br>3. Kosongkan field alasan<br>4. Confirm |
| **Input Data** | - Alasan: _(kosong)_ |
| **Expected Result** | ❌ Reject gagal<br>✅ Muncul validation error: "Alasan penolakan wajib diisi" |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 3.5: Bulk Approve Produk
| ID | TC-ADM-PROD-005 |
|----|-----------------|
| **Deskripsi** | Admin menyetujui beberapa produk sekaligus (bulk action) |
| **Pre-kondisi** | Ada minimal 3 produk pending |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Produk"<br>3. Centang checkbox untuk 3 produk<br>4. Pilih bulk action "Approve Selected"<br>5. Confirm |
| **Input Data** | - |
| **Expected Result** | ✅ Semua produk yang dipilih berubah status menjadi "approved"<br>✅ Muncul notifikasi: "3 produk berhasil diapprove"<br>✅ Produk muncul di katalog |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 3.6: Bulk Reject Produk
| ID | TC-ADM-PROD-006 |
|----|-----------------|
| **Deskripsi** | Admin menolak beberapa produk sekaligus |
| **Pre-kondisi** | Ada minimal 3 produk pending |
| **Test Steps** | 1. Login sebagai admin<br>2. Centang checkbox untuk 3 produk<br>3. Pilih bulk action "Reject Selected"<br>4. Isi alasan penolakan<br>5. Confirm |
| **Input Data** | - Alasan: `Tidak sesuai kategori ekraf` |
| **Expected Result** | ✅ Semua produk yang dipilih berubah status menjadi "rejected"<br>✅ Alasan tersimpan untuk semua produk<br>✅ Muncul notifikasi sukses |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 3.7: Filter Produk by Status
| ID | TC-ADM-PROD-007 |
|----|-----------------|
| **Deskripsi** | Admin filter produk berdasarkan status verifikasi |
| **Pre-kondisi** | Ada produk dengan berbagai status (pending, approved, rejected) |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Produk"<br>3. Gunakan filter status: pilih "Approved" |
| **Input Data** | - Status Filter: `Approved` |
| **Expected Result** | ✅ Hanya tampil produk dengan status "approved"<br>✅ Produk pending/rejected tidak tampil |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 3.8: Search Produk by Nama
| ID | TC-ADM-PROD-008 |
|----|-----------------|
| **Deskripsi** | Admin mencari produk berdasarkan nama |
| **Pre-kondisi** | Ada produk dengan nama "Tas Rajut Handmade" |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Produk"<br>3. Ketik "Tas Rajut" di search box |
| **Input Data** | - Search: `Tas Rajut` |
| **Expected Result** | ✅ Tampil produk yang sesuai keyword<br>✅ Produk lain tidak tampil |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 4. Manajemen Pelaku Ekraf

### Test Case 4.1: Lihat Daftar Pelaku Ekraf
| ID | TC-ADM-PE-001 |
|----|--------------| 
| **Deskripsi** | Admin melihat daftar semua pelaku ekraf |
| **Pre-kondisi** | Ada data pelaku ekraf di database |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Pelaku Ekrafs" di sidebar |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar pelaku ekraf<br>✅ Menampilkan: business name, sub sektor, jumlah produk, tanggal bergabung |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.2: Lihat Detail Pelaku Ekraf
| ID | TC-ADM-PE-002 |
|----|--------------| 
| **Deskripsi** | Admin melihat detail informasi pelaku ekraf |
| **Pre-kondisi** | Ada data pelaku ekraf |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Pelaku Ekrafs"<br>3. Klik salah satu pelaku ekraf untuk view detail |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil detail lengkap pelaku ekraf<br>✅ Menampilkan: profile image, business info, sub sektor, deskripsi, user account info<br>✅ Tampil relasi: daftar produk milik pelaku ekraf tersebut |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.3: Create Pelaku Ekraf dari Admin
| ID | TC-ADM-PE-003 |
|----|--------------| 
| **Deskripsi** | Admin membuat data pelaku ekraf baru dari admin panel |
| **Pre-kondisi** | - |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Pelaku Ekrafs"<br>3. Klik tombol "Create"<br>4. Isi form: pilih user, business_name, sub_sektor, deskripsi<br>5. Klik "Save" |
| **Input Data** | - User ID: (pilih user yang belum punya pelaku ekraf)<br>- Business Name: `Batik Nusantara`<br>- Sub Sektor: (pilih)<br>- Deskripsi: `Produsen batik tradisional` |
| **Expected Result** | ✅ Pelaku ekraf berhasil dibuat<br>✅ Data tersimpan di database<br>✅ User tersebut kini memiliki akses pelaku ekraf |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.4: Edit Pelaku Ekraf
| ID | TC-ADM-PE-004 |
|----|--------------| 
| **Deskripsi** | Admin mengedit data pelaku ekraf |
| **Pre-kondisi** | Data pelaku ekraf sudah ada |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Pelaku Ekrafs"<br>3. Klik "Edit" pada pelaku ekraf tertentu<br>4. Ubah data (misal: business_name, deskripsi)<br>5. Klik "Save" |
| **Input Data** | - Business Name baru: `Batik Nusantara Premium` |
| **Expected Result** | ✅ Data berhasil diupdate<br>✅ Perubahan tersimpan di database |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.5: Delete Pelaku Ekraf
| ID | TC-ADM-PE-005 |
|----|--------------| 
| **Deskripsi** | Admin menghapus data pelaku ekraf |
| **Pre-kondisi** | Data pelaku ekraf sudah ada |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Pelaku Ekrafs"<br>3. Klik "Delete" pada pelaku ekraf tertentu<br>4. Confirm penghapusan |
| **Input Data** | - |
| **Expected Result** | ✅ Data pelaku ekraf terhapus<br>✅ Cascade delete: produk terkait juga terhapus<br>✅ Gambar di Cloudinary terhapus<br>✅ User account masih ada (tidak ikut terhapus) |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 4.6: Pelaku Ekraf Relation Manager
| ID | TC-ADM-PE-006 |
|----|--------------| 
| **Deskripsi** | Admin melihat daftar produk dari pelaku ekraf tertentu via relation manager |
| **Pre-kondisi** | Pelaku ekraf memiliki beberapa produk |
| **Test Steps** | 1. Login sebagai admin<br>2. Edit pelaku ekraf tertentu<br>3. Scroll ke bagian "Produk" (relation manager) |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar produk milik pelaku ekraf tersebut<br>✅ Bisa mengelola produk langsung dari sini |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 5. Manajemen User

### Test Case 5.1: Lihat Daftar User
| ID | TC-ADM-USER-001 |
|----|-----------------|
| **Deskripsi** | Admin melihat daftar semua user |
| **Pre-kondisi** | Ada user di database |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Users" di sidebar |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar user<br>✅ Menampilkan: nama, email, role, tanggal registrasi |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 5.2: Create User dari Admin
| ID | TC-ADM-USER-002 |
|----|-----------------|
| **Deskripsi** | Admin membuat user baru dari admin panel |
| **Pre-kondisi** | - |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Users"<br>3. Klik tombol "Create"<br>4. Isi form: nama, email, password, role<br>5. Klik "Save" |
| **Input Data** | - Name: `Admin Baru`<br>- Email: `admin2@ekraf.com`<br>- Password: `admin456`<br>- Role: `admin` atau `pelaku_ekraf` |
| **Expected Result** | ✅ User berhasil dibuat<br>✅ Password ter-hash<br>✅ Data tersimpan di database<br>✅ User bisa login |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 5.3: Edit User
| ID | TC-ADM-USER-003 |
|----|-----------------|
| **Deskripsi** | Admin mengedit data user |
| **Pre-kondisi** | User sudah ada |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Users"<br>3. Klik "Edit" pada user tertentu<br>4. Ubah data (misal: nama, email)<br>5. Klik "Save" |
| **Input Data** | - Name baru: `Admin Utama` |
| **Expected Result** | ✅ Data berhasil diupdate<br>✅ Perubahan tersimpan di database |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 5.4: Delete User
| ID | TC-ADM-USER-004 |
|----|-----------------|
| **Deskripsi** | Admin menghapus user |
| **Pre-kondisi** | User sudah ada dan bukan akun admin yang sedang login |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Users"<br>3. Klik "Delete" pada user tertentu<br>4. Confirm |
| **Input Data** | - |
| **Expected Result** | ✅ User terhapus<br>✅ Jika user memiliki pelaku ekraf, data pelaku ekraf ikut terhapus (cascade) |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 5.5: Filter User by Role
| ID | TC-ADM-USER-005 |
|----|-----------------|
| **Deskripsi** | Admin filter user berdasarkan role |
| **Pre-kondisi** | Ada user dengan berbagai role |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Users"<br>3. Gunakan filter role: pilih "pelaku_ekraf" |
| **Input Data** | - Role Filter: `pelaku_ekraf` |
| **Expected Result** | ✅ Hanya tampil user dengan role "pelaku_ekraf"<br>✅ User admin tidak tampil |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 6. Role-Based Access Control (Superadmin vs Admin)

### Test Case 6.1: Superadmin Akses Semua Resources
| ID | TC-ADM-RBAC-001 |
|----|-----------------|
| **Deskripsi** | Superadmin bisa mengakses semua resources |
| **Pre-kondisi** | Login sebagai superadmin |
| **Test Steps** | 1. Login sebagai superadmin<br>2. Cek menu sidebar |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil semua menu: Users, Produk, Pelaku Ekrafs, Artikel, Banner, dll<br>✅ Bisa create, edit, delete semua resources |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.2: Admin Akses Terbatas
| ID | TC-ADM-RBAC-002 |
|----|-----------------|
| **Deskripsi** | Admin biasa hanya bisa akses resources tertentu |
| **Pre-kondisi** | Login sebagai admin (bukan superadmin) |
| **Test Steps** | 1. Login sebagai admin<br>2. Cek menu sidebar |
| **Input Data** | - |
| **Expected Result** | ✅ Hanya tampil menu tertentu (sesuai HasRoleBasedAccess trait)<br>❌ Tidak bisa akses: Users, Pelaku Ekrafs (atau resources yang restricted) |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.3: Admin Tidak Bisa Edit Resource Restricted
| ID | TC-ADM-RBAC-003 |
|----|-----------------|
| **Deskripsi** | Admin biasa tidak bisa edit resource yang di-restrict |
| **Pre-kondisi** | Login sebagai admin (bukan superadmin) |
| **Test Steps** | 1. Login sebagai admin<br>2. Coba akses URL `/admin/pelaku-ekrafs` secara manual |
| **Input Data** | - |
| **Expected Result** | ❌ Akses ditolak<br>✅ Error 403 Forbidden atau redirect |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 13. Pagination & Performance

### Test Case 13.1: Pagination di Daftar Produk
| ID | TC-ADM-PERF-001 |
|----|-----------------| 
| **Deskripsi** | Pagination berfungsi dengan baik di daftar produk |
| **Pre-kondisi** | Ada lebih dari 10 produk (default page size) |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Produk"<br>3. Klik halaman 2, 3, dst |
| **Input Data** | - |
| **Expected Result** | ✅ Pagination tampil<br>✅ Bisa navigasi antar halaman<br>✅ Data sesuai dengan halaman yang dipilih |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 13.2: Table Sorting
| ID | TC-ADM-PERF-002 |
|----|-----------------| 
| **Deskripsi** | Sorting kolom table berfungsi |
| **Pre-kondisi** | Ada data di table |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Produk"<br>3. Klik header kolom "Nama Produk" untuk sort |
| **Input Data** | - |
| **Expected Result** | ✅ Data ter-sort ascending<br>✅ Klik lagi untuk sort descending |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 13.3: Global Search
| ID | TC-ADM-PERF-003 |
|----|-----------------| 
| **Deskripsi** | Global search Filament berfungsi |
| **Pre-kondisi** | Ada data di berbagai resources |
| **Test Steps** | 1. Klik global search (Ctrl+K)<br>2. Ketik keyword<br>3. Lihat hasil |
| **Input Data** | - Search: `Tas Rajut` |
| **Expected Result** | ✅ Tampil hasil dari berbagai resources (produk, artikel, dll) |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 14. Export Data

### Test Case 14.1: Export Produk ke Excel
| ID | TC-ADM-EXP-001 |
|----|----------------|
| **Deskripsi** | Admin export data produk ke Excel |
| **Pre-kondisi** | Ada data produk |
| **Test Steps** | 1. Akses menu "Produk"<br>2. Klik tombol "Export"<br>3. Download file |
| **Input Data** | - |
| **Expected Result** | ✅ File Excel ter-download<br>✅ Data sesuai dengan di database<br>✅ Format Excel benar |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 14.2: Export dengan Filter
| ID | TC-ADM-EXP-002 |
|----|----------------|
| **Deskripsi** | Export data yang sudah di-filter |
| **Pre-kondisi** | Ada data produk |
| **Test Steps** | 1. Filter produk (misalnya: status=approved)<br>2. Klik "Export" |
| **Input Data** | - Filter: status=approved |
| **Expected Result** | ✅ Hanya data yang di-filter yang ter-export |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 15. Widgets & Statistics

### Test Case 15.1: Stats Overview Widget
| ID | TC-ADM-WIDGET-001 |
|----| -------------------|
| **Deskripsi** | Dashboard menampilkan widget statistik |
| **Pre-kondisi** | Login sebagai admin |
| **Test Steps** | 1. Akses dashboard admin |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil widget: Total Produk, Total Pelaku Ekraf, Pending Products, dll<br>✅ Angka sesuai dengan data di database |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 15.2: Chart Widget
| ID | TC-ADM-WIDGET-002 |
|----| -------------------|
| **Deskripsi** | Dashboard menampilkan chart/grafik |
| **Pre-kondisi** | Ada data historis |
| **Test Steps** | 1. Akses dashboard<br>2. Lihat chart |
| **Input Data** | - |
| **Expected Result** | ✅ Chart tampil dengan benar<br>✅ Data chart sesuai dengan database |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 15.3: Latest Products Widget
| ID | TC-ADM-WIDGET-003 |
|----| -------------------|
| **Deskripsi** | Dashboard menampilkan produk terbaru |
| **Pre-kondisi** | Ada produk di database |
| **Test Steps** | 1. Akses dashboard |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil 5-10 produk terbaru<br>✅ Urutan berdasarkan tanggal dibuat (descending) |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 8. Manajemen Sub Sektor

### Test Case 8.1: Lihat Daftar Sub Sektor
| ID | TC-ADM-SUBSEKTOR-001 |
|----|-----------------------|
| **Deskripsi** | Admin melihat daftar sub sektor ekonomi kreatif |
| **Pre-kondisi** | Ada data sub sektor di database |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Sub Sektor" |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar sub sektor<br>✅ Menampilkan: nama, deskripsi, jumlah pelaku ekraf |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 8.2: Create Sub Sektor
| ID | TC-ADM-SUBSEKTOR-002 |
|----|-----------------------|
| **Deskripsi** | Admin membuat sub sektor baru |
| **Pre-kondisi** | Login sebagai admin |
| **Test Steps** | 1. Akses menu "Sub Sektor"<br>2. Klik "Create"<br>3. Isi nama dan deskripsi<br>4. Klik "Save" |
| **Input Data** | - Nama: `Kriya`<br>- Deskripsi: `Kerajinan tangan tradisional` |
| **Expected Result** | ✅ Sub sektor berhasil dibuat<br>✅ Data tersimpan di database<br>✅ Sub sektor muncul di dropdown saat create pelaku ekraf |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 8.3: Edit Sub Sektor
| ID | TC-ADM-SUBSEKTOR-003 |
|----|-----------------------|
| **Deskripsi** | Admin mengedit sub sektor yang sudah ada |
| **Pre-kondisi** | Sub sektor sudah ada |
| **Test Steps** | 1. Akses menu "Sub Sektor"<br>2. Klik "Edit" pada sub sektor<br>3. Ubah data<br>4. Klik "Save" |
| **Input Data** | - Nama baru: `Kriya Modern` |
| **Expected Result** | ✅ Data berhasil diupdate<br>✅ Perubahan tersimpan di database |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 8.4: Delete Sub Sektor
| ID | TC-ADM-SUBSEKTOR-004 |
|----|-----------------------|
| **Deskripsi** | Admin menghapus sub sektor |
| **Pre-kondisi** | Sub sektor tidak digunakan oleh pelaku ekraf aktif |
| **Test Steps** | 1. Akses menu "Sub Sektor"<br>2. Klik "Delete"<br>3. Confirm |
| **Input Data** | - |
| **Expected Result** | ✅ Sub sektor terhapus<br>✅ Atau muncul error jika masih digunakan |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 8.5: Validasi Sub Sektor Duplikat
| ID | TC-ADM-SUBSEKTOR-005 |
|----|-----------------------|
| **Deskripsi** | Sistem mencegah sub sektor dengan nama yang sama |
| **Pre-kondisi** | Sub sektor "Kriya" sudah ada |
| **Test Steps** | 1. Coba create sub sektor dengan nama "Kriya" lagi |
| **Input Data** | - Nama: `Kriya` (duplikat) |
| **Expected Result** | ❌ Create gagal<br>✅ Muncul validation error |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 9. Manajemen Kategori Artikel

### Test Case 9.1: Lihat Daftar Kategori Artikel
| ID | TC-ADM-KATART-001 |
|----|--------------------|
| **Deskripsi** | Admin melihat daftar kategori artikel |
| **Pre-kondisi** | Ada data kategori di database |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Artikel Kategori" |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar kategori<br>✅ Menampilkan: nama, slug, jumlah artikel |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 9.2: Create Kategori Artikel
| ID | TC-ADM-KATART-002 |
|----|--------------------|
| **Deskripsi** | Admin membuat kategori artikel baru |
| **Pre-kondisi** | Login sebagai admin |
| **Test Steps** | 1. Akses menu "Artikel Kategori"<br>2. Klik "Create"<br>3. Isi nama<br>4. Klik "Save" |
| **Input Data** | - Nama: `Tips Bisnis`<br>- Slug: (auto-generate) |
| **Expected Result** | ✅ Kategori berhasil dibuat<br>✅ Slug ter-generate otomatis<br>✅ Bisa dipilih saat create artikel |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 9.3: Edit Kategori Artikel
| ID | TC-ADM-KATART-003 |
|----|--------------------|
| **Deskripsi** | Admin mengedit kategori artikel |
| **Pre-kondisi** | Kategori sudah ada |
| **Test Steps** | 1. Akses menu "Artikel Kategori"<br>2. Klik "Edit"<br>3. Ubah nama<br>4. Klik "Save" |
| **Input Data** | - Nama baru: `Tips Bisnis Ekraf` |
| **Expected Result** | ✅ Data berhasil diupdate<br>✅ Slug ter-update otomatis |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 9.4: Delete Kategori Artikel
| ID | TC-ADM-KATART-004 |
|----|--------------------|
| **Deskripsi** | Admin menghapus kategori artikel |
| **Pre-kondisi** | Kategori tidak digunakan artikel aktif |
| **Test Steps** | 1. Akses menu "Artikel Kategori"<br>2. Klik "Delete"<br>3. Confirm |
| **Input Data** | - |
| **Expected Result** | ✅ Kategori terhapus<br>✅ Atau error jika masih digunakan |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 10. Manajemen Business Category

### Test Case 10.1: Lihat Daftar Business Category
| ID | TC-ADM-BIZCAT-001 |
|----|--------------------||
| **Deskripsi** | Admin melihat daftar business category |
| **Pre-kondisi** | Ada data di database |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Business Categories" |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar category<br>✅ Menampilkan: nama, icon, deskripsi |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 10.2: Create Business Category
| ID | TC-ADM-BIZCAT-002 |
|----|--------------------||
| **Deskripsi** | Admin membuat business category baru |
| **Pre-kondisi** | Login sebagai admin |
| **Test Steps** | 1. Akses menu "Business Categories"<br>2. Klik "Create"<br>3. Isi form<br>4. Klik "Save" |
| **Input Data** | - Nama: `Fashion`<br>- Icon: `fa-tshirt`<br>- Deskripsi: `Produk fashion` |
| **Expected Result** | ✅ Category berhasil dibuat<br>✅ Data tersimpan |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 10.3: Edit Business Category
| ID | TC-ADM-BIZCAT-003 |
|----|--------------------||
| **Deskripsi** | Admin mengedit business category |
| **Pre-kondisi** | Category sudah ada |
| **Test Steps** | 1. Klik "Edit" pada category<br>2. Ubah data<br>3. Klik "Save" |
| **Input Data** | - Nama baru: `Fashion & Tekstil` |
| **Expected Result** | ✅ Data berhasil diupdate |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 10.4: Delete Business Category
| ID | TC-ADM-BIZCAT-004 |
|----|--------------------||
| **Deskripsi** | Admin menghapus business category |
| **Pre-kondisi** | Category tidak digunakan |
| **Test Steps** | 1. Klik "Delete"<br>2. Confirm |
| **Input Data** | - |
| **Expected Result** | ✅ Category terhapus |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 11. Manajemen Author

### Test Case 11.1: Lihat Daftar Author
| ID | TC-ADM-AUTH-001 |
|----|------------------|
| **Deskripsi** | Admin melihat daftar author artikel |
| **Pre-kondisi** | Ada data author di database |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Authors" |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar author<br>✅ Menampilkan: nama, bio, jumlah artikel |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 11.2: Create Author
| ID | TC-ADM-AUTH-002 |
|----|------------------|
| **Deskripsi** | Admin membuat author baru |
| **Pre-kondisi** | Login sebagai admin |
| **Test Steps** | 1. Akses menu "Authors"<br>2. Klik "Create"<br>3. Isi form<br>4. Klik "Save" |
| **Input Data** | - Nama: `John Doe`<br>- Bio: `Content writer`<br>- Email: `john@example.com` |
| **Expected Result** | ✅ Author berhasil dibuat<br>✅ Bisa dipilih saat create artikel |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 11.3: Edit Author
| ID | TC-ADM-AUTH-003 |
|----|------------------|
| **Deskripsi** | Admin mengedit data author |
| **Pre-kondisi** | Author sudah ada |
| **Test Steps** | 1. Klik "Edit" pada author<br>2. Ubah data<br>3. Klik "Save" |
| **Input Data** | - Bio baru: `Senior Content Writer` |
| **Expected Result** | ✅ Data berhasil diupdate |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 11.4: Delete Author
| ID | TC-ADM-AUTH-004 |
|----|------------------|
| **Deskripsi** | Admin menghapus author |
| **Pre-kondisi** | Author tidak memiliki artikel aktif |
| **Test Steps** | 1. Klik "Delete"<br>2. Confirm |
| **Input Data** | - |
| **Expected Result** | ✅ Author terhapus<br>✅ Atau error jika masih punya artikel |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 6. Manajemen Artikel

### Test Case 6.1: Lihat Daftar Artikel
| ID | TC-ADM-ART-001 |
|----|-----------------|
| **Deskripsi** | Admin melihat daftar semua artikel |
| **Pre-kondisi** | Ada artikel di database |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Artikel" |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar artikel<br>✅ Menampilkan: judul, kategori, author, status, tanggal publish |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.2: Create Artikel dengan Data Lengkap
| ID | TC-ADM-ART-002 |
|----|-----------------|
| **Deskripsi** | Admin membuat artikel baru dengan semua field terisi |
| **Pre-kondisi** | Login sebagai admin, ada kategori dan author |
| **Test Steps** | 1. Akses menu "Artikel"<br>2. Klik "Create"<br>3. Isi semua field<br>4. Upload featured image<br>5. Klik "Save" |
| **Input Data** | - Judul: `Tips Memulai Bisnis Ekraf`<br>- Slug: (auto-generate)<br>- Konten: (rich text editor)<br>- Kategori: `Tips Bisnis`<br>- Author: (pilih)<br>- Featured Image: (upload)<br>- Status: `published`<br>- Tanggal Publish: (pilih tanggal) |
| **Expected Result** | ✅ Artikel berhasil dibuat<br>✅ Slug ter-generate otomatis<br>✅ Image ter-upload<br>✅ Artikel tampil di homepage/public jika published |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.3: Create Artikel sebagai Draft
| ID | TC-ADM-ART-003 |
|----|-----------------|
| **Deskripsi** | Admin menyimpan artikel sebagai draft |
| **Pre-kondisi** | Login sebagai admin |
| **Test Steps** | 1. Create artikel<br>2. Set status = "draft"<br>3. Klik "Save" |
| **Input Data** | - Status: `draft` |
| **Expected Result** | ✅ Artikel tersimpan sebagai draft<br>❌ Artikel tidak tampil di public |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.4: Edit Artikel
| ID | TC-ADM-ART-004 |
|----|-----------------|
| **Deskripsi** | Admin mengedit artikel yang sudah ada |
| **Pre-kondisi** | Artikel sudah ada |
| **Test Steps** | 1. Akses menu "Artikel"<br>2. Klik "Edit" pada artikel<br>3. Ubah data<br>4. Klik "Save" |
| **Input Data** | - Judul baru: `Tips Memulai Bisnis Ekraf 2025` |
| **Expected Result** | ✅ Artikel berhasil diupdate<br>✅ Perubahan tersimpan |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.5: Delete Artikel
| ID | TC-ADM-ART-005 |
|----|-----------------|
| **Deskripsi** | Admin menghapus artikel |
| **Pre-kondisi** | Artikel sudah ada |
| **Test Steps** | 1. Klik "Delete" pada artikel<br>2. Confirm |
| **Input Data** | - |
| **Expected Result** | ✅ Artikel terhapus<br>✅ Featured image terhapus |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.6: Filter Artikel by Kategori
| ID | TC-ADM-ART-006 |
|----|-----------------|
| **Deskripsi** | Admin filter artikel berdasarkan kategori |
| **Pre-kondisi** | Ada artikel dengan berbagai kategori |
| **Test Steps** | 1. Akses menu "Artikel"<br>2. Gunakan filter kategori |
| **Input Data** | - Filter: `Tips Bisnis` |
| **Expected Result** | ✅ Hanya tampil artikel dengan kategori tersebut |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.7: Filter Artikel by Status
| ID | TC-ADM-ART-007 |
|----|-----------------|
| **Deskripsi** | Admin filter artikel berdasarkan status |
| **Pre-kondisi** | Ada artikel published dan draft |
| **Test Steps** | 1. Gunakan filter status<br>2. Pilih "draft" |
| **Input Data** | - Filter: `draft` |
| **Expected Result** | ✅ Hanya tampil artikel draft |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.8: Search Artikel by Judul
| ID | TC-ADM-ART-008 |
|----|-----------------|
| **Deskripsi** | Admin search artikel berdasarkan judul |
| **Pre-kondisi** | Ada artikel di database |
| **Test Steps** | 1. Ketik keyword di search box |
| **Input Data** | - Search: `Tips Bisnis` |
| **Expected Result** | ✅ Tampil artikel yang sesuai keyword |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.9: Validasi Artikel Tanpa Featured Image
| ID | TC-ADM-ART-009 |
|----|-----------------|
| **Deskripsi** | Admin mencoba publish artikel tanpa featured image |
| **Pre-kondisi** | - |
| **Test Steps** | 1. Create artikel<br>2. Tidak upload featured image<br>3. Klik "Save" |
| **Input Data** | - Featured Image: (kosong) |
| **Expected Result** | ✅ Bisa tersimpan (jika optional)<br>❌ Atau muncul validation error (jika required) |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 6.10: Rich Text Editor Functionality
| ID | TC-ADM-ART-010 |
|----|-----------------|
| **Deskripsi** | Rich text editor berfungsi untuk formatting konten |
| **Pre-kondisi** | Sedang create/edit artikel |
| **Test Steps** | 1. Gunakan rich text editor<br>2. Test formatting: bold, italic, list, link, image |
| **Input Data** | - Various formatting |
| **Expected Result** | ✅ Semua formatting berfungsi<br>✅ Preview sesuai dengan hasil |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 7. Manajemen Banner

### Test Case 7.1: Lihat Daftar Banner
| ID | TC-ADM-BAN-001 |
|----|----------------|
| **Deskripsi** | Admin melihat daftar banner homepage |
| **Pre-kondisi** | Ada banner di database |
| **Test Steps** | 1. Login sebagai admin<br>2. Akses menu "Banner" |
| **Input Data** | - |
| **Expected Result** | ✅ Tampil daftar banner<br>✅ Menampilkan: judul, image, order, status aktif |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 7.2: Create Banner dengan Image
| ID | TC-ADM-BAN-002 |
|----|----------------|
| **Deskripsi** | Admin membuat banner baru dengan upload image |
| **Pre-kondisi** | Login sebagai admin |
| **Test Steps** | 1. Akses menu "Banner"<br>2. Klik "Create"<br>3. Isi judul, upload image, set order<br>4. Klik "Save" |
| **Input Data** | - Judul: `Promo Ekraf 2025`<br>- Image: (file JPG/PNG)<br>- Order: `1`<br>- Is Active: `true` |
| **Expected Result** | ✅ Banner berhasil dibuat<br>✅ Image ter-upload<br>✅ Banner tampil di homepage sesuai order |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 7.3: Edit Banner
| ID | TC-ADM-BAN-003 |
|----|----------------|
| **Deskripsi** | Admin mengedit banner yang sudah ada |
| **Pre-kondisi** | Banner sudah ada |
| **Test Steps** | 1. Klik "Edit" pada banner<br>2. Ubah judul atau image<br>3. Klik "Save" |
| **Input Data** | - Judul baru: `Promo Spesial Ekraf` |
| **Expected Result** | ✅ Banner berhasil diupdate<br>✅ Perubahan tampil di homepage |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 7.4: Delete Banner
| ID | TC-ADM-BAN-004 |
|----|----------------|
| **Deskripsi** | Admin menghapus banner |
| **Pre-kondisi** | Banner sudah ada |
| **Test Steps** | 1. Klik "Delete"<br>2. Confirm |
| **Input Data** | - |
| **Expected Result** | ✅ Banner terhapus<br>✅ Image terhapus<br>✅ Banner tidak tampil di homepage |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 7.5: Toggle Banner Active/Inactive
| ID | TC-ADM-BAN-005 |
|----|----------------|
| **Deskripsi** | Admin mengaktifkan/menonaktifkan banner |
| **Pre-kondisi** | Banner sudah ada |
| **Test Steps** | 1. Edit banner<br>2. Toggle "Is Active"<br>3. Save |
| **Input Data** | - Is Active: `false` |
| **Expected Result** | ✅ Banner nonaktif tidak tampil di homepage<br>✅ Banner aktif tampil di homepage |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 7.6: Banner Ordering
| ID | TC-ADM-BAN-006 |
|----|----------------|
| **Deskripsi** | Banner tampil sesuai urutan yang ditentukan |
| **Pre-kondisi** | Ada 3 banner dengan order berbeda |
| **Test Steps** | 1. Set banner A order=1, B order=2, C order=3<br>2. Cek homepage |
| **Input Data** | - Order: 1, 2, 3 |
| **Expected Result** | ✅ Banner tampil sesuai order di homepage |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

### Test Case 7.7: Validasi Upload Banner Invalid Format
| ID | TC-ADM-BAN-007 |
|----|----------------|
| **Deskripsi** | Validasi file format saat upload banner |
| **Pre-kondisi** | - |
| **Test Steps** | 1. Coba upload file PDF/DOCX |
| **Input Data** | - Image: (file PDF) |
| **Expected Result** | ❌ Upload gagal<br>✅ Muncul error: "File harus berupa gambar" |
| **Actual Result** | _(Isi setelah testing)_ |
| **Status** | ⬜ Pass ⬜ Fail |

---

## 12. Role-Based Access Control (Superadmin vs Admin)

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
- _[Tulis observasi umum tentang admin panel]_
- _[Rekomendasi perbaikan]_
