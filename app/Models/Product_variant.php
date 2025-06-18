<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_variant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'sku', 'color', 'capacity', 'scent', 'texture'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variantValues()
{
    return $this->hasMany(Product_variant_value::class, 'variant_id')->with('attributeValue.attribute');
}
    public function images()
{
    return $this->hasMany(Product_image::class, 'product_variant_id');
}
}
