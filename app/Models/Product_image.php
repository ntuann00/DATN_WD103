<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    use HasFactory;
    protected $fillable = ['image_url', 'alt_text', 'sort_order', 'product_variant_id'];
}
