<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund_info extends Model
{
    use HasFactory;
    protected $fillable = ['refund_id', 'bank', 'bank_number', 'bankholder'];
}


