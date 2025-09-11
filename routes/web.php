<?php

use App\Http\Controllers\VNPayController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VNPayController;

// ================== User Controllers ===================
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\User\OrderController;

// ================== Admin Controllers ==================
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\ReviewController;

// ================== Public Routes ===================
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

// ================== Auth Routes ===================
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================== User Protected Routes ===================
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/repassword', [ProfileController::class, 'showPassword'])->name('repassword');
    Route::post('/repassword', [ProfileController::class, 'updatePassword'])->name('repassword.update');

    // Cart
    Route::get('/cart', [UserProductController::class, 'cart'])->name('cart.view');
    Route::post('/cart/update', [UserProductController::class, 'updateCart'])->name('cart.update');
    Route::post('/add-to-cart', [UserProductController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{productId}', [UserProductController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [UserProductController::class, 'clearCart'])->name('cart.clear');

    // Orders
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
<<<<<<< HEAD
    Route::get('/order/success', function () {
        return view('user.orders.order_success');
    })->name('order.success');

    Route::get('/order/fail', function () {
        return view('user.vnpay.vnpay_fail');
    })->name('order.fail');
    Route::post('/checkout-selected', [OrderController::class, 'checkoutSelected'])->name('checkout.selected');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::post('/orders/{id}/return', [OrderController::class, 'return'])->name('orders.return');
    Route::get('/orders/{id}/return', [OrderController::class, 'return'])->name('orders.return');

=======
    Route::get('/order/success', fn () => view('user.orders.order_success'))->name('order.success');
    Route::get('/order/fail', fn () => view('user.vnpay.vnpay_fail'))->name('order.fail');
    Route::post('/checkout-selected', [OrderController::class, 'checkoutSelected'])->name('checkout.selected');

    // Các thao tác với đơn hàng
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::match(['get','post'],'/orders/{id}/return', [OrderController::class, 'return'])->name('orders.return');

    // ✅ Thêm route xác nhận đã nhận hàng
    Route::post('/orders/{id}/confirm', [OrderController::class, 'confirmReceived'])->name('orders.confirm');

    // ✅ Sau khi xác nhận nhận hàng => mở form bình luận
    Route::get('/orders/{id}/review', [OrderController::class, 'reviewForm'])->name('orders.review.form');
    Route::post('/orders/{id}/review', [OrderController::class, 'submitReview'])->name('orders.review.submit');
});
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)

// ================== Admin Routes ===================
Route::middleware(['auth', 'check.role'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Attributes + Values
    Route::resource('attributes', AttributeController::class)->except(['show']);
    Route::get('/attributes/{id}/show', [AttributeController::class, 'show'])->name('attributes.show');
    Route::resource('attributeValues', AttributeValueController::class);
    Route::put('/attributeValues/{attributeValue}', [AttributeValueController::class, 'update'])->name('attributeValues.update');

    // Users
    Route::resource('users', UserController::class);
    Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // Products
    Route::resource('products', ProductController::class);
    Route::delete('product-images/{id}', [ProductImageController::class, 'destroy'])->name('product-images.destroy');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
<<<<<<< HEAD

=======
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)

    // Promotions
    Route::resource('promotions', PromotionController::class);


    Route::get('/admin/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');

    // Statistics
    Route::get('/admin/statistics', [App\Http\Controllers\Admin\StatisticsController::class, 'index'])
    ->name('admin.statistics');

});

<<<<<<< HEAD



//vn-pay
=======
// ================== VNPay ===================
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)
Route::post('/vnpay/payment', [VNPayController::class, 'create'])->name('vnpay.payment');
Route::get('/vnpay-return', [VNPayController::class, 'vnpayReturn'])->name('vnpay.return');
