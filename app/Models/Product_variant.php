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
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variantValues()
    {
        return $this->hasMany(Product_variant_value::class, 'variant_id')->with('attributeValue.attribute');
    }
        public function images()
    {
        return $this->hasMany(Product_image::class, 'product_variant_id');
    }
    public function values()
    {
        // thứ tự: RelatedModel, foreign_key_on_related_table, local_key
        return $this->hasMany(
            Product_variant_value::class,
            'variant_id', // đúng với cột trong product_variant_values
            'id'
        );
    }
}
