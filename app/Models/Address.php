<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_address', 'province', 'district', 'ward', 'user_id'
    ];

    // Một địa chỉ có thể được dùng cho nhiều đơn hàng
    public function orders()
    {
        return $this->hasMany(Order::class, 'address_id', 'id');
    }

    // Địa chỉ thuộc về một người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
