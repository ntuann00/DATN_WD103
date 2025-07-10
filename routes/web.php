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

// Đăng ký và đăng nhập
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// Profile (yêu cầu đăng nhập)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/repassword', [ProfileController::class, 'showPassword'])->name('repassword');
    Route::post('/repassword', [ProfileController::class, 'updatePassword'])->name('repassword.update');


    //cart
    Route::get('/cart', [UserProductController::class, 'cart'])->name('cart.view');
    Route::post('/cart/update', [UserProductController::class, 'updateCart'])->name('cart.update');
    Route::post('/add-to-cart/{variantId}', [UserProductController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{productId}', [UserProductController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [UserProductController::class, 'clearCart'])->name('cart.clear');

    //ordeer
     // Hiển thị form đặt hàng
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');

    // Xử lý lưu đơn hàng
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');

    // Trang thông báo đặt hàng thành công
    Route::get('/order/success', function () {
        return view('user.orders.order_success');
    })->name('order.success');
});


// Admin dashboard (yêu cầu đăng nhập + check role)
Route::middleware(['auth', 'check.role'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

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
    //đơn hàng
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');

    //mã giảm giá
    Route::resource('/discounts', DiscountController::class);
});
