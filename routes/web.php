<?php

namespace App\Http\Controllers;
// use App\Models\Order;
// use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\ForgotPasswordController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProfileController;

// ----------------- Các routes giữ nguyên ------------------------

// Route::get('/', function () {return view('user.index');})->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/search', [HomeController::class, 'search'])->name('products.search');

Route::get('/product', [HomeController::class, 'product'])->name('u.product');
Route::get('/product/{id}', [HomeController::class, 'product_detail'])->name('u.product_detail');
Route::get('/category/{id}', [HomeController::class, 'category_product'])->name('u.category_product');

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

// Route::get('/cart', [HomeController::class, 'cart'])->name('u.cart');

// Đăng ký và đăng nhập
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Quên mật khẩu
// Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

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

// checkout

// Route::get('checkout', [OrderController::class, 'checkout'])->name('u.checkout_page');
// Route::post('checkout', [OrderController::class, 'store'])->name('checkout_page.store');
// Route::middleware('auth')->post('/checkout', [OrderController::class, 'store'])->name('checkout_page.store');

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('checkout', function() {
//         return view('checkout_page'); // Trang thanh toán
//     });

//     Route::post('order', [OrderController::class, 'store'])->name('order.store');

//     Route::get('order/success/{order}', function($orderId) {
//         $order = App\Models\order::find($orderId);
//         return view('order_success', compact('order')); // Trang thành công
//     })->name('order.success');
// });

// cart
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [UserProductController::class, 'cart'])->name('cart.view');
    Route::post('/cart/update', [UserProductController::class, 'updateCart'])->name('cart.update');
    Route::post('/add-to-cart/{variantId}', [UserProductController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{productId}', [UserProductController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [UserProductController::class, 'clearCart'])->name('cart.clear');

});

// checkout
Route::middleware('auth')->group(function() {
    // Hiển thị form Checkout
    Route::get('/checkout', [OrderController::class, 'showForm'])
         ->name('checkout.form');

    // Xử lý submit đặt hàng
    Route::post('/checkout', [OrderController::class, 'placeOrder'])
         ->name('checkout.place');

    // Trang tóm tắt sau khi đặt
    Route::get('/order/{order}/summary', [OrderController::class, 'summary'])
         ->name('order.summary');
});

// Route::group(['prefix' => 'checkout'], function () {
//     Route::get('/', [OrderController::class, 'checkout'])->name('checkout_page');
//     Route::post('/', [OrderController::class, 'store'])->name('checkout_page.store');
//     Route::get('success/{order}', [OrderController::class, 'success'])->name('order.success');
// });

//category
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

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
