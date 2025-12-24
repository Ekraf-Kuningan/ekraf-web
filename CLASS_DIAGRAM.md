# Class Diagram Sistem Informasi Ekonomi Kreatif (Ekraf Web)

Berikut adalah **Class Diagram** yang disusun berdasarkan analisis struktur kode (`app/Models`) pada proyek Ekraf Web. Diagram ini menggambarkan entitas utama, atribut, dan relasi antar kelas dalam sistem.

## Diagram (Mermaid)

```mermaid
classDiagram
    %% User Management System
    class User {
        +int id
        +string name
        +string email
        +string password
        +int level_id
        +string phone_number
        +string alamat
        +string nik
        +string nib
        +hasOne(PelakuEkraf)
        +hasMany(Product)
        +belongsTo(Level)
    }

    class Level {
        +int id
        +string name
        +hasMany(User)
    }

    class PelakuEkraf {
        +int id
        +int user_id
        +string business_name
        +int sub_sektor_id
        +string business_status
        +string description
        +belongsTo(User)
        +belongsTo(SubSektor)
    }

    %% Master Data
    class SubSektor {
        +int id
        +string title
        +string slug
        +string image
        +hasMany(PelakuEkraf)
        +hasMany(Product)
        +hasMany(Katalog)
        +hasMany(BusinessCategory)
    }

    class BusinessCategory {
        +int id
        +string name
        +int sub_sector_id
        +belongsTo(SubSektor)
        +hasMany(Product)
    }

    %% Product & Catalog System
    class Product {
        +string id (PK: PEK001)
        +string name
        +double price
        +int stock
        +int user_id
        +int sub_sektor_id
        +int business_category_id
        +string status
        +belongsTo(User)
        +belongsTo(SubSektor)
        +belongsTo(BusinessCategory)
        +belongsToMany(Katalog)
    }

    class Katalog {
        +int id
        +string title
        +int sub_sector_id
        +string image
        +belongsTo(SubSektor)
        +belongsToMany(Product)
        +hasMany(KatalogView)
    }

    class KatalogView {
        +int id
        +int katalog_id
        +datetime viewed_at
        +belongsTo(Katalog)
    }

    class ProductView {
        +int id
        +string product_id
        +datetime viewed_at
        +belongsTo(Product)
    }

    %% Content Management System (CMS)
    class Artikel {
        +int id
        +string title
        +string slug
        +text content
        +int author_id
        +int artikel_kategori_id
        +bool is_featured
        +belongsTo(Author)
        +belongsTo(ArtikelKategori)
        +hasMany(Banner)
    }

    class ArtikelKategori {
        +int id
        +string title
        +string slug
        +hasMany(Artikel)
    }

    class Author {
        +int id
        +string name
        +string bio
        +hasMany(Artikel)
    }

    class Testimonial {
        +int id
        +int user_id
        +string message
        +int rating
        +string type
        +string status
        +belongsTo(User)
    }

    %% Relationships
    User "1" --> "1" Level : belongsTo
    User "1" --> "1" PelakuEkraf : hasOne (Profile Bisnis)
    PelakuEkraf "1" --> "1" SubSektor : belongsTo

    SubSektor "1" --> "*" BusinessCategory : hasMany
    
    Product "*" --> "1" User : belongsTo (Owner)
    Product "*" --> "1" SubSektor : belongsTo
    Product "*" --> "1" BusinessCategory : belongsTo
    
    Katalog "*" --> "1" SubSektor : belongsTo
    Katalog "*" -- "*" Product : belongsToMany (Pivot: catalog_product)

    Artikel "*" --> "1" Author : belongsTo
    Artikel "*" --> "1" ArtikelKategori : belongsTo
    
    Testimonial "*" --> "1" User : belongsTo
    
    Katalog "1" --> "*" KatalogView : hasMany
    Product "1" --> "*" ProductView : hasMany
```

---

## Penjelasan dan Argumen Desain

Class Diagram di atas merepresentasikan arsitektur sistem yang **modular** dan **terstruktur dengan baik**, memisahkan domain Bisnis (Ekraf) dengan domain Konten (CMS). Berikut adalah argumen kuat mengenai desain ini:

### 1. Pemisahan Akun User dan Profil Bisnis (Separation of Concerns)
**Relasi**: `User (1) --- (1) PelakuEkraf`
*   **Argumen**: Sistem menggunakan pemisahan yang jelas antara data otentikasi (`User`: email, password, NIK) dan data profil usaha (`PelakuEkraf`: nama bisnis, deskripsi).
*   **Keuntungan**: Hal ini memungkinkan fleksibilitas jika satu user di masa depan diperbolehkan memiliki banyak unit usaha (walaupun saat ini 1-to-1), serta menjaga tabel User tetap ramping dan fokus pada keamanan/akses login saja.

### 2. Hierarki Kategori Bertingkat (Categorization Hierarchy)
**Relasi**: `SubSektor (1) --- (*) BusinessCategory --- (*) Product`
*   **Argumen**: Produk tidak hanya dikategorikan berdasarkan **Sub Sektor** (17 sub sektor ekraf resmi), tetapi juga diperdetail dengan **Business Category** (kategori spesifik bisnis).
*   **Keuntungan**: Ini memberikan granularitas data yang lebih baik. Admin bisa membuat laporan statistik level tinggi (per Sub Sektor) maupun level mendetail (per Kategori Bisnis), memudahkan filtering bagi pengunjung website.

### 3. Sistem Katalog yang Fleksibel (Collection-based Catalog)
**Relasi**: `Katalog (*) --- (*) Product` (Many-to-Many)
*   **Argumen**: Hubungan *Many-to-Many* antara Katalog dan Produk adalah keputusan desain yang sangat kuat. Artinya, satu produk (misalnya: "Tas Rajut") bisa masuk ke dalam beberapa katalog sekaligus (misalnya: "Katalog Ramadhan" dan "Katalog Produk Unggulan 2025").
*   **Keuntungan**: Pemasaran menjadi jauh lebih dinamis. Admin bisa membuat kurasi produk tematik tanpa membatasi produk tersebut hanya terikat pada satu tempat.

### 4. Manajemen Konten yang Terdedikasi
**Relasi**: `Artikel --- Author` dan `Artikel --- ArtikelKategori`
*   **Argumen**: Sistem memiliki modul CMS (Content Management System) sendiri yang terpisah dari modul E-Commerce. Artikel memiliki `Author` sendiri yang terpisah dari `User` biasa.
*   **Keuntungan**: Memungkinkan pengelolaan berita/blog yang profesional dengan atribusi penulis yang jelas, mendukung SEO dan edukasi pasar tanpa mengganggu logika bisnis utama.

### 5. Tracking dan Analitik (Data-Driven)
**Entitas**: `ProductView`, `KatalogView`
*   **Argumen**: Keberadaan tabel khusus untuk mencatat *views* (dilihat kapan dan berapa kali) menunjukkan sistem ini berorientasi pada data (*data-driven*).
*   **Keuntungan**: Pemilik produk (Pelaku Ekraf) bisa mendapatkan insight nyata mengenai performa produk mereka, bukan sekadar etalase statis.
