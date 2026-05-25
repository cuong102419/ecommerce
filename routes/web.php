<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/cart', [CartController::class,'index'])->name('cart');
Route::prefix('products')->group(function() {
    Route::get('/', [ProductController::class, 'index'])->name('product.list');
    Route::get('/detail', [ProductController::class, 'detail'])->name('product.detail');
});

Route::middleware(['auth', 'check.role'])->prefix('admin')->group((function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('/categories')->group((function() {
        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::get('/create', [CategoryController::class,'create'])->name('categories.create');
        Route::post('/create', [CategoryController::class,'store'])->name('categories.store');
    }));
}));

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class,'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
Route::post('/logout', [LoginController::class,'logout'])->name('logout');

