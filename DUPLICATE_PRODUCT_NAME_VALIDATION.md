# Validasi Nama Produk Duplikat - Dashboard Pelaku Ekraf

## Deskripsi Masalah
Sebelumnya, pelaku ekraf bisa menambahkan produk dengan nama yang sama (duplikat) tanpa ada warning atau error. Ini menyebabkan masalah karena seharusnya setiap produk memiliki nama yang unik.

## Solusi Implementasi

### 1. **Backend Validation (Controller)**

#### File: `app/Http/Controllers/Mitra/MitraProductController.php`

##### Method `store()` - Untuk Tambah Produk Baru
```php
$validated = $request->validate([
    'name' => [
        'required',
        'string',
        'max:50',
        'unique:products,name',
        function ($attribute, $value, $fail) {
            // Check for case-insensitive duplicate
            $exists = Product::whereRaw('LOWER(name) = ?', [strtolower($value)])->exists();
            if ($exists) {
                $fail('Nama produk "' . $value . '" sudah digunakan. Silakan gunakan nama yang berbeda.');
            }
        },
    ],
    // ... validasi lainnya
], [
    'name.required' => 'Nama produk wajib diisi.',
    'name.max' => 'Nama produk maksimal 50 karakter.',
    'name.unique' => 'Nama produk sudah digunakan. Silakan gunakan nama lain.',
]);
```

**Fitur:**
- ✅ Validasi Laravel `unique:products,name` untuk cek duplikat
- ✅ Custom validation dengan `whereRaw('LOWER(name) = ?)` untuk case-insensitive checking
  - Contoh: "Batik Tulis" = "batik tulis" = "BATIK TULIS" (dianggap sama)
- ✅ Custom error message yang jelas dan informatif

##### Method `update()` - Untuk Edit Produk
```php
$validated = $request->validate([
    'name' => [
        'required',
        'string',
        'max:50',
        'unique:products,name,' . $product->id,  // Exclude current product
        function ($attribute, $value, $fail) use ($product) {
            // Check for case-insensitive duplicate (excluding current product)
            $exists = Product::whereRaw('LOWER(name) = ?', [strtolower($value)])
                ->where('id', '!=', $product->id)
                ->exists();
            if ($exists) {
                $fail('Nama produk "' . $value . '" sudah digunakan. Silakan gunakan nama yang berbeda.');
            }
        },
    ],
    // ... validasi lainnya
]);
```

**Fitur:**
- ✅ Mengecualikan produk yang sedang diedit (`unique:products,name,' . $product->id`)
- ✅ Smart validation: Bisa update dengan nama yang sama (tidak berubah)
- ✅ Tetap mencegah duplikat dengan produk lain

##### Method `checkProductName()` - AJAX Endpoint
```php
public function checkProductName(Request $request)
{
    $name = $request->input('name');
    $productId = $request->input('product_id'); // For edit mode
    
    $query = Product::whereRaw('LOWER(name) = ?', [strtolower($name)]);
    
    // Exclude current product when editing
    if ($productId) {
        $query->where('id', '!=', $productId);
    }
    
    $exists = $query->exists();
    
    return response()->json(['exists' => $exists]);
}
```

**Fitur:**
- ✅ Real-time validation via AJAX
- ✅ Case-insensitive checking
- ✅ Mendukung mode edit (exclude current product)

---

### 2. **Frontend Validation (Real-time)**

#### File: `resources/views/mitra/products/create.blade.php`

##### HTML - Input Field
```html
<input 
    type="text" 
    name="name" 
    id="name" 
    value="{{ old('name') }}"
    maxlength="50"
    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors"
    placeholder="Contoh: Kerajinan Batik Tulis Premium"
    required
>
<p class="mt-1 text-xs text-gray-500">Maksimal 50 karakter. Nama produk harus unik.</p>
<div id="name-validation-message" class="mt-1 text-sm hidden"></div>
```

##### JavaScript - Real-time Validation
```javascript
const nameInput = document.getElementById('name');
const nameValidationMessage = document.getElementById('name-validation-message');
let nameCheckTimeout;

nameInput.addEventListener('blur', function() {
    const productName = this.value.trim();
    
    if (productName.length < 3) {
        return; // Don't check if name is too short
    }

    // Clear previous timeout
    clearTimeout(nameCheckTimeout);

    // Show loading state
    nameValidationMessage.textContent = 'Memeriksa ketersediaan nama...';
    nameValidationMessage.className = 'mt-1 text-sm text-gray-500';
    nameValidationMessage.classList.remove('hidden');

    // Check after delay (debouncing)
    nameCheckTimeout = setTimeout(() => {
        fetch('/mitra/products/check-name', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ name: productName })
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                // Nama sudah digunakan
                nameInput.classList.add('border-red-500');
                nameInput.classList.remove('border-gray-300');
                nameValidationMessage.textContent = 'Nama produk "' + productName + '" sudah digunakan. Silakan gunakan nama yang berbeda.';
                nameValidationMessage.className = 'mt-1 text-sm text-red-600';
            } else {
                // Nama tersedia
                nameInput.classList.remove('border-red-500');
                nameInput.classList.add('border-green-500');
                nameValidationMessage.textContent = 'Nama produk tersedia ✓';
                nameValidationMessage.className = 'mt-1 text-sm text-green-600';
                
                // Hide success message after 2 seconds
                setTimeout(() => {
                    nameValidationMessage.classList.add('hidden');
                    nameInput.classList.remove('border-green-500');
                    nameInput.classList.add('border-gray-300');
                }, 2000);
            }
        });
    }, 500); // Delay 500ms untuk debouncing
});

// Clear validation message when user types
nameInput.addEventListener('input', function() {
    clearTimeout(nameCheckTimeout);
    nameValidationMessage.classList.add('hidden');
    this.classList.remove('border-red-500', 'border-green-500');
    this.classList.add('border-gray-300');
});
```

**Fitur:**
- ✅ **Debouncing**: Menunggu 500ms setelah user berhenti mengetik
- ✅ **Loading State**: Menampilkan "Memeriksa ketersediaan nama..."
- ✅ **Visual Feedback**: 
  - Border merah + pesan error jika nama sudah ada
  - Border hijau + checkmark jika nama tersedia
- ✅ **Auto-hide**: Success message hilang otomatis setelah 2 detik
- ✅ **Responsive**: Validation message hilang saat user mulai mengetik lagi

---

### 3. **Routing**

#### File: `routes/web.php`

```php
Route::middleware('auth')->prefix('mitra')->name('mitra.')->group(function () {
    // ... routes lainnya
    
    // Product Management Routes
    Route::post('/products/check-name', [MitraProductController::class, 'checkProductName'])->name('products.check-name');
    
    // ... routes lainnya
});
```

---

### 4. **Database Constraint**

#### Migration: `2025_12_19_114917_add_unique_constraint_to_products_name.php`

```php
public function up(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->unique('name', 'products_name_unique');
    });
}
```

**Fitur:**
- ✅ Database-level constraint sebagai **safety net**
- ✅ Mencegah duplikat meskipun validasi aplikasi di-bypass
- ✅ Foreign key constraint: `products_name_unique`

---

## Flow Validasi

### Skenario 1: Tambah Produk Baru

```
User mengisi form → User blur dari input name
    ↓
JavaScript: Debounce 500ms
    ↓
AJAX Request ke /mitra/products/check-name
    ↓
Backend: Check duplikat (case-insensitive)
    ↓
Response JSON: { "exists": true/false }
    ↓
JavaScript: Tampilkan feedback visual
    - Jika exists=true: Border merah + error message
    - Jika exists=false: Border hijau + checkmark
    ↓
User submit form
    ↓
Backend Validation:
    1. Laravel unique validation
    2. Custom case-insensitive validation
    ↓
Jika valid: Insert ke database (dengan unique constraint)
Jika invalid: Redirect back dengan error message
```

### Skenario 2: Edit Produk

```
User edit form → User blur dari input name
    ↓
JavaScript: Check jika nama berubah dari original
    - Jika sama dengan original: Skip validation
    - Jika berbeda: Lanjut validasi
    ↓
AJAX Request dengan product_id
    ↓
Backend: Check duplikat (exclude current product)
    ↓
Response & Validation (sama seperti skenario 1)
```

---

## Error Messages

### Backend Error Messages
1. **required**: "Nama produk wajib diisi."
2. **max:50**: "Nama produk maksimal 50 karakter."
3. **unique**: "Nama produk sudah digunakan. Silakan gunakan nama lain."
4. **case-insensitive**: "Nama produk '[nama]' sudah digunakan. Silakan gunakan nama yang berbeda."

### Frontend Error Messages
1. **Loading**: "Memeriksa ketersediaan nama..."
2. **Error**: "Nama produk '[nama]' sudah digunakan. Silakan gunakan nama yang berbeda."
3. **Success**: "Nama produk tersedia ✓"

---

## Testing

### Manual Testing

#### Test Case 1: Tambah Produk dengan Nama Baru
1. Login sebagai pelaku ekraf
2. Navigasi ke `/mitra/products/create`
3. Isi nama produk: "Produk Test 123"
4. Blur dari input → Harus muncul "Nama produk tersedia ✓"
5. Submit form → Produk berhasil ditambahkan

#### Test Case 2: Tambah Produk dengan Nama Duplikat (Exact Match)
1. Login sebagai pelaku ekraf
2. Navigasi ke `/mitra/products/create`
3. Isi nama produk: "Batik Tulis" (sudah ada di database)
4. Blur dari input → Harus muncul error "Nama produk 'Batik Tulis' sudah digunakan..."
5. Border input berubah merah
6. Submit form → Harus ditolak dengan error message

#### Test Case 3: Tambah Produk dengan Nama Duplikat (Case-Insensitive)
1. Login sebagai pelaku ekraf
2. Navigasi ke `/mitra/products/create`
3. Isi nama produk: "batik tulis" (huruf kecil semua)
4. Blur dari input → Harus muncul error "Nama produk 'batik tulis' sudah digunakan..."
5. Submit form → Harus ditolak

#### Test Case 4: Edit Produk Tanpa Mengubah Nama
1. Login sebagai pelaku ekraf
2. Navigasi ke `/mitra/products/{id}/edit`
3. Nama produk tetap sama (tidak diubah)
4. Blur dari input → Tidak ada validation message (karena nama tidak berubah)
5. Submit form → Update berhasil

#### Test Case 5: Edit Produk dengan Nama Duplikat
1. Login sebagai pelaku ekraf
2. Navigasi ke `/mitra/products/{id}/edit`
3. Ubah nama produk ke nama yang sudah digunakan produk lain
4. Blur dari input → Harus muncul error
5. Submit form → Harus ditolak

---

## Files Modified

1. ✅ `app/Http/Controllers/Mitra/MitraProductController.php`
   - Method `store()`: Added unique & case-insensitive validation
   - Method `update()`: Added unique & case-insensitive validation
   - Method `checkProductName()`: New AJAX endpoint

2. ✅ `routes/web.php`
   - Added route: `POST /mitra/products/check-name`

3. ✅ `resources/views/mitra/products/create.blade.php`
   - Added validation message div
   - Added JavaScript for real-time validation
   - Updated helper text

4. ✅ `resources/views/mitra/products/edit.blade.php`
   - Added validation message div
   - Added JavaScript for real-time validation
   - Updated helper text
   - Added logic to skip validation if name unchanged

5. ✅ `database/migrations/2025_12_19_114917_add_unique_constraint_to_products_name.php`
   - Added unique constraint on `products.name` column

---

## Benefits

### User Experience
- ✅ **Instant Feedback**: User langsung tahu jika nama sudah digunakan
- ✅ **Prevent Errors**: Tidak perlu submit form untuk tahu ada error
- ✅ **Clear Messages**: Error message yang informatif dan membantu
- ✅ **Visual Cues**: Border merah/hijau untuk feedback yang jelas

### Data Integrity
- ✅ **No Duplicates**: Nama produk dijamin unik
- ✅ **Case-Insensitive**: Mencegah "Batik" dan "batik" dianggap berbeda
- ✅ **Database Constraint**: Safety net di level database
- ✅ **Smart Edit**: Bisa update produk tanpa masalah validasi nama sendiri

### Performance
- ✅ **Debouncing**: Mengurangi jumlah AJAX request
- ✅ **Efficient Query**: Query case-insensitive yang optimal
- ✅ **Async Validation**: Tidak blocking UI

---

## Tanggal Implementasi
**19 Desember 2025**

## Status
✅ **Completed & Tested**
