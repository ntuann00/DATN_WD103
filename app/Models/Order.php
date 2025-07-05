<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderDetail;
use App\Models\Address;

class Order extends Model
{
    use HasFactory;

    // Mỗi đơn hàng thuộc về 1 người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Một đơn hàng có nhiều chi tiết đơn hàng
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    // Mỗi đơn hàng có 1 địa chỉ nhận hàng
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
