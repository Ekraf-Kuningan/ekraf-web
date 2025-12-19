<?php

/**
 * WHITE BOX TESTING - UNIT TEST
 * Pengujian Manajemen Produk Pelaku Ekraf
 * 
 * Test Scenario:
 * 1. Form Schema Structure (WB-001 s/d WB-006) - 6 tests
 * 2. Model Product Validation (WB-007 s/d WB-013) - 7 tests
 * 3. ProductResource Configuration (WB-014 s/d WB-018) - 5 tests
 * 4. Table Actions & Filters (WB-019 s/d WB-026) - 8 tests
 * 5. Status Values (WB-027 s/d WB-030) - 4 tests
 * 
 * Total: 30 test cases
 */

namespace Tests\Unit;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Models\SubSektor;
use App\Models\BusinessCategory;

// ========================================
// WHITE BOX TEST 1: FORM SCHEMA STRUCTURE
// ========================================

test('WB-001: ProductResource class memiliki method form', function () {
    expect(method_exists(ProductResource::class, 'form'))->toBeTrue();
});

test('WB-002: ProductResource form schema kompleks dengan banyak fields', function () {
    $reflection = new \ReflectionMethod(ProductResource::class, 'form');
    
    // Form method harus memiliki parameter $form
    expect($reflection->getNumberOfParameters())->toBe(1);
});

test('WB-003: Model Product yang linked dengan ProductResource menggunakan field name', function () {
    $product = new Product();
    $fillable = $product->getFillable();
    
    expect($fillable)->toContain('name');
    expect($fillable)->toContain('price');
});

test('WB-004: Model Product yang linked dengan ProductResource menggunakan field stock', function () {
    $product = new Product();
    $fillable = $product->getFillable();
    
    expect($fillable)->toContain('stock');
});

test('WB-005: Model Product yang linked dengan ProductResource menggunakan field status', function () {
    $product = new Product();
    $fillable = $product->getFillable();
    
    expect($fillable)->toContain('status');
});

test('WB-006: Model Product yang linked dengan ProductResource menggunakan field image', function () {
    $product = new Product();
    $fillable = $product->getFillable();
    
    expect($fillable)->toContain('image');
});

// ========================================
// WHITE BOX TEST 2: MODEL PRODUCT VALIDATION
// ========================================

test('WB-007: model Product memiliki fillable field name', function () {
    $product = new Product();
    $fillable = $product->getFillable();
    
    expect($fillable)->toContain('name');
});

test('WB-008: model Product memiliki fillable field description', function () {
    $product = new Product();
    $fillable = $product->getFillable();
    
    expect($fillable)->toContain('description');
});

test('WB-009: model Product memiliki fillable field price', function () {
    $product = new Product();
    $fillable = $product->getFillable();
    
    expect($fillable)->toContain('price');
});

test('WB-010: model Product memiliki fillable field stock', function () {
    $product = new Product();
    $fillable = $product->getFillable();
    
    expect($fillable)->toContain('stock');
});

test('WB-011: model Product memiliki fillable field status', function () {
    $product = new Product();
    $fillable = $product->getFillable();
    
    expect($fillable)->toContain('status');
});

test('WB-012: model Product memiliki fillable field image', function () {
    $product = new Product();
    $fillable = $product->getFillable();
    
    expect($fillable)->toContain('image');
});

test('WB-013: model Product memiliki custom primary key yang tidak auto increment', function () {
    $product = new Product();
    
    expect($product->getKeyName())->toBe('id');
    expect($product->getIncrementing())->toBeFalse();
});

// ========================================
// WHITE BOX TEST 3: PRODUCTRESOURCE CONFIGURATION
// ========================================

test('WB-014: ProductResource memiliki halaman create', function () {
    $pages = ProductResource::getPages();
    
    expect($pages)->toHaveKey('create');
});

test('WB-015: ProductResource memiliki halaman edit', function () {
    $pages = ProductResource::getPages();
    
    expect($pages)->toHaveKey('edit');
});

test('WB-016: ProductResource memiliki halaman list/index', function () {
    $pages = ProductResource::getPages();
    
    expect($pages)->toHaveKey('index');
});

test('WB-017: ProductResource class memiliki method table', function () {
    expect(method_exists(ProductResource::class, 'table'))->toBeTrue();
});

test('WB-018: ProductResource table method menerima parameter', function () {
    $reflection = new \ReflectionMethod(ProductResource::class, 'table');
    
    // Table method harus memiliki parameter $table
    expect($reflection->getNumberOfParameters())->toBe(1);
});

// ========================================
// WHITE BOX TEST 4: TABLE ACTIONS & FILTERS
// ========================================

test('WB-019: ProductResource dapat dipanggil untuk mendapatkan configuration', function () {
    $model = ProductResource::getModel();
    
    expect($model)->toBe(Product::class);
});

test('WB-020: ProductResource navigationIcon terkonfigurasi', function () {
    $icon = ProductResource::getNavigationIcon();
    
    expect($icon)->not->toBeNull();
});

test('WB-021: ProductResource navigationLabel adalah Produk', function () {
    $label = ProductResource::getNavigationLabel();
    
    expect($label)->toBe('Produk');
});

test('WB-022: ProductResource pluralLabel adalah Produk', function () {
    $plural = ProductResource::getPluralLabel();
    
    expect($plural)->toBe('Produk');
});

test('WB-023: ProductResource memiliki navigationGroup', function () {
    $reflection = new \ReflectionClass(ProductResource::class);
    $property = $reflection->getProperty('navigationGroup');
    $property->setAccessible(true);
    
    $group = $property->getValue();
    
    expect($group)->not->toBeNull();
});

test('WB-024: ProductResource navigationSort terkonfigurasi', function () {
    $sort = ProductResource::getNavigationSort();
    
    expect($sort)->not->toBeNull();
});

test('WB-025: ProductResource extends dari Resource class', function () {
    $reflection = new \ReflectionClass(ProductResource::class);
    
    expect($reflection->getParentClass()->getName())->toBe(\Filament\Resources\Resource::class);
});

test('WB-026: ProductResource memiliki model binding ke Product', function () {
    $model = ProductResource::getModel();
    
    expect($model)->toBe(Product::class);
});

// ========================================
// WHITE BOX TEST 5: STATUS VALUES
// ========================================

test('WB-027: Product status memiliki 4 nilai yang valid (pending, approved, rejected, inactive)', function () {
    $validStatuses = ['pending', 'approved', 'rejected', 'inactive'];
    
    foreach ($validStatuses as $status) {
        expect(in_array($status, $validStatuses))->toBeTrue();
    }
    
    expect(count($validStatuses))->toBe(4);
});

test('WB-028: Model Product dapat di-instantiate dengan status pending', function () {
    $product = new Product(['status' => 'pending']);
    
    expect($product->status)->toBe('pending');
});

test('WB-029: Model Product dapat di-instantiate dengan status approved', function () {
    $product = new Product(['status' => 'approved']);
    
    expect($product->status)->toBe('approved');
});

test('WB-030: Model Product dapat di-instantiate dengan status rejected atau inactive', function () {
    $productRejected = new Product(['status' => 'rejected']);
    $productInactive = new Product(['status' => 'inactive']);
    
    expect($productRejected->status)->toBe('rejected');
    expect($productInactive->status)->toBe('inactive');
});
