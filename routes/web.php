<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\Mitra\MitraDashboardController;
use App\Http\Controllers\Mitra\MitraProductController;
use App\Http\Controllers\Mitra\MitraProfileController;
use App\Http\Controllers\Mitra\MitraKatalogController;
use App\Http\Controllers\Mitra\MitraKatalogBrowseController;
use Illuminate\Support\Str;
use App\Http\Controllers\ProductViewController;
use App\Http\Controllers\KatalogViewController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/search', function() {
    return view('pages.search');
})->name('search');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
Route::get('/katalog/detail/{slug}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/katalog/subsektor/{subsektor}', [KatalogController::class, 'bySubsektor'])->name('katalog.subsektor');
Route::post('/katalog/{slug}/track-view', [KatalogViewController::class, 'track'])->name('katalog.track-view');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::get('/artikel', [BeritaController::class, 'index'])->name('artikel');
Route::get('/artikels/{slug}', [ArtikelController::class,'show'])->name('artikels.show');


Route::post('/products/{id}/track-view', [ProductViewController::class, 'track'])->name('products.track-view');

Route::get('/author/{username}',[AuthorController::class, 'show'])->name('author.show');



// Umkm Login 


// Custom Login Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomLoginController::class, 'create'])->name('login');
    Route::post('/login', [CustomLoginController::class, 'store']);
    
    // Route Register harus di guest middleware
    Route::get('/register-pelakuekraf', [CustomRegisterController::class, 'create'])->name('register-pelakuekraf');
    Route::post('/register-pelakuekraf', [CustomRegisterController::class, 'store']);
});

// Custom Logout Route
Route::middleware('auth')->group(function () {
    Route::post('/logout', [CustomLoginController::class, 'destroy'])->name('logout');
});

Route::get('/test-email', function() {
    try {
        \Illuminate\Support\Facades\Mail::raw('Test email dari EKRAF KUNINGAN', function($message) {
            $message->to('test@example.com')
                    ->subject('Test Email Configuration');
        });
        
        return 'Email berhasil dikirim! Cek inbox Mailtrap atau Gmail.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
})->name('test.email');

// Route untuk menangani storage files dengan CORS headers
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        abort(404);
    }
    
    $response = response()->file($filePath);
    
    // Tambahkan CORS headers
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
    
    return $response;
})->where('path', '.*');
// Include authentication routes (excluding login routes that we override)
require __DIR__.'/auth.php';

// =========================
// Mitra (UMKM) Dashboard
// =========================
Route::middleware('auth')->prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/', [MitraDashboardController::class, 'index'])->name('dashboard');

    // Browse Katalog Products (All Approved Products)
    Route::get('/katalog-produk', [MitraKatalogBrowseController::class, 'index'])->name('katalog');
    Route::get('/katalog-produk/{id}', [MitraKatalogBrowseController::class, 'show'])->name('katalog.show');

// Katalog Management Routes (only index, create, store, show - no edit/update/delete)
    Route::get('/katalog-management', [MitraKatalogController::class, 'index'])->name('katalog-management.index');
    Route::get('/katalog-management/create', [MitraKatalogController::class, 'create'])->name('katalog-management.create');
    Route::post('/katalog-management', [MitraKatalogController::class, 'store'])->name('katalog-management.store');
    Route::get('/katalog-management/{id}', [MitraKatalogController::class, 'show'])->name('katalog-management.show');

    // Product Management Routes
    Route::get('/products', [MitraProductController::class, 'index'])->name('products');
    Route::get('/products/create', [MitraProductController::class, 'create'])->name('products.create');
    Route::post('/products', [MitraProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [MitraProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [MitraProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [MitraProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [MitraProductController::class, 'destroy'])->name('products.destroy');

    // Profile Management Routes
    Route::get('/profile', [MitraProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [MitraProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [MitraProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile/image', [MitraProfileController::class, 'deleteImage'])->name('profile.deleteImage');
});