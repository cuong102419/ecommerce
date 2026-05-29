<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/cart', [CartController::class,'index'])->name('cart');
Route::prefix('products')->group(function() {
    Route::get('/', [ProductController::class, 'index'])->name('product.list');
    Route::get('/{product}', [ProductController::class, 'detail'])->name('product.detail');
});

Route::middleware(['auth', 'check.role'])->prefix('admin')->group((function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('/categories')->group((function() {
        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::get('/create', [CategoryController::class,'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class,'store'])->name('categories.store');
        Route::get('/edit/{category}', [CategoryController::class,'edit'])->name('categories.edit');
        Route::put('/update/{category}', [CategoryController::class,'update'])->name('categories.update');
    }));

    Route::prefix('products')->group((function() {
        Route::get('/export-template', [AdminProductController::class, 'exportTemplate'])->name('admin.products.export');
        Route::post('/import', [AdminProductController::class,'import'])->name('admin.prouducts.import');
    
        Route::get('/', [AdminProductController::class, 'index'])->name('admin.products');
        Route::get('/create', [AdminProductController::class,'create'])->name('admin.products.create');
        Route::get('/{product}', [AdminProductController::class, 'detail'])->name('admin.products.detail');
        Route::post('/store', [AdminProductController::class,'store'])->name('admin.products.store');
        Route::get('/edit/{product}', [AdminProductController::class,'edit'])->name('admin.products.edit');
        Route::put('/update/{product}', [AdminProductController::class,'update'])->name('admin.products.update');

        Route::prefix('{product}/product-images')->group((function() {
            Route::get('/create', [ProductImageController::class, 'create'])->name('product-images.create');
            Route::post('/store', [ProductImageController::class,'store'])->name('product-images.store');
        }));
    }));
}));

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class,'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
Route::post('/logout', [LoginController::class,'logout'])->name('logout');

