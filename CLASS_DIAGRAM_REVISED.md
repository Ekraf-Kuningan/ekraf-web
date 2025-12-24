# Class Diagram Revisi - Ekraf Web

Dokumen ini berisi **Class Diagram** yang telah disesuaikan dengan implementasi kode aktual (`Project ekraf-web`) namun tetap mempertahankan struktur logis yang mudah dipahami. Diagram ini dirancang untuk **memperkuat argumen** dalam laporan kerja praktik/skripsi Anda.

## Hasil Analisis & Perbaikan dari Diagram Awal
Berdasarkan diagram yang Anda upload dan struktur kode yang ada, berikut adalah penyempurnaan yang dilakukan:

1.  **Penggabungan Aktor (Single Table Inheritance)**:
    *   **Diagram Lama**: Memisahkan `Admin` dan `Pengguna` sebaga class berbeda.
    *   **Kode Aktual**: Menggunakan satu class `User` dengan atribut `level_id`.
    *   **Argumen Kuat**: Efisiensi database dan sentralisasi otentikasi. Tidak perlu tabel terpisah untuk login; peran (Role) hanya dibedakan oleh flag/level.

2.  **Pemisahan Entitas Bisnis (Normalization)**:
    *   **Diagram Lama**: Atribut usaha mungkin tercampur di Pengguna.
    *   **Kode Aktual**: Memisahkan `User` (Data Login) dan `PelakuEkraf` (Data Bisnis).
    *   **Argumen Kuat**: *Separation of Concerns*. Akun pengguna tetap aman dan ringan, sementara profil bisnis yang kompleks disimpan terpisah. Profil bisnis bisa dihapus tanpa menghapus akun user.

3.  **Relasi Katalog & Produk (Many-to-Many)**:
    *   **Diagram Lama**: Katalog mungkin hanya menampung produk (1-to-many).
    *   **Kode Aktual**: Menggunakan tabel pivot `catalog_product`.
    *   **Argumen Kuat**: Fleksibilitas Pemasaran. Satu produk (misal: "Batik Tulis") bisa masuk ke "Katalog Batik" DAN "Katalog Promo Lebaran" secara bersamaan tanpa duplikasi data produk.

## Diagram Class (Mermaid)

```mermaid
classDiagram
    %% Core Authentication
    class User {
        +int id
        +string name
        +string email
        +string password
        +string username
        +string gender
        +string phone_number
        +string nik
        +string nib
        +string alamat
        +int level_id
        +string image
        +string cloudinary_id
        +json cloudinary_meta
        +string resetPasswordToken
        +datetime resetPasswordTokenExpiry
        +datetime verifiedAt
        +datetime email_verified_at
        +login()
        +register()
        +resetPassword()
        +isSuperAdmin()
        +isAdmin()
        +hasAdminAccess()
    }

    %% Business Profile
    class PelakuEkraf {
        +int id
        +int user_id
        +string business_name
        +string business_status
        +text description
        +int sub_sektor_id
        +datetime created_at
        +datetime updated_at
        +updateProfile()
        +getStatistik()
    }

    %% Master Data & Categorization
    class SubSektor {
        +int id
        +string title
        +string slug
        +text description
        +string image
        +datetime created_at
        +datetime updated_at
        +listKatalog()
        +listProducts()
    }

    class BusinessCategory {
        +int id
        +string name
        +int sub_sector_id
        +text description
        +string image
    }

    %% E-Commerce Domain
    class Product {
        +string id (PK: CustomID)
        +string name
        +text description
        +decimal price
        +int stock
        +string image
        +string cloudinary_id
        +json cloudinary_meta
        +datetime uploaded_at
        +int user_id
        +int sub_sektor_id
        +int business_category_id
        +enum status (pending/approved/rejected/inactive)
        +generateCustomId()
        +getImageUrl()
        +approve()
        +reject()
    }

    class Katalog {
        +int id
        +int sub_sector_id
        +string title
        +string slug
        +string image
        +string image_url
        +string cloudinary_id
        +json cloudinary_meta
        +json image_meta
        +string product_name
        +decimal price
        +text content
        +string phone_number
        +string email
        +string instagram
        +string shopee
        +string tokopedia
        +string lazada
        +datetime created_at
        +datetime updated_at
        +addProduct()
        +removeProduct()
        +getViewCount()
    }

    %% Content Management (CMS)
    class Artikel {
        +int id
        +string title
        +string slug
        +string thumbnail
        +string cloudinary_id
        +json cloudinary_meta
        +json thumbnail_meta
        +text content
        +boolean is_featured
        +int author_id
        +int artikel_kategori_id
        +datetime created_at
        +datetime updated_at
        +publish()
        +setFeatured()
    }

    class ArtikelKategori {
        +int id
        +string title
        +string slug
        +string icon
        +text description
        +string color
    }

    class Author {
        +int id
        +string name
        +string username
        +string avatar
        +string cloudinary_id
        +json cloudinary_meta
        +json avatar_meta
        +text bio
        +datetime created_at
        +datetime updated_at
    }

    class Testimonial {
        +int id
        +int user_id
        +string name
        +string email
        +string business_name
        +text message
        +int rating
        +enum type (testimoni/saran)
        +enum status (pending/approved/rejected)
        +datetime created_at
        +datetime updated_at
        +approve()
        +reject()
    }

    %% Relationships
    User "1" --> "0..1" PelakuEkraf : hasOne (Profile)
    User "1" -- "*" Product : owns (Seller)
    User "1" -- "*" Testimonial : writes
    
    PelakuEkraf "*" --> "1" SubSektor : belongsTo
    
    SubSektor "1" *-- "*" BusinessCategory : contains
    
    Product "*" --> "1" User : belongsTo
    Product "*" --> "1" SubSektor : belongsTo
    Product "*" --> "0..1" BusinessCategory : belongsTo
    
    Katalog "*" --> "1" SubSektor : categorizedBy
    Katalog "*" -- "*" Product : contains (Many-to-Many via catalog_product)
    
    Artikel "*" --> "1" Author : writtenBy
    Artikel "*" --> "1" ArtikelKategori : belongsTo
    
    Testimonial "*" --> "0..1" User : belongsTo
```

## Penjelasan Argumen Desain (Untuk Bab Pembahasan)

### 1. Pola Active Record pada Entities
Diagram di atas menggunakan pola **Active Record** yang umum pada framework modern seperti Laravel (Eloquent ORM). Setiap kelas (User, Product, Katalog) merepresentasikan tabel dalam database sekaligus memiliki metode (behavior) untuk memanipulasi datanya sendiri (seperti `approve()`, `checkStock()`).
*   **Argumen**: Pendekatan ini mempercepat pengembangan dan memastikan bahwa logika bisnis data (seperti validasi stok) melekat erat pada datanya, mengurangi redundansi kode.

### 2. Normalisasi & Hierarki Kategori (Sub Sektor vs Business Category)
Dalam sistem ini, kategori tidak datar melainkan hierarkis. `SubSektor` (17 subsektor resmi) menjadi payung utama, di dalamnya terdapat `BusinessCategory` (misal: Kuliner -> Kopi, Kuliner -> Keripik).
*   **Argumen**: Desain ini mendukung skalabilitas data. Sistem bisa menangani ribuan jenis produk dengan tetap menjaga kerapian pengelompokan berdasarkan standar Ekonomi Kreatif nasional.

### 3. Fleksibilitas Katalog (Many-to-Many Relationship)
Hubungan antara `Katalog` dan `Product` adalah *Many-to-Many* (banyak-ke-banyak), bukan *One-to-Many*.
*   **Argumen**: Ini adalah fitur strategis untuk **Marketing**. Pelaku ekraf tidak perlu menginput ulang produk untuk membuat katalog berbeda (misalnya Katalog Natal vs Katalog Reguler). Satu objek produk yang sama bisa direferensikan di berbagai katalog, memastikan konsistensi harga dan stok di semua tempat.

### 4. Sistem Keamanan Berbasis Level (RBAC Sederhana)
Alih-alih membuat kelas `Admin` terpisah, sistem menggunakan atribut `level_id` pada kelas `User`.
*   **Argumen**: Menyederhanakan manajemen user. Jika suatu hari Pelaku Ekraf perlu diangkat menjadi Admin untuk sub-sektor tertentu, sistem hanya perlu mengubah nilai `level_id` tanpa perlu migrasi data antar tabel. Ini mempermudah maintenance jangka panjang.

### 5. Custom Primary Key pada Produk
Kelas `Product` memiliki metode `generateCustomId()`.
*   **Argumen**: Penggunaan ID yang "User Friendly" (misal: KUL001 untuk Kuliner) meningkatkan *usability* sistem dalam proses verifikasi manual dan komunikasi antara Admin dan Pelaku Ekraf, dibandingkan menggunakan Auto Increment ID (1, 2, 3) yang tidak bermakna.
