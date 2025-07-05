<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'productVariant_id', 'category_id', 'attribute_id',
        'promotion_id', 'brand', 'description', 'status'
    ];

    public function variants()
    {
        return $this->hasMany(Product_variant::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
}


