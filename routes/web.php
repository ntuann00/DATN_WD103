<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserController as UserUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

// ----------------- Các routes giữ nguyên ------------------------

Route::get('/', function () {
    return view('user.index');
})->name('home');

Route::get('/product', [HomeController::class, 'product'])->name('u.product');
Route::get('/product/{id}', [HomeController::class, 'product_detail'])->name('u.product_detail');
Route::get('/newproduct', [HomeController::class, 'new_product'])->name('u.new_product');
Route::get('/brand', [HomeController::class, 'brand'])->name('u.brand');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('u.checkout');
Route::get('/about_us', [HomeController::class, 'about_us'])->name('u.about_us');
Route::get('/blog', [HomeController::class, 'blog'])->name('u.blog');
Route::get('/blog/1', [HomeController::class, 'blog_detail'])->name('u.blog_detail');
Route::get('/faq', [HomeController::class, 'faq'])->name('u.faq');
Route::get('/contact', [HomeController::class, 'contact'])->name('u.contact');
Route::get('/account', [HomeController::class, 'account'])->name('u.account');
Route::get('/login', [HomeController::class, 'login'])->name('u.login');
Route::get('/register', [HomeController::class, 'register'])->name('u.register');
Route::get('/cart', [HomeController::class, 'cart'])->name('u.cart');

// Đăng ký và đăng nhập
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Quên mật khẩu
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

// Profile (yêu cầu đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/repassword', [ProfileController::class, 'showPassword'])->name('repassword');
    Route::post('/repassword', [ProfileController::class, 'updatePassword'])->name('repassword.update');
});

// Admin dashboard (yêu cầu đăng nhập + check role)
Route::middleware(['auth', 'check.role'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

// Categories
Route::resource('categories', CategoryController::class);

// Attributes
Route::resource('attributes', AttributeController::class)->except(['show']);
Route::get('/attributes/{id}/show', [AttributeController::class, 'show'])->name('attributes.show');

// Attribute Values
Route::resource('attributeValues', AttributeValueController::class);

// Users
Route::resource('users', UserController::class);
Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

// Products
Route::resource('products', ProductController::class);
Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
Route::delete('/admin/product-images/{id}', [ProductImageController::class, 'destroy'])->name('product-images.destroy');

// Cart (yêu cầu đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart', [CartController::class, 'index'])->name('u.cart');
});

// Đơn hàng (Order)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
});

// ✅ MÃ GIẢM GIÁ - KHÔNG yêu cầu đăng nhập
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('/discounts', DiscountController::class);
});
