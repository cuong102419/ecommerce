<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/cart', [CartController::class,'index'])->name('cart');
Route::prefix('products')->group(function() {
    Route::get('/', [ProductController::class, 'index'])->name('product.list');
    Route::get('/detail', [ProductController::class, 'detail'])->name('product.detail');
});

Route::prefix('admin')->group((function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

}));

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class,'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
Route::post('/logout', [LoginController::class,'logout'])->name('logout');

