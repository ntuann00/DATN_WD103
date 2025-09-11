<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
  protected $table = 'product_images';
    protected $fillable = [
<<<<<<< HEAD

=======
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)
        'product_id',
        'product_variant_id',
        'image_url',
        'alt_text',
        'sort_order',
    ];

    /**
     * Quan hệ: ảnh thuộc về một biến thể sản phẩm
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
<<<<<<< HEAD

=======
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 7a02eb7 (Cap nhat code nhanhcuahoang)
