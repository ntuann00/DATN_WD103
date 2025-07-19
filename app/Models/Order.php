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
        'payment_id',
        'status_id',
        'description',
        'address_id',
        'phone',
        'total',

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
        return $this->belongsTo(Address::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
