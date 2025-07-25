<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];

    public function cartDetails() {
        return $this->hasMany(Cart_detail::class, 'cart_id', 'id');
    }
}
