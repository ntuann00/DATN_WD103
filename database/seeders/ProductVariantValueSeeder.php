<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Product_variant_value;
use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVariantValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variants = ProductVariant::all();

        foreach ($variants as $variant) {
            // Lấy ngẫu nhiên 2 giá trị thuộc tính để gán cho mỗi biến thể
            $attributeValues = AttributeValue::inRandomOrder()->take(2)->get();

            foreach ($attributeValues as $value) {
                // Tránh gán trùng cặp variant_id + attribute_value_id
                $exists = Product_variant_value::where('variant_id', $variant->id)
                                               ->where('attribute_value_id', $value->id)
                                               ->exists();

                if (!$exists) {
                    Product_variant_value::create([
                        'variant_id'  => $variant->id,
                        'attribute_value_id'  => $value->id,
                    ]);
                }
            }
        }
    }
}
