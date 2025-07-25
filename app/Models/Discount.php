<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Discount extends Model

{
    protected $fillable = [
        'code',
        'description',
        'discount_value',
        'discount_type',
        'quantity',
        'minimum_order_value',
        'max_discount_value',
        'start_date',
        'end_date'
    ];
}
