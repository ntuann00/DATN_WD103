<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'product_id','product_variant_id' ,'quantity', 'price', 'total'
    ];

    public function order()
    {
      return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
     public function productVariant()
    {
        return $this->belongsTo(Product_variant::class);
    }
}
