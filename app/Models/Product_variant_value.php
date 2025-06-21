<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_variant_value extends Model
{
    use HasFactory;
    protected $fillable = [
    'variant_id',
    'attribute_value_id',
];
    public function attributeValue()
    {
        return $this->belongsTo(AttributeValue::class, 'attribute_value_id')->with('attribute');
    }
}
