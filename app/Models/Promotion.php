<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Termwind\terminal;

class Promotion extends Model
{
    use HasFactory;
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
