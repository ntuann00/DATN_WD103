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
    protected $fillable = [
        'user_id', 'name', 'status_id', 'description', 'address_id', 'phone', 'total'
    ];
    public function orderDetails()
    {
      return $this->hasMany(Order_detail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
