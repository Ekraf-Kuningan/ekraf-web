# Multi-Step Registration Flow - EKRAF KUNINGAN

## 📋 Overview
Sistem registrasi pelaku EKRAF telah diubah menjadi 3 tahap untuk meningkatkan keamanan dan pengalaman pengguna yang lebih baik.

## 🔄 Alur Registrasi

### **Tahap 1: Pendaftaran Akun Dasar**
**URL:** `/register-pelakuekraf`
**Method:** GET & POST
**View:** `resources/views/auth/register-step1.blade.php`
**Controller:** `MultiStepRegisterController@showStep1` & `storeStep1`

**Fields yang dibutuhkan:**
- Username (unique)
- Email (unique)
- Password (minimum 8 karakter)
- Konfirmasi Password

**Proses:**
1. User mengisi data akun dasar
2. Real-time validation untuk username dan email availability
3. Data disimpan ke `temporary_users` table dengan:
   - `is_verified = false`
   - `profile_completed = false`
4. Email verifikasi dikirim ke user
5. User dialihkan ke Step 2

---

### **Tahap 2: Verifikasi Email**
**URL:** `/verify-email/{token}`
**View:** `resources/views/auth/register-step2.blade.php` (informasi) 
**Controller:** `MultiStepRegisterController@verifyEmail`

**Proses:**
1. User melihat halaman informasi untuk cek email
2. User membuka email dan klik link verifikasi
3. Token divalidasi (maksimal 10 menit dari pengiriman)
4. Status `is_verified` diubah menjadi `true`
5. Token expiry diperpanjang 24 jam untuk lengkapi profil
6. User otomatis dialihkan ke Step 3

**Features:**
- Resend verification email (dengan cooldown 60 detik)
- Token expiry validation
- Clear instructions

---

### **Tahap 3: Lengkapi Profil**
**URL:** `/register-pelakuekraf/complete-profile/{token}`
**Method:** GET & POST
**View:** `resources/views/auth/register-step3.blade.php`
**Controller:** `MultiStepRegisterController@showStep3` & `storeStep3`

**Fields yang dibutuhkan:**
- Nama Lengkap (unique)
- Nomor Telepon (10-13 digit)
- NIK (16 digit, unique)
- NIB (13 digit, unique) - **OPSIONAL**
- Alamat (textarea)
- Jenis Kelamin (male/female)
- Foto Profil (optional, max 2MB, jpg/jpeg/png)
- Nama Usaha (unique)
- Status Usaha (Baru/Sudah Lama)
- Sub Sektor (dropdown dari database)

**Proses:**
1. User mengisi data profil lengkap
2. Real-time validation untuk NIK, NIB, nama, dan nama usaha
3. Upload foto profil ke Cloudinary (jika ada)
4. Data profil disimpan ke `temporary_users`
5. Status `profile_completed` diubah menjadi `true`
6. Data dipindahkan dari `temporary_users` ke `users` table
7. Data bisnis disimpan ke `mitras` table
8. `temporary_users` record dihapus
9. User dialihkan ke halaman sukses
10. User dapat login

---

## 🗂️ Database Structure

### Table: `temporary_users`
**Kolom baru yang ditambahkan:**
- `is_verified` (boolean, default: false) - Status verifikasi email
- `profile_completed` (boolean, default: false) - Status kelengkapan profil

**Kolom yang dibuat nullable:**
- `name`, `phone_number`, `nik`, `nib`, `alamat`, `gender`, `image`
- `business_name`, `business_status`, `sub_sektor_id`

**Alasan:** Data ini hanya diisi di Step 3 setelah email terverifikasi.

---

## 📁 File Structure

```
app/Http/Controllers/Auth/
├── MultiStepRegisterController.php (NEW - Main controller)
└── CustomRegisterController.php (OLD - Bisa dihapus atau sebagai backup)

resources/views/auth/
├── register-step1.blade.php (NEW - Basic registration)
├── register-step2.blade.php (NEW - Email verification info)
├── register-step3.blade.php (NEW - Complete profile)
├── register.blade.php (OLD - Bisa dihapus atau sebagai backup)
├── verification-success.blade.php (Existing - Success page)
└── verification-failed.blade.php (Existing - Failed page)

database/migrations/
└── 2025_12_15_144207_update_temporary_users_for_multi_step_registration.php (NEW)

routes/
├── web.php (Updated - Multi-step registration routes)
├── auth.php (Updated - Email verification route)
└── api.php (Updated - Availability check endpoints)
```

---

## 🔌 API Endpoints

### Check Availability - Step 1
**POST** `/api/check-availability-step1`

**Parameters:**
```json
{
  "field": "username|email",
  "value": "string"
}
```

**Response:**
```json
{
  "available": true|false,
  "message": "Username tersedia" | "Username sudah digunakan"
}
```

### Check Availability - Step 3
**POST** `/api/check-availability-step3`

**Parameters:**
```json
{
  "field": "name|nik|nib|business_name",
  "value": "string",
  "temp_user_id": "integer (optional)"
}
```

**Response:**
```json
{
  "available": true|false,
  "message": "NIK tersedia" | "NIK sudah terdaftar"
}
```

### Resend Verification
**POST** `/resend-verification`

**Parameters:**
```json
{
  "email": "user@example.com"
}
```

**Response:**
```json
{
  "success": true|false,
  "message": "Email verifikasi berhasil dikirim ulang."
}
```

---

## 🎨 Features

### Step 1 (Basic Registration)
✅ Real-time username & email availability check
✅ Password strength validation
✅ Password confirmation matching
✅ Toggle password visibility
✅ Responsive design dengan gradient background
✅ Loading states pada submit button

### Step 2 (Email Verification)
✅ Clear instructions untuk user
✅ Resend email dengan cooldown 60 detik
✅ Email display dengan styling yang jelas
✅ Animated verify icon dengan pulse effect
✅ Step indicator visual

### Step 3 (Complete Profile)
✅ Read-only display username & email dari Step 1
✅ Real-time validation untuk NIK, NIB, nama, nama usaha
✅ Image upload dengan preview
✅ File size validation (max 2MB)
✅ Input formatting (numbers only untuk NIK, NIB)
✅ Character counters
✅ Grid layout responsive
✅ Submit button dengan loading state

---

## 🔒 Security Features

1. **Token-based verification**: Setiap tahap menggunakan unique token
2. **Time-limited tokens**: 
   - Step 1 → Step 2: 10 menit
   - Step 2 → Step 3: 24 jam
3. **Status checks**: Setiap tahap memvalidasi status sebelumnya
4. **CSRF protection**: Semua form dilindungi CSRF token
5. **Input validation**: Server-side validation untuk semua input
6. **Unique constraints**: Username, email, NIK, NIB, nama usaha
7. **Password hashing**: Bcrypt encryption

---

## 📊 User Flow Diagram

```
┌─────────────────────┐
│   Step 1: Register  │
│  (Username, Email,  │
│     Password)       │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ Email Verifikasi    │
│    Dikirim          │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│   Step 2: Waiting   │
│  (Cek Email, Klik   │
│      Link)          │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│  Email Terverifikasi│
│  is_verified = true │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│ Step 3: Complete    │
│     Profile         │
│ (Nama, NIK, NIB,    │
│  Usaha, dll)        │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│  Data Pindah ke     │
│   users & mitras    │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────┐
│  Registration Done! │
│   User Can Login    │
└─────────────────────┘
```

---

## 🧪 Testing Checklist

### Manual Testing:

**Step 1 - Basic Registration:**
- [ ] Form validation (required fields)
- [ ] Username availability check
- [ ] Email availability check
- [ ] Password minimum length (8 chars)
- [ ] Password confirmation matching
- [ ] Toggle password visibility
- [ ] Submit dan email terkirim
- [ ] Redirect ke Step 2

**Step 2 - Email Verification:**
- [ ] Email diterima di inbox
- [ ] Link verifikasi valid
- [ ] Token expiry (coba setelah 10 menit)
- [ ] Resend email functionality
- [ ] Cooldown 60 detik berfungsi
- [ ] Redirect ke Step 3 setelah verify

**Step 3 - Complete Profile:**
- [ ] Username & email readonly ditampilkan
- [ ] All form validations
- [ ] NIK format (16 digit)
- [ ] NIB format (13 digit)
- [ ] Phone number format (10-13 digit)
- [ ] Uniqueness checks untuk NIK, NIB, nama, business_name
- [ ] Image upload & preview
- [ ] File size validation (max 2MB)
- [ ] Submit dan data masuk ke users & mitras
- [ ] temporary_users record terhapus
- [ ] Redirect ke success page

**Error Handling:**
- [ ] Invalid token
- [ ] Expired token
- [ ] Duplicate submission
- [ ] Network errors
- [ ] Upload errors

---

## 🚀 Deployment Notes

1. **Run migration:**
   ```bash
   php artisan migrate
   ```

2. **Clear cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

3. **Test email configuration:**
   - Pastikan email SMTP sudah dikonfigurasi di `.env`
   - Test kirim email verifikasi

4. **Cloudinary configuration:**
   - Pastikan Cloudinary credentials di `.env`
   - Test upload image

---

## 📝 Notes

- **Backward Compatibility**: File `CustomRegisterController.php` dan `register.blade.php` lama masih ada sebagai backup
- **Email Templates**: Gunakan template yang sudah ada di `app/Notifications/VerifyEmailVerification.php`
- **Token Security**: Token di-generate menggunakan `Str::random(65)` untuk keamanan maksimal
- **Auto-cleanup**: Temporary users dengan token expired bisa dibersihkan dengan scheduled job (optional)

---

## 🐛 Troubleshooting

### Email tidak terkirim
- Check SMTP configuration di `.env`
- Check log di `storage/logs/laravel.log`
- Test dengan `php artisan tinker` dan `Mail::raw()`

### Token invalid/expired
- Check `verificationTokenExpiry` di database
- Pastikan timezone server sesuai
- User bisa resend verification

### Image upload gagal
- Check Cloudinary credentials
- Check file size (max 2MB)
- Check file format (jpg, jpeg, png)
- Check upload permissions

### Validation errors
- Check unique constraints di database
- Check validation rules di controller
- Check client-side validation

---

**Last Updated:** December 15, 2025
**Version:** 1.0.0
**Developer:** Rifky
