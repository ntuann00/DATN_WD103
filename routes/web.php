<?php
namespace App\Http\Controllers;

// use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return view('user.index');})->name('home');

Route::get('/product', [HomeController::class, 'product'])->name('u.product');
Route::get('/product/{id}', [HomeController::class, 'product_detail'])->name('u.product_detail');

Route::get('/newproduct', [HomeController::class, 'new_product'])->name('u.new_product');
Route::get('/brand', [HomeController::class, 'brand '])->name('u.brand');

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

//đki,

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
//dnhap

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

//logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//sau khhi dnhap
Route::middleware('auth')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
});


Route::middleware(['auth', 'check.role'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});

//category
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

//attribute
Route::get('/attributes', [AttributeController::class, 'index'])->name('attributes.index');
Route::get('/attributes/create', [AttributeController::class, 'create'])->name('attributes.create');
Route::post('/attributes', [AttributeController::class, 'store'])->name('attributes.store');

Route::get('/attributes/{id}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
Route::put('/attributes/{id}', [AttributeController::class, 'update'])->name('attributes.update');
Route::delete('/attributes/{id}', [AttributeController::class, 'destroy'])->name('attributes.destroy');

// attribute_value

Route::get('/attributeValues', [AttributeValueController::class, 'index'])->name('attributeValues.index');
Route::get('/attributeValues/create', [AttributeValueController::class, 'create'])->name('attributeValues.create');
Route::post('/attributeValues', [AttributeValueController::class, 'store'])->name('attributeValues.store');
Route::get('/attributeValues/{id}', [AttributeValueController::class, 'show'])->name('attributeValues.show');
Route::get('/attributeValues/{id}/edit', [AttributeValueController::class, 'edit'])->name('attributeValues.edit');
Route::put('/attributeValues/{id}', [AttributeValueController::class, 'update'])->name('attributeValues.update');
Route::delete('/attributeValues/{id}', [AttributeValueController::class, 'destroy'])->name('attributeValues.destroy');

//users

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{users}', [UserController::class, 'update'])->name('users.update');

Route::patch('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');


Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/admin/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/admin/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::delete('/admin/product-images/{id}', [ProductImageController::class, 'destroy'])
    ->name('product-images.destroy');

