<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Katalog / Halaman Depan (Public)
Route::get('/', [ProductController::class, 'index'])->name('home');

// 2. Detail Produk (Public)
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Routes yang membutuhkan Autentikasi (User harus Login)
Route::middleware('auth')->group(function () {
    
    // 3. Keranjang (Cart)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart/remove/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // 4. Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // 5. Setting / Edit Profil (Menggunakan bawaan Breeze yang dimodifikasi nanti)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

// Route autentikasi bawaan Laravel Breeze (Login, Register, dll)
require __DIR__.'/auth.php';