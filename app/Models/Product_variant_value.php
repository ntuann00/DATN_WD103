<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_variant_value extends Model
{
    use HasFactory;

    public function attributeValue()
{
    return $this->belongsTo(Attribute_value::class, 'attribute_value_id')->with('attribute');
}
}
