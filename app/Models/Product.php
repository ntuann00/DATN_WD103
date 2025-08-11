<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     protected $fillable = [
        'name',
        'category_id',
        'attribute_id',
        'promotion_id',
        'brand',
        'description',
        'status',
        // thêm các trường khác nếu có trong form hoặc bảng DB
    ];


    
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }
    public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id');
}
}


