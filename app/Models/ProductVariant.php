<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'sku', 'price', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Danh sách ảnh của biến thể
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_variant_id');
    }

    // Danh sách giá trị thuộc tính (qua bảng trung gian)
    public function attributeValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_variant_values',
            'variant_id',
            'attribute_value_id'
        )->with('attribute');
    }

    public function variantValues()
    {
        return $this->hasMany(Product_variant_value::class, 'variant_id')->with('attributeValue.attribute');
    }
    public function values()
    {
        return $this->hasMany(Product_variant_value::class, 'variant_id')->with('attributeValue');
    }
}
