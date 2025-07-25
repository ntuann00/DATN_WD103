<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;

Route::middleware(['auth', 'check.role'])->prefix('admin')->name('admin.')->group(function () {
    // Quản lý sản phẩm
    Route::resource('products', ProductController::class);

    // Xóa ảnh sản phẩm
    Route::delete('product-images/{id}', [ProductImageController::class, 'destroy'])->name('product-images.destroy');
});
