// File: app/Models/Order.php
// Nội dung mẫu
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'payment_id',
        'status_id',
        'description',
        'address_id',
        'phone',
        'total',
        'created_at',
    ];

 

    // Người đặt hàng
   public function user() {
    return $this->belongsTo(User::class);
}


public function address()
{
    return $this->belongsTo(Address::class);
}


public function status() {
    return $this->belongsTo(Status::class);
}

public function orderDetails() {
    return $this->hasMany(OrderDetail::class);
}

public function payment()
{
    return $this->belongsTo(Payment::class);
}


}
