<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_detail extends Model
{
    use HasFactory;
    protected $table = 'cart_details';
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    public function cart() {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function variant(){
        return $this->belongsTo(Product_variant::class, 'variant_id', 'id');
    }
}
