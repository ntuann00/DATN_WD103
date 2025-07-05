<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\Product;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details'; // Đảm bảo đúng tên bảng

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Mỗi chi tiết đơn hàng thuộc về một đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Mỗi chi tiết đơn hàng thuộc về một sản phẩm
 

 public function product()
{
    return $this->belongsTo(Product::class);
}

}
