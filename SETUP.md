# Ekraf Web - Setup Guide

## Setup untuk Device Baru

Ketika clone project ini ke device baru, ikuti langkah-langkah berikut:

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Setup Database
```bash
php artisan migrate
```

### 4. Setup Storage & Avatar
```bash
php artisan app:setup-storage
```

Command ini akan:
- Membuat folder storage yang diperlukan (avatars, articles, banners, catalogs)
- Membuat symlink dari public/storage ke storage/app/public
- Copy default avatar image

### 5. Jalankan Server
```bash
php artisan serve
```

## Sistem Role & Access Control

### Level User:
1. **SuperAdmin (id_level = 1)**
   - Akses: `/superadmin` 
   - Fitur: User Management, All Resources
   - Panel: SuperAdmin Panel (Red Theme)

2. **Admin (id_level = 2)**
   - Akses: `/admin`
   - Fitur: Content Management (Articles, Banners, Catalogs, etc.)
   - Panel: Admin Panel (Amber Theme)

3. **Member (id_level = 3)**
   - Akses: Frontend only
   - Fitur: Browse content, view articles

### URL Access:
- **Frontend**: `http://localhost:8000`
- **SuperAdmin**: `http://localhost:8000/superadmin`
- **Admin**: `http://localhost:8000/admin`
- **Login**: `http://localhost:8000/login`

### Auto Redirect setelah Login:
- SuperAdmin → `/superadmin`
- Admin → `/admin`
- Member → `/` (homepage)

## Troubleshooting Avatar

Jika avatar tidak muncul:

1. **Pastikan storage link sudah dibuat:**
   ```bash
   php artisan storage:link
   ```

2. **Jalankan setup storage:**
   ```bash
   php artisan app:setup-storage
   ```

3. **Cek permission folder storage** (Linux/Mac):
   ```bash
   chmod -R 755 storage/
   chmod -R 755 public/
   ```

## Struktur Folder Storage

```
storage/app/public/
├── avatars/        # Avatar author
├── articles/       # Thumbnail artikel
├── banners/        # Image banner
├── catalogs/       # Image katalog produk
└── default-avatar.png  # Default avatar fallback
```

## Panel Differences

### SuperAdmin Panel Features:
- User Management (CRUD users & roles)
- System Settings
- All admin features
- Red color theme

### Admin Panel Features:  
- Content Management
- Articles, Authors, Banners
- Catalogs, Categories
- Amber color theme

## Upload File Avatar

File avatar akan tersimpan di `storage/app/public/avatars/` dan dapat diakses via URL:
`/storage/avatars/filename.jpg`

Jika file tidak ditemukan, sistem akan menggunakan fallback ke `assets/img/User.png`
