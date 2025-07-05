<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\Auth\CustomLoginController;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
<<<<<<< HEAD
Route::get('/katalog/{subsektor}', [KatalogController::class, 'bySubsektor'])->name('katalog.subsektor');
Route::get('/katalog/{slug}', [KatalogController::class, 'show'])->name('katalog.show');
=======
Route::get('/katalog/detail/{slug}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/katalog/subsektor/{subsektor}', [KatalogController::class, 'bySubsektor'])->name('katalog.subsektor');
>>>>>>> 55429e9da719d0d4f3e3c82dfb4884050e952892
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::get('/artikel', [BeritaController::class, 'index'])->name('artikel');
Route::get('/artikels/{slug}', [ArtikelController::class,'show'])->name('artikels.show');
Route::get('/author/{username}',[AuthorController::class, 'show'])->name('author.show');

<<<<<<< HEAD
// Debug route untuk test user level
Route::get('/debug-user', function() {
    if (!Auth::check()) {
        return 'User not logged in';
    }
    
    $user = Auth::user();
    return [
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'id_level' => $user->id_level ?? 'NULL',
        'attributes' => $user->getAttributes()
    ];
})->middleware('auth');

=======
Route::get('/author/{username}',[AuthorController::class, 'show'])->name('author.show');

// Custom Login Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomLoginController::class, 'create'])->name('login');
    Route::post('/login', [CustomLoginController::class, 'store']);
});

// Custom Logout Route
Route::middleware('auth')->group(function () {
    Route::post('/logout', [CustomLoginController::class, 'destroy'])->name('logout');
});

// Include authentication routes (excluding login routes that we override)
>>>>>>> 55429e9da719d0d4f3e3c82dfb4884050e952892
require __DIR__.'/auth.php';