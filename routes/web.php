<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Client\CartItemController;
use App\Http\Controllers\Client\ChatbotController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\ReviewController;
use App\Http\Controllers\Client\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.list');
    Route::get('/{product}', [ProductController::class, 'detail'])->name('product.detail');
});

Route::post('/chatbot/ask', [ChatbotController::class, 'ask'])->name('chatbot.ask');

Route::prefix('cart')->group(function () {
    Route::get('/', [CartItemController::class, 'index'])->name('cart');
    Route::post('/store', [CartItemController::class, 'store'])->name('cart.store');
    Route::delete('/{cart}', [CartItemController::class, 'delete'])->name('cart.delete');
    Route::put('/update', [CartItemController::class, 'update'])->name('cart.update');
});

Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders');
    Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
    Route::middleware(['auth'])->group(function() {
        Route::get('/list', [OrderController::class, 'list'])->name('orders.list');
        Route::get('/detail/{order}', [OrderController::class, 'detail'])->name('orders.detail');
    });
});

Route::middleware(['auth'])->prefix('user')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('user');
    Route::put('/update', [UserController::class, 'update'])->name('user.update');
});

Route::middleware(['auth'])->group(function() {
    Route::post('/{product}/review/store', [ReviewController::class, 'store'])->name('review.store');
});

Route::prefix('checkout')->group(function() {
    Route::get('/momo/create', [PaymentController::class,'store'])->name('payment.store');
    Route::get('/vnpay-confirm', [PaymentController::class, 'vnpayConfirm'])->name('payment.vnpay.confirm');
    Route::get('/momo/{order}', [PaymentController::class, 'index'])->name('payment');
    Route::get('/vnpay/{order}', [PaymentController::class, 'vnpay'])->name('payment.vnpay');
});

Route::middleware(['auth', 'check.role'])->prefix('admin')->group((function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('/categories')->group((function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/update/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/delete/{category}', [CategoryController::class, 'delete'])->name('categories.delete');
    }));

    Route::prefix('products')->group((function () {
        Route::get('/export-template', [AdminProductController::class, 'exportTemplate'])->name('admin.products.export');
        Route::post('/import', [AdminProductController::class, 'import'])->name('admin.prouducts.import');

        Route::get('/', [AdminProductController::class, 'index'])->name('admin.products');
        Route::get('/create', [AdminProductController::class, 'create'])->name('admin.products.create');
        Route::get('/{product}', [AdminProductController::class, 'detail'])->name('admin.products.detail');
        Route::post('/store', [AdminProductController::class, 'store'])->name('admin.products.store');
        Route::get('/edit/{product}', [AdminProductController::class, 'edit'])->name('admin.products.edit');
        Route::put('/update/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
        Route::put('/update-status/{product}', [AdminProductController::class, 'updateStatus'])->name('admin.products.updateStatus');
        Route::delete('/delete/{product}', [AdminProductController::class, 'delete'])->name('admin.products.delete');
        Route::post('update-all', [AdminProductController::class, 'updateAll'])->name('admin.products.all');

        Route::prefix('{product}/product-images')->group((function () {
            Route::get('/create', [ProductImageController::class, 'create'])->name('product-images.create');
            Route::post('/store', [ProductImageController::class, 'store'])->name('product-images.store');
            Route::put('/update', [ProductImageController::class, 'update'])->name('product-images.update');
        }));
    }));

    Route::prefix('orders')->group(function() {
        Route::get('/', [AdminOrderController::class,'index'])->name('admin.orders');
        Route::post('/update-all', [AdminOrderController::class, 'updateAll'])->name('admin.order.all');
        Route::get('/detail/{order}', [AdminOrderController::class,'detail'])->name('admin.orders.detail');
        Route::put('/update-status/{order}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');
        Route::put('/update-shipping-info/{order}', [AdminOrderController::class, 'updateShippingInfo'])->name('admin.orders.shipping');
    });

    Route::prefix('users')->group(function() {
        Route::get('/', [AdminUserController::class, 'index'])->name('admin.users');
        Route::post('/active-all', [AdminUserController::class, 'activeAll'])->name('admin.users.activeAll');
        Route::put('/active/{user}', [AdminUserController::class, 'active'])->name('admin.users.active');
    });
}));

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/verify/{token}', [RegisterController::class, 'verifyAccount'])->name('verifyAccount');