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
use App\Http\Controllers\Auth\MultiStepRegisterController;
use App\Http\Controllers\PelakuEkraf\PelakuEkrafDashboardController;
use App\Http\Controllers\PelakuEkraf\PelakuEkrafProductController;
use App\Http\Controllers\PelakuEkraf\PelakuEkrafProfileController;
use App\Http\Controllers\PelakuEkraf\PelakuEkrafKatalogController;
use App\Http\Controllers\PelakuEkraf\PelakuEkrafKatalogBrowseController;
use App\Http\Controllers\PelakuEkraf\PelakuEkrafTestimonialController;
use Illuminate\Support\Str;
use App\Http\Controllers\ProductViewController;
use App\Http\Controllers\KatalogViewController;
use App\Http\Controllers\TestimonialController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/search', function() {
    return view('pages.search');
})->name('search');
Route::get('/manfaat', function() {
    $testimonials = \App\Models\Testimonial::approved()
        ->byType('testimoni')
        ->with('user')
        ->latest()
        ->take(6)
        ->get();
    return view('pages.manfaat', compact('testimonials'));
})->name('manfaat');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
Route::get('/katalog/detail/{slug}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/katalog/subsektor/{subsektor}', [KatalogController::class, 'bySubsektor'])->name('katalog.subsektor');
Route::post('/katalog/{slug}/track-view', [KatalogViewController::class, 'track'])->name('katalog.track-view');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'send'])->name('kontak.send');
Route::get('/artikel', [BeritaController::class, 'index'])->name('artikel');
Route::get('/artikels/{slug}', [ArtikelController::class,'show'])->name('artikels.show');

// Testimonial routes
Route::post('/testimonial', [TestimonialController::class, 'store'])->name('testimonial.store');
Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

Route::post('/products/{id}/track-view', [ProductViewController::class, 'track'])->name('products.track-view');

Route::get('/author/{username}',[AuthorController::class, 'show'])->name('author.show');



// Umkm Login 


// Custom Login Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomLoginController::class, 'create'])->name('login');
    Route::post('/login', [CustomLoginController::class, 'store']);
    
    // Multi-Step Registration Routes
    // Step 1: Basic registration (username, email, password)
    Route::get('/register-pelakuekraf', [MultiStepRegisterController::class, 'showStep1'])->name('register-pelakuekraf');
    Route::post('/register-pelakuekraf', [MultiStepRegisterController::class, 'storeStep1']);
    
    // Step 2: Email verification (handled in auth.php)
    
    // Step 3: Complete profile
    Route::get('/register-pelakuekraf/complete-profile/{token}', [MultiStepRegisterController::class, 'showStep3'])->name('register.step3');
    Route::post('/register-pelakuekraf/complete-profile/{token}', [MultiStepRegisterController::class, 'storeStep3']);
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
// Pelaku Ekraf (UMKM) Dashboard
// =========================
Route::middleware('auth')->prefix('pelaku-ekraf')->name('pelaku-ekraf.')->group(function () {
    Route::get('/', [PelakuEkrafDashboardController::class, 'index'])->name('dashboard');

    // Browse Katalog Products (All Approved Products)
    Route::get('/katalog-produk', [PelakuEkrafKatalogBrowseController::class, 'index'])->name('katalog');
    Route::get('/katalog-produk/{id}', [PelakuEkrafKatalogBrowseController::class, 'show'])->name('katalog.show');

    // Katalog Management Routes (only index and show - katalog dibuat oleh admin)
    Route::get('/katalog-management', [PelakuEkrafKatalogController::class, 'index'])->name('katalog-management.index');
    Route::get('/katalog-management/{id}', [PelakuEkrafKatalogController::class, 'show'])->name('katalog-management.show');

    // Product Management Routes
    Route::get('/products', [PelakuEkrafProductController::class, 'index'])->name('products');
    Route::get('/products/create', [PelakuEkrafProductController::class, 'create'])->name('products.create');
    Route::post('/products', [PelakuEkrafProductController::class, 'store'])->name('products.store');
    Route::post('/products/check-name', [PelakuEkrafProductController::class, 'checkProductName'])->name('products.check-name');
    Route::get('/products/{product}', [PelakuEkrafProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [PelakuEkrafProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [PelakuEkrafProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [PelakuEkrafProductController::class, 'destroy'])->name('products.destroy');

    // Profile Management Routes
    Route::get('/profile', [PelakuEkrafProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [PelakuEkrafProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [PelakuEkrafProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/profile/image', [PelakuEkrafProfileController::class, 'deleteImage'])->name('profile.deleteImage');
    
    // Testimonial Routes
    Route::get('/testimonial', [PelakuEkrafTestimonialController::class, 'index'])->name('testimonial.index');
    Route::post('/testimonial', [PelakuEkrafTestimonialController::class, 'store'])->name('testimonial.store');
    Route::delete('/testimonial', [PelakuEkrafTestimonialController::class, 'destroy'])->name('testimonial.destroy');
});