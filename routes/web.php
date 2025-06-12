<?php
namespace App\Http\Controllers;

// use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('admin.dashboard');
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
Route::get('/attributes/{id}', [AttributeController::class, 'show'])->name('attributes.show');
Route::get('/attributes/{id}/edit', [AttributeController::class, 'edit'])->name('attributes.edit');
Route::put('/attributes/{id}', [AttributeController::class, 'update'])->name('attributes.update');
Route::delete('/attributes/{id}', [AttributeController::class, 'update'])->name('attributes.destroy');

//attribute_value

// Route::get('/attributeValues', [AttributeValueController::class, 'index'])->name('attributeValues.index');
// Route::get('/attributeValues/create', [AttributeValueController::class, 'create'])->name('attributeValues.create');
// Route::post('/attributeValues', [AttributeValueController::class, 'store'])->name('attributeValues.store');
// Route::get('/attributeValues/{id}', [AttributeValueController::class, 'show'])->name('attributeValues.show');
// Route::get('/attributeValues/{id}/edit', [AttributeValueController::class, 'edit'])->name('attributeValues.edit');
// Route::put('/attributeValues/{id}', [AttributeValueController::class, 'update'])->name('attributeValues.update');
// Route::delete('/attributeValues/{id}', [AttributeValueController::class, 'update'])->name('attributeValues.destroy');

//users

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
