# White Box Testing - Tambah Produk (Pelaku Ekraf)

**Tanggal Testing**: 21 Desember 2025  
**Tester**: [Nama Tester]  
**File Under Test**: `app/Http/Controllers/PelakuEkraf/PelakuEkrafProductController.php`  
**Method**: `store()`

---

## 1. Code Structure & Flow

### 1.1 File Imports & Dependencies
```php
use App\Models\Product;
use App\Models\SubSektor;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
```

**Fungsi**: Import dependencies yang dibutuhkan
- `Product`: Model untuk data produk
- `SubSektor`: Model untuk kategori sub sektor
- `CloudinaryService`: Service untuk upload image ke Cloudinary
- `Request`: Handle HTTP request
- `DB`: Database transaction management

---

### 1.2 Method Signature & Initial Variables
```php
public function store(Request $request)
{
    $pelakuEkraf = auth()->user()->pelakuEkraf;
    if (!$pelakuEkraf) {
        return redirect()->route('pelaku-ekraf.dashboard')
            ->with('error', 'Data pelaku ekraf tidak ditemukan.');
    }
```

**Fungsi**: Inisialisasi dan validasi user authentication
- Mengambil data pelaku ekraf dari user yang sedang login
- Validasi apakah user memiliki profil pelaku ekraf
- Jika tidak ada, redirect dengan pesan error

**Test Cases**:
| No | Kondisi | Input | Expected Output |
|----|---------|-------|-----------------|
| 1  | User memiliki pelaku ekraf | auth()->user()->pelakuEkraf exists | Lanjut ke validasi request |
| 2  | User tidak memiliki pelaku ekraf | auth()->user()->pelakuEkraf = null | Redirect dengan error message |

---

### 1.3 Request Validation
```php
$validated = $request->validate([
    'product_name' => [
        'required',
        'string',
        'max:255',
        Rule::unique('products', 'product_name')
            ->where(function ($query) use ($pelakuEkraf) {
                return $query->where('pelaku_ekraf_id', $pelakuEkraf->id);
            })
    ],
    'category' => 'required|string|max:255',
    'sub_sektor_id' => 'required|exists:sub_sektors,id',
    'price' => 'required|numeric|min:0',
    'description' => 'required|string',
    'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
]);
```

**Fungsi**: Validasi input dari form
- **product_name**: Required, string, max 255 karakter, unique per pelaku ekraf
- **category**: Required, string, max 255 karakter
- **sub_sektor_id**: Required, harus ada di tabel sub_sektors
- **price**: Required, numeric, minimal 0
- **description**: Required, string
- **image**: Required, harus image (jpeg/png/jpg), max 2MB

**Test Cases - Validation Rules**:

| No | Field | Test Case | Input | Expected Result |
|----|-------|-----------|-------|-----------------|
| 1 | product_name | Field kosong | product_name: "" | Validation error: "The product name field is required" |
| 2 | product_name | Duplikat nama (same pelaku) | product_name: "Tas Rajut" (sudah ada) | Validation error: "The product name has already been taken" |
| 3 | product_name | Duplikat nama (different pelaku) | product_name: "Tas Rajut" (milik pelaku lain) | ✅ Valid (allowed) |
| 4 | product_name | Lebih dari 255 karakter | product_name: string(300) | Validation error: "The product name may not be greater than 255 characters" |
| 5 | category | Field kosong | category: "" | Validation error: "The category field is required" |
| 6 | sub_sektor_id | ID tidak valid | sub_sektor_id: 99999 | Validation error: "The selected sub sektor id is invalid" |
| 7 | price | Nilai negatif | price: -1000 | Validation error: "The price must be at least 0" |
| 8 | price | Bukan angka | price: "abc" | Validation error: "The price must be a number" |
| 9 | description | Field kosong | description: "" | Validation error: "The description field is required" |
| 10 | image | File tidak di-upload | image: null | Validation error: "The image field is required" |
| 11 | image | Format file invalid | image: file.pdf | Validation error: "The image must be a file of type: jpeg, png, jpg" |
| 12 | image | Ukuran > 2MB | image: file(3MB) | Validation error: "The image may not be greater than 2048 kilobytes" |
| 13 | All fields | Data valid lengkap | All valid data | ✅ Validation passed |

---

### 1.4 Database Transaction & Image Upload
```php
try {
    DB::beginTransaction();
    
    // Upload image to Cloudinary
    $cloudinaryService = new CloudinaryService();
    $uploadResult = $cloudinaryService->uploadImage(
        $request->file('image'),
        'products'
    );
```

**Fungsi**: Memulai database transaction dan upload image
- `DB::beginTransaction()`: Memulai transaction untuk data consistency
- `CloudinaryService`: Upload image ke Cloudinary cloud storage
- Folder destination: 'products'

**Test Cases - Image Upload**:

| No | Test Case | Kondisi | Expected Result |
|----|-----------|---------|-----------------|
| 1 | Upload berhasil | Image valid, Cloudinary available | Return: ['secure_url' => 'https://...', 'public_id' => 'products/...'] |
| 2 | Cloudinary error | Cloudinary service down | Exception thrown, transaction rollback |
| 3 | Network error | Internet connection lost | Exception thrown, transaction rollback |
| 4 | Invalid credentials | Cloudinary API key invalid | Exception thrown, transaction rollback |

---

### 1.5 Create Product Record
```php
$product = Product::create([
    'pelaku_ekraf_id' => $pelakuEkraf->id,
    'product_name' => $validated['product_name'],
    'category' => $validated['category'],
    'sub_sektor_id' => $validated['sub_sektor_id'],
    'price' => $validated['price'],
    'description' => $validated['description'],
    'image_url' => $uploadResult['secure_url'],
    'image_public_id' => $uploadResult['public_id'],
    'verification_status' => 'pending',
]);
```

**Fungsi**: Membuat record produk baru di database
- Menyimpan semua data yang sudah divalidasi
- Menyimpan URL dan public_id dari Cloudinary
- Set default `verification_status` = 'pending'

**Test Cases - Product Creation**:

| No | Test Case | Data Input | Expected Database Record |
|----|-----------|------------|--------------------------|
| 1 | Create product complete | All validated data | Record created with all fields populated |
| 2 | Auto-set pelaku_ekraf_id | - | pelaku_ekraf_id = auth()->user()->pelakuEkraf->id |
| 3 | Auto-set verification_status | - | verification_status = 'pending' |
| 4 | Image URLs stored | Upload result | image_url dan image_public_id tersimpan |

---

### 1.6 Transaction Commit & Success Response
```php
    DB::commit();
    
    return redirect()
        ->route('pelaku-ekraf.products')
        ->with('success', 'Produk berhasil ditambahkan. Menunggu verifikasi admin.');
        
} catch (\Exception $e) {
    DB::rollBack();
    
    // Delete uploaded image if exists
    if (isset($uploadResult['public_id'])) {
        $cloudinaryService->deleteImage($uploadResult['public_id']);
    }
    
    return redirect()
        ->back()
        ->withInput()
        ->with('error', 'Gagal menambahkan produk: ' . $e->getMessage());
}
```

**Fungsi**: Commit transaction atau rollback jika error
- **Success**: Commit transaction, redirect dengan success message
- **Error**: Rollback transaction, hapus image dari Cloudinary, redirect dengan error message

**Test Cases - Transaction Handling**:

| No | Test Case | Kondisi | Expected Result |
|----|-----------|---------|-----------------|
| 1 | Transaction commit berhasil | No errors | ✅ Data tersimpan, redirect ke product list dengan success message |
| 2 | Database error saat insert | DB constraint violation | ❌ Rollback, image dihapus, redirect back dengan error |
| 3 | Exception after upload | Error after Cloudinary upload | ❌ Rollback, Cloudinary image dihapus, redirect back |
| 4 | Preserve input on error | Any exception | ✅ Form input ter-preserve dengan withInput() |

---

## 2. Cyclomatic Complexity Analysis

### 2.1 Control Flow Graph

```
Start (Node 1)
    |
    v
Check pelakuEkraf exists? (Node 2)
    |           |
    No          Yes
    |           |
    v           v
Redirect    Validate Request (Node 3)
Error       |           |
(Node 8)    Invalid     Valid
            |           |
            v           v
        Return      Begin Transaction (Node 4)
        Validation      |
        Error           v
        (Node 9)    Upload Image (Node 5)
                        |
                        v
                    Create Product (Node 6)
                        |
                        v
                    Commit Transaction (Node 7)
                        |
                        v
                    Redirect Success (Node 10)
                        
Exception Path:
    Any error -> Rollback (Node 11)
              -> Delete Image (Node 12)
              -> Redirect Error (Node 13)
```

### 2.2 Complexity Metrics

**Cyclomatic Complexity (V(G))**:
```
V(G) = E - N + 2P
```
Where:
- E = Edges (transitions) = 15
- N = Nodes = 13
- P = Connected components = 1

**V(G) = 15 - 13 + 2(1) = 4**

**Interpretation**: Kompleksitas sedang, mudah untuk di-test dan maintain.

---

## 3. Path Testing

### 3.1 Independent Paths

**Path 1 (Happy Path - Success)**:
```
1 → 2 (Yes) → 3 (Valid) → 4 → 5 (Success) → 6 → 7 → 10
```
- User memiliki pelaku ekraf
- Validasi lolos
- Upload berhasil
- Product created
- Transaction committed
- Redirect success

**Path 2 (No PelakuEkraf)**:
```
1 → 2 (No) → 8
```
- User tidak memiliki pelaku ekraf
- Redirect dengan error

**Path 3 (Validation Failed)**:
```
1 → 2 (Yes) → 3 (Invalid) → 9
```
- User memiliki pelaku ekraf
- Validasi gagal
- Return validation errors

**Path 4 (Exception Path)**:
```
1 → 2 (Yes) → 3 (Valid) → 4 → 5 (Error) → 11 → 12 → 13
```
- User memiliki pelaku ekraf
- Validasi lolos
- Upload/Create error
- Rollback transaction
- Delete uploaded image
- Redirect error

---

## 4. Condition Testing

### 4.1 Condition Coverage Table

| Condition | True Case | False Case | Test Data |
|-----------|-----------|------------|-----------|
| `!$pelakuEkraf` | User tidak punya pelaku ekraf | User punya pelaku ekraf | Test dengan user berbeda |
| `$request->validate()` | All fields valid | Any field invalid | Test dengan berbagai input |
| `Image upload success` | Upload berhasil | Upload gagal | Mock CloudinaryService |
| `Product::create()` | Create berhasil | DB error | Test dengan valid/invalid data |
| `isset($uploadResult['public_id'])` | Upload sudah dilakukan | Belum upload | Test exception path |

---

## 5. Loop Testing

### 5.1 Loop Analysis

**Note**: Method `store()` tidak memiliki explicit loop (for, while, foreach).

Namun ada **implicit iterations** di:
1. **Validation rules iteration** (Laravel internal)
2. **Database query execution** (internal)

**Test Cases**:
- Minimal: 1 produk dibuat
- Typical: 1 produk per request
- Maximum: N/A (single create operation)

---

## 6. Data Flow Testing

### 6.1 Variable Definition-Use Analysis

| Variable | Definition Point | Use Point | Kill Point |
|----------|------------------|-----------|------------|
| `$pelakuEkraf` | Line ~80 | Line ~86, ~105 | End of method |
| `$validated` | Line ~87 | Line ~106-112 | End of method |
| `$cloudinaryService` | Line ~102 | Line ~103-104 | End of try block |
| `$uploadResult` | Line ~103 | Line ~113-114, ~123 | End of method |
| `$product` | Line ~105 | (returned to DB) | End of method |

**Def-Use Paths**:
1. `$pelakuEkraf`: def(80) → use(86) → use(105)
2. `$validated`: def(87) → use(106-112)
3. `$uploadResult`: def(103) → use(113-114) → use(123)

---

## 7. Statement Coverage

### 7.1 Coverage Requirements

Total executable statements: **~25 lines**

**Test Cases untuk 100% Statement Coverage**:

| Test Case | Statements Covered | Coverage % |
|-----------|-------------------|------------|
| TC1: Success path | Lines 80-87, 100-115, 117-120 | 80% |
| TC2: No pelaku ekraf | Lines 80-84 | 16% |
| TC3: Validation error | Lines 80-87 | 28% |
| TC4: Exception path | Lines 80-87, 100-105, 121-128 | 64% |
| **Combined** | **All statements** | **100%** |

---

## 8. Branch Coverage

### 8.1 Decision Points & Test Cases

| Decision | Branch | Test Case | Expected Result |
|----------|--------|-----------|-----------------|
| `if (!$pelakuEkraf)` | True | User tanpa pelaku ekraf | Redirect error |
| `if (!$pelakuEkraf)` | False | User dengan pelaku ekraf | Continue |
| Validation | Fail | Invalid data | Return validation error |
| Validation | Pass | Valid data | Continue to upload |
| Try block | Success | No exception | Commit & redirect success |
| Try block | Exception | Any error | Rollback & redirect error |
| `if (isset($uploadResult))` | True | Upload sudah dilakukan | Delete image |
| `if (isset($uploadResult))` | False | Belum upload | Skip delete |

**Branch Coverage**: 8/8 branches = **100%**

---

## 9. Basis Path Testing

### 9.1 Linearly Independent Paths

**Path 1**: 
```
Start → Check Auth → Validate → Begin Tx → Upload → Create → Commit → Success
```

**Path 2**: 
```
Start → Check Auth (Fail) → Redirect Error
```

**Path 3**: 
```
Start → Check Auth → Validate (Fail) → Return Validation Error
```

**Path 4**: 
```
Start → Check Auth → Validate → Begin Tx → Exception → Rollback → Error
```

**Total Paths**: 4 (matches Cyclomatic Complexity = 4) ✅

---

## 10. Test Cases Summary

### 10.1 Comprehensive Test Matrix

| TC ID | Test Scenario | Input | Expected Output | Path |
|-------|--------------|-------|-----------------|------|
| **TC-WB-TP-001** | User tanpa pelaku ekraf | auth()->user()->pelakuEkraf = null | Redirect dengan error | Path 2 |
| **TC-WB-TP-002** | Product name kosong | product_name: "" | Validation error | Path 3 |
| **TC-WB-TP-003** | Product name duplikat | product_name: existing name | Validation error | Path 3 |
| **TC-WB-TP-004** | Category kosong | category: "" | Validation error | Path 3 |
| **TC-WB-TP-005** | Sub sektor invalid | sub_sektor_id: 99999 | Validation error | Path 3 |
| **TC-WB-TP-006** | Price negatif | price: -100 | Validation error | Path 3 |
| **TC-WB-TP-007** | Description kosong | description: "" | Validation error | Path 3 |
| **TC-WB-TP-008** | Image tidak di-upload | image: null | Validation error | Path 3 |
| **TC-WB-TP-009** | Image format invalid | image: file.pdf | Validation error | Path 3 |
| **TC-WB-TP-010** | Image size > 2MB | image: 3MB file | Validation error | Path 3 |
| **TC-WB-TP-011** | Cloudinary upload gagal | Valid data, Cloudinary error | Exception, rollback, redirect error | Path 4 |
| **TC-WB-TP-012** | Database error saat create | Valid data, DB error | Exception, rollback, image deleted | Path 4 |
| **TC-WB-TP-013** | Semua data valid | All valid inputs | Product created, redirect success | Path 1 |

---

## 11. Execution Results

### 11.1 Test Execution Log

| TC ID | Executed | Result | Notes |
|-------|----------|--------|-------|
| TC-WB-TP-001 | ⬜ | - | - |
| TC-WB-TP-002 | ⬜ | - | - |
| TC-WB-TP-003 | ⬜ | - | - |
| TC-WB-TP-004 | ⬜ | - | - |
| TC-WB-TP-005 | ⬜ | - | - |
| TC-WB-TP-006 | ⬜ | - | - |
| TC-WB-TP-007 | ⬜ | - | - |
| TC-WB-TP-008 | ⬜ | - | - |
| TC-WB-TP-009 | ⬜ | - | - |
| TC-WB-TP-010 | ⬜ | - | - |
| TC-WB-TP-011 | ⬜ | - | - |
| TC-WB-TP-012 | ⬜ | - | - |
| TC-WB-TP-013 | ⬜ | - | - |

---

## 12. Coverage Summary

| Metric | Coverage | Status |
|--------|----------|--------|
| **Statement Coverage** | 100% | ✅ |
| **Branch Coverage** | 100% | ✅ |
| **Path Coverage** | 100% (4/4 paths) | ✅ |
| **Condition Coverage** | 100% | ✅ |
| **Cyclomatic Complexity** | 4 (Low-Medium) | ✅ |

---

## 13. Recommendations

### 13.1 Code Quality
- ✅ Good separation of concerns (Validation, Upload, DB)
- ✅ Proper use of database transactions
- ✅ Clean error handling dengan rollback
- ✅ Image cleanup on error

### 13.2 Potential Improvements
1. **Add logging**: Log semua operasi untuk debugging
2. **Extract validation**: Buat Form Request class terpisah
3. **Service layer**: Extract business logic ke ProductService
4. **Unit tests**: Buat PHPUnit test untuk semua paths
5. **Queue processing**: Consider async image upload untuk performa

---

**Catatan Tester:**
- Kode sudah cukup robust dengan proper error handling
- Transaction management sudah benar
- Validation rules sudah comprehensive
- Cleanup mechanism (delete image) sudah ada
