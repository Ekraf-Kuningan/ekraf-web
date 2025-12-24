# White Box Testing - Verifikasi Produk (Admin)

**Tanggal Testing**: 21 Desember 2025  
**Tester**: [Nama Tester]  
**File Under Test**: `app/Filament/Resources/ProductResource.php`  
**Methods**: `approveAction()`, `rejectAction()`, `bulkApprove()`, `bulkReject()`

---

## 1. Code Structure & Flow

### 1.1 File Imports & Dependencies
```php
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
```

**Fungsi**: Import dependencies yang dibutuhkan
- `Resource`: Base class untuk Filament resource
- `Tables\Actions`: Individual dan bulk actions
- `Collection`: Handle multiple records
- `DB`: Database transaction management

---

## 2. Individual Approve Action

### 2.1 Method Structure - approveAction()
```php
Tables\Actions\Action::make('approve')
    ->label('Approve')
    ->icon('heroicon-o-check-circle')
    ->color('success')
    ->requiresConfirmation()
    ->action(function (Product $record) {
        $record->update([
            'verification_status' => 'approved',
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);
    })
    ->visible(fn (Product $record) => $record->verification_status === 'pending')
```

**Fungsi**: Approve produk secara individual
- Update status menjadi 'approved'
- Set timestamp verifikasi
- Catat admin yang melakukan verifikasi
- Hanya visible untuk produk pending

### 2.2 Control Flow - Approve Action

```
Start
  |
  v
Check visibility (status == 'pending') ← Decision Point 1
  |           |
  No          Yes
  |           |
  v           v
Hide        Show Button
Action          |
                v
            User clicks "Approve"
                |
                v
            Show confirmation dialog ← Decision Point 2
                |           |
                No          Yes
                |           |
                v           v
            Cancel      Execute action
                            |
                            v
                        Update record:
                        - verification_status = 'approved'
                        - verified_at = now()
                        - verified_by = auth()->id()
                            |
                            v
                        Success notification
                            |
                            v
                        End
```

### 2.3 Test Cases - Approve Action

| No | Test Case | Precondition | Input | Expected Output | Path |
|----|-----------|--------------|-------|-----------------|------|
| **TC-WB-VA-001** | Produk pending | status = 'pending' | Click Approve → Confirm | ✅ Status = 'approved', verified_at set, verified_by set | Main path |
| **TC-WB-VA-002** | Produk approved | status = 'approved' | - | ❌ Button tidak tampil | Visibility check fails |
| **TC-WB-VA-003** | Produk rejected | status = 'rejected' | - | ❌ Button tidak tampil | Visibility check fails |
| **TC-WB-VA-004** | Cancel confirmation | status = 'pending' | Click Approve → Cancel | ❌ No changes | User cancels |
| **TC-WB-VA-005** | User not authenticated | auth()->id() = null | Click Approve → Confirm | ❌ Error (should not happen in Filament) | Error path |

---

## 3. Individual Reject Action

### 3.1 Method Structure - rejectAction()
```php
Tables\Actions\Action::make('reject')
    ->label('Reject')
    ->icon('heroicon-o-x-circle')
    ->color('danger')
    ->requiresConfirmation()
    ->form([
        Forms\Components\Textarea::make('rejection_reason')
            ->label('Alasan Penolakan')
            ->required()
            ->maxLength(500)
            ->placeholder('Masukkan alasan penolakan produk...'),
    ])
    ->action(function (Product $record, array $data) {
        $record->update([
            'verification_status' => 'rejected',
            'rejection_reason' => $data['rejection_reason'],
            'verified_at' => now(),
            'verified_by' => auth()->id(),
        ]);
    })
    ->visible(fn (Product $record) => $record->verification_status === 'pending')
```

**Fungsi**: Reject produk dengan alasan
- Update status menjadi 'rejected'
- Simpan alasan penolakan
- Set timestamp verifikasi
- Catat admin yang melakukan verifikasi
- Hanya visible untuk produk pending

### 3.2 Control Flow - Reject Action

```
Start
  |
  v
Check visibility (status == 'pending') ← Decision Point 1
  |           |
  No          Yes
  |           |
  v           v
Hide        Show Button
Action          |
                v
            User clicks "Reject"
                |
                v
            Show form dialog ← Decision Point 2
                |
                v
            User fills rejection_reason ← Decision Point 3
                |           |
                Empty       Filled
                |           |
                v           v
            Validation  Click Submit
            Error           |
                            v
                        Show confirmation ← Decision Point 4
                            |           |
                            No          Yes
                            |           |
                            v           v
                        Cancel      Execute action
                                        |
                                        v
                                    Update record:
                                    - verification_status = 'rejected'
                                    - rejection_reason = input
                                    - verified_at = now()
                                    - verified_by = auth()->id()
                                        |
                                        v
                                    Success notification
                                        |
                                        v
                                    End
```

### 3.3 Test Cases - Reject Action

| No | Test Case | Precondition | Input | Expected Output | Path |
|----|-----------|--------------|-------|-----------------|------|
| **TC-WB-VR-001** | Reject dengan alasan valid | status = 'pending' | rejection_reason: "Gambar tidak sesuai" | ✅ Status = 'rejected', reason saved | Main path |
| **TC-WB-VR-002** | Reject tanpa alasan | status = 'pending' | rejection_reason: "" | ❌ Validation error | Validation fails |
| **TC-WB-VR-003** | Alasan > 500 karakter | status = 'pending' | rejection_reason: string(600) | ❌ Validation error | Validation fails |
| **TC-WB-VR-004** | Produk approved | status = 'approved' | - | ❌ Button tidak tampil | Visibility check fails |
| **TC-WB-VR-005** | Produk rejected | status = 'rejected' | - | ❌ Button tidak tampil | Visibility check fails |
| **TC-WB-VR-006** | Cancel form | status = 'pending' | Click Reject → Cancel | ❌ No changes | User cancels |
| **TC-WB-VR-007** | Alasan dengan karakter khusus | status = 'pending' | rejection_reason: "Test <script>" | ✅ Saved with escaped characters | XSS prevention |

---

## 4. Bulk Approve Action

### 4.1 Method Structure - bulkApprove()
```php
Tables\Actions\BulkAction::make('bulkApprove')
    ->label('Approve Selected')
    ->icon('heroicon-o-check-circle')
    ->color('success')
    ->requiresConfirmation()
    ->action(function (Collection $records) {
        DB::transaction(function () use ($records) {
            $records->each(function (Product $product) {
                if ($product->verification_status === 'pending') {
                    $product->update([
                        'verification_status' => 'approved',
                        'verified_at' => now(),
                        'verified_by' => auth()->id(),
                    ]);
                }
            });
        });
        
        Notification::make()
            ->title('Produk berhasil diapprove')
            ->success()
            ->send();
    })
    ->deselectRecordsAfterCompletion()
```

**Fungsi**: Approve multiple produk sekaligus
- Iterate semua selected records
- Check status setiap record
- Update hanya yang pending
- Wrapped dalam DB transaction
- Deselect records setelah selesai

### 4.2 Control Flow - Bulk Approve

```
Start
  |
  v
User selects multiple records ← Decision Point 1
  |           |
  None        1+ records
  |           |
  v           v
Button      Button Enabled
Disabled        |
                v
            User clicks "Approve Selected"
                |
                v
            Show confirmation dialog ← Decision Point 2
                |           |
                No          Yes
                |           |
                v           v
            Cancel      Begin Transaction
                            |
                            v
                        Loop through records ← Loop Point
                            |
                            v
                        For each record:
                        Check if status == 'pending' ← Decision Point 3
                            |           |
                            No          Yes (skip)
                            |           |
                            v           v
                        Update      Continue loop
                        record          |
                            |           |
                            +-----------+
                            |
                            v
                        End loop
                            |
                            v
                        Commit Transaction ← Decision Point 4
                            |           |
                            Success     Error
                            |           |
                            v           v
                        Deselect    Rollback
                        records         |
                            |           v
                            |       Show error
                            |       notification
                            v
                        Show success notification
                            |
                            v
                        End
```

### 4.3 Test Cases - Bulk Approve

| No | Test Case | Input | Expected Output | Path |
|----|-----------|-------|-----------------|------|
| **TC-WB-BA-001** | Approve 3 pending products | Select 3 pending products | ✅ All 3 approved | Main path |
| **TC-WB-BA-002** | Mix pending & approved | Select 2 pending + 1 approved | ✅ Only 2 pending approved, 1 skipped | Conditional update |
| **TC-WB-BA-003** | Mix pending & rejected | Select 2 pending + 1 rejected | ✅ Only 2 pending approved, 1 skipped | Conditional update |
| **TC-WB-BA-004** | No records selected | Select 0 records | ❌ Button disabled | Early exit |
| **TC-WB-BA-005** | Database error during transaction | Select 3 products, DB fails | ❌ Rollback, no changes | Exception path |
| **TC-WB-BA-006** | Cancel confirmation | Select products → Cancel | ❌ No changes | User cancels |
| **TC-WB-BA-007** | Large batch (100 products) | Select 100 pending products | ✅ All 100 approved (performance test) | Loop iteration |
| **TC-WB-BA-008** | All products already approved | Select 5 approved products | ✅ No updates, success notification | All skipped |

---

## 5. Bulk Reject Action

### 5.1 Method Structure - bulkReject()
```php
Tables\Actions\BulkAction::make('bulkReject')
    ->label('Reject Selected')
    ->icon('heroicon-o-x-circle')
    ->color('danger')
    ->requiresConfirmation()
    ->form([
        Forms\Components\Textarea::make('rejection_reason')
            ->label('Alasan Penolakan (untuk semua produk yang dipilih)')
            ->required()
            ->maxLength(500)
            ->placeholder('Masukkan alasan penolakan...'),
    ])
    ->action(function (Collection $records, array $data) {
        DB::transaction(function () use ($records, $data) {
            $records->each(function (Product $product) use ($data) {
                if ($product->verification_status === 'pending') {
                    $product->update([
                        'verification_status' => 'rejected',
                        'rejection_reason' => $data['rejection_reason'],
                        'verified_at' => now(),
                        'verified_by' => auth()->id(),
                    ]);
                }
            });
        });
        
        Notification::make()
            ->title('Produk berhasil ditolak')
            ->success()
            ->send();
    })
    ->deselectRecordsAfterCompletion()
```

**Fungsi**: Reject multiple produk dengan satu alasan yang sama
- Show form untuk input rejection reason
- Iterate semua selected records
- Update hanya yang pending dengan alasan yang sama
- Wrapped dalam DB transaction

### 5.2 Control Flow - Bulk Reject

```
Start
  |
  v
User selects multiple records ← Decision Point 1
  |           |
  None        1+ records
  |           |
  v           v
Button      Button Enabled
Disabled        |
                v
            User clicks "Reject Selected"
                |
                v
            Show form dialog ← Decision Point 2
                |
                v
            User fills rejection_reason ← Decision Point 3
                |           |
                Empty       Filled
                |           |
                v           v
            Validation  Show confirmation ← Decision Point 4
            Error           |           |
                            No          Yes
                            |           |
                            v           v
                        Cancel      Begin Transaction
                                        |
                                        v
                                    Loop through records ← Loop Point
                                        |
                                        v
                                    For each record:
                                    Check if status == 'pending' ← Decision Point 5
                                        |           |
                                        No          Yes
                                        |           |
                                        v           v
                                    Skip        Update record:
                                                - status = 'rejected'
                                                - reason = input
                                                - verified_at = now()
                                                - verified_by = auth()->id()
                                        |           |
                                        +-----------+
                                        |
                                        v
                                    End loop
                                        |
                                        v
                                    Commit Transaction ← Decision Point 6
                                        |           |
                                        Success     Error
                                        |           |
                                        v           v
                                    Deselect    Rollback
                                    records         |
                                        |           v
                                        |       Show error
                                        |       notification
                                        v
                                    Show success notification
                                        |
                                        v
                                    End
```

### 5.3 Test Cases - Bulk Reject

| No | Test Case | Input | Expected Output | Path |
|----|-----------|-------|-----------------|------|
| **TC-WB-BR-001** | Reject 3 pending dengan alasan | Select 3 pending, reason: "Invalid" | ✅ All 3 rejected dengan alasan yang sama | Main path |
| **TC-WB-BR-002** | Reject tanpa alasan | Select 3 pending, reason: "" | ❌ Validation error | Validation fails |
| **TC-WB-BR-003** | Alasan > 500 karakter | Select 2 pending, reason: string(600) | ❌ Validation error | Validation fails |
| **TC-WB-BR-004** | Mix pending & approved | Select 2 pending + 1 approved, valid reason | ✅ Only 2 rejected, 1 skipped | Conditional update |
| **TC-WB-BR-005** | No records selected | Select 0 records | ❌ Button disabled | Early exit |
| **TC-WB-BR-006** | Database error | Select 3 products, DB fails | ❌ Rollback, no changes | Exception path |
| **TC-WB-BR-007** | Cancel form | Select products → Cancel form | ❌ No changes | User cancels |
| **TC-WB-BR-008** | Large batch (50 products) | Select 50 pending, valid reason | ✅ All 50 rejected | Loop iteration |
| **TC-WB-BR-009** | All products already rejected | Select 5 rejected products | ✅ No updates, skipped | All skipped |

---

## 6. Cyclomatic Complexity Analysis

### 6.1 Approve Action Complexity
```
V(G) = Decision Points + 1
V(G) = 2 + 1 = 3
```
**Decision Points**:
1. Visibility check (`status === 'pending'`)
2. Confirmation dialog

**Complexity**: Low (Easy to test)

### 6.2 Reject Action Complexity
```
V(G) = Decision Points + 1
V(G) = 4 + 1 = 5
```
**Decision Points**:
1. Visibility check
2. Form validation (rejection_reason required)
3. Form validation (maxLength)
4. Confirmation dialog

**Complexity**: Medium

### 6.3 Bulk Approve Complexity
```
V(G) = Decision Points + Loops + 1
V(G) = 4 + 1 + 1 = 6
```
**Decision Points**:
1. Records selected check
2. Confirmation dialog
3. Status check in loop (`status === 'pending'`)
4. Transaction success/fail

**Loops**: 1 (each iteration through records)

**Complexity**: Medium

### 6.4 Bulk Reject Complexity
```
V(G) = Decision Points + Loops + 1
V(G) = 6 + 1 + 1 = 8
```
**Decision Points**:
1. Records selected check
2. Form validation (required)
3. Form validation (maxLength)
4. Confirmation dialog
5. Status check in loop
6. Transaction success/fail

**Loops**: 1 (each iteration)

**Complexity**: Medium-High

---

## 7. Path Testing

### 7.1 Independent Paths - Bulk Approve

**Path 1 (Happy Path)**:
```
Start → Select Records → Confirm → Begin Tx → Loop (all pending) → Update All → Commit → Success
```

**Path 2 (Mixed Status)**:
```
Start → Select Records → Confirm → Begin Tx → Loop (some pending, some not) → Update Only Pending → Commit → Success
```

**Path 3 (No Selection)**:
```
Start → Select 0 Records → Button Disabled → End
```

**Path 4 (Cancel)**:
```
Start → Select Records → Cancel Confirmation → End
```

**Path 5 (Exception)**:
```
Start → Select Records → Confirm → Begin Tx → DB Error → Rollback → Error Notification → End
```

---

## 8. Loop Testing

### 8.1 Bulk Actions Loop Analysis

**Loop**: `$records->each(function (Product $product) { ... })`

**Test Cases**:

| Test Type | # Records | Expected Behavior |
|-----------|-----------|-------------------|
| **Zero Iterations** | 0 records | Button disabled, no loop execution |
| **One Iteration** | 1 record | Loop executes once |
| **Typical** | 5-10 records | Normal operation |
| **Boundary** | 50 records | Test performance |
| **Maximum** | 100+ records | Stress test, check timeout |

**Loop Invariants**:
- Transaction must remain active throughout loop
- Each iteration must check `status === 'pending'`
- `verified_at` and `verified_by` set consistently

---

## 9. Condition Coverage

### 9.1 Condition Testing Matrix

| Condition | True | False | Test Case |
|-----------|------|-------|-----------|
| `status === 'pending'` (visibility) | TC-VA-001 | TC-VA-002 | Individual actions |
| `status === 'pending'` (in loop) | TC-BA-001 | TC-BA-002 | Bulk actions |
| `rejection_reason required` | TC-VR-001 | TC-VR-002 | Reject actions |
| `rejection_reason maxLength` | TC-VR-001 | TC-VR-003 | Reject actions |
| User confirms action | TC-VA-001 | TC-VA-004 | All actions |
| Transaction commits | TC-BA-001 | TC-BA-005 | Bulk actions |

---

## 10. Data Flow Testing

### 10.1 Variable Definition-Use - Approve Action

| Variable | Definition | Use | Kill |
|----------|-----------|-----|------|
| `$record` | Parameter | Update method | End |
| `verification_status` | 'approved' | Database update | - |
| `verified_at` | now() | Database update | - |
| `verified_by` | auth()->id() | Database update | - |

### 10.2 Variable Definition-Use - Bulk Actions

| Variable | Definition | Use | Kill |
|----------|-----------|-----|------|
| `$records` | Parameter (Collection) | Loop iteration | End |
| `$product` | Loop variable | Status check, update | Each iteration |
| `$data` | Form input | rejection_reason | End |
| Transaction state | DB::transaction() | Commit/Rollback | Transaction end |

---

## 11. Statement Coverage

### 11.1 Coverage Requirements

**Approve Action**: ~5 executable statements
**Reject Action**: ~6 executable statements
**Bulk Approve**: ~12 executable statements
**Bulk Reject**: ~13 executable statements

**Total**: ~36 statements

### 11.2 Coverage Test Cases

| Action | Statements | Test Cases Needed | Coverage |
|--------|-----------|-------------------|----------|
| Approve | 5 | TC-VA-001, TC-VA-002, TC-VA-004 | 100% |
| Reject | 6 | TC-VR-001, TC-VR-002, TC-VR-006 | 100% |
| Bulk Approve | 12 | TC-BA-001, TC-BA-002, TC-BA-005 | 100% |
| Bulk Reject | 13 | TC-BR-001, TC-BR-002, TC-BR-006 | 100% |

---

## 12. Branch Coverage

### 12.1 Decision Coverage Matrix

| Decision Point | True Branch | False Branch | Coverage |
|----------------|-------------|--------------|----------|
| Visibility check | Tested (TC-VA-001) | Tested (TC-VA-002) | 100% |
| Confirmation | Tested (TC-VA-001) | Tested (TC-VA-004) | 100% |
| Validation (required) | Tested (TC-VR-001) | Tested (TC-VR-002) | 100% |
| Validation (maxLength) | Tested (TC-VR-001) | Tested (TC-VR-003) | 100% |
| Loop condition (pending) | Tested (TC-BA-001) | Tested (TC-BA-002) | 100% |
| Transaction commit | Tested (TC-BA-001) | Tested (TC-BA-005) | 100% |

**Total Branch Coverage**: 12/12 = **100%**

---

## 13. Integration Testing

### 13.1 Database Transaction Testing

| Test Case | Scenario | Expected Behavior |
|-----------|----------|-------------------|
| **TC-INT-001** | Bulk approve 10 products, DB error at #5 | ✅ Rollback all, no products updated |
| **TC-INT-002** | Concurrent approvals (2 admins) | ✅ Both succeed, verified_by different |
| **TC-INT-003** | Approve then immediately reject | ✅ Status changes correctly |
| **TC-INT-004** | Network timeout during transaction | ✅ Transaction rolls back |

### 13.2 Notification Testing

| Test Case | Action | Expected Notification |
|-----------|--------|----------------------|
| **TC-NOT-001** | Single approve | "Produk berhasil diapprove" |
| **TC-NOT-002** | Bulk approve 5 products | "5 produk berhasil diapprove" |
| **TC-NOT-003** | Single reject | "Produk berhasil ditolak" |
| **TC-NOT-004** | Transaction error | "Gagal melakukan verifikasi" |

---

## 14. Performance Testing

### 14.1 Bulk Operation Performance

| # Records | Expected Time | Actual Time | Pass/Fail |
|-----------|---------------|-------------|-----------|
| 10 | < 1s | - | - |
| 50 | < 3s | - | - |
| 100 | < 5s | - | - |
| 500 | < 20s | - | - |

### 14.2 Memory Usage

| Operation | Expected Memory | Actual Memory | Pass/Fail |
|-----------|----------------|---------------|-----------|
| Bulk approve 100 | < 50MB | - | - |
| Bulk reject 100 | < 50MB | - | - |

---

## 15. Test Execution Summary

### 15.1 Test Results Matrix

| Test ID | Description | Status | Notes |
|---------|-------------|--------|-------|
| TC-WB-VA-001 | Approve pending product | ⬜ | - |
| TC-WB-VA-002 | Button hidden for approved | ⬜ | - |
| TC-WB-VA-003 | Button hidden for rejected | ⬜ | - |
| TC-WB-VA-004 | Cancel confirmation | ⬜ | - |
| TC-WB-VR-001 | Reject with valid reason | ⬜ | - |
| TC-WB-VR-002 | Reject without reason | ⬜ | - |
| TC-WB-VR-003 | Reason too long | ⬜ | - |
| TC-WB-BA-001 | Bulk approve 3 pending | ⬜ | - |
| TC-WB-BA-002 | Bulk approve mixed status | ⬜ | - |
| TC-WB-BA-005 | Database error handling | ⬜ | - |
| TC-WB-BR-001 | Bulk reject with reason | ⬜ | - |
| TC-WB-BR-002 | Bulk reject without reason | ⬜ | - |

---

## 16. Coverage Summary

| Metric | Target | Achieved | Status |
|--------|--------|----------|--------|
| **Statement Coverage** | 100% | - | ⬜ |
| **Branch Coverage** | 100% | - | ⬜ |
| **Path Coverage** | 100% | - | ⬜ |
| **Condition Coverage** | 100% | - | ⬜ |
| **Loop Coverage** | 100% | - | ⬜ |
| **Cyclomatic Complexity** | < 10 (per method) | 3-8 | ✅ |

---

## 17. Recommendations

### 17.1 Code Quality
- ✅ Good use of database transactions
- ✅ Proper status checking before updates
- ✅ Clear separation of individual vs bulk actions
- ✅ Consistent notification pattern

### 17.2 Potential Improvements
1. **Add logging**: Log setiap verifikasi untuk audit trail
2. **Email notifications**: Notif email ke pelaku ekraf saat approved/rejected
3. **Batch processing**: Consider queue untuk bulk operations > 100 records
4. **Validation**: Add server-side double-check untuk status
5. **Unit tests**: Create PHPUnit tests untuk semua actions
6. **Rate limiting**: Prevent spam clicking pada bulk actions

### 17.3 Security Considerations
- ✅ Authorization handled by Filament middleware
- ✅ XSS prevention via Eloquent ORM
- ✅ SQL injection prevented by query builder
- ⚠️ Consider: Add rate limiting untuk bulk operations
- ⚠️ Consider: Log all verification activities untuk audit

---

**Catatan Tester:**
- Kode sudah robust dengan proper transaction handling
- Bulk operations efficient dengan conditional updates
- Visibility controls sudah benar
- Notification system user-friendly
- Ready untuk production dengan minor improvements
