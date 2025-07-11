<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Order_detail;
use App\Models\Address;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'status_id',
        'description',
        'address_id',
        'phone',
        'total',
        'email',
        'province',
        'district',
        'address_detail',
        'payment_method',
        'shipping_fee',
        'discount', // hoặc 'Promotion' nếu dùng tên cũ
    ];

    public function orderDetails()
    {
        return $this->hasMany(Order_detail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class); // Cần có bảng addresses và cột address_id trong orders
    }
}
