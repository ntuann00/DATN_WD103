<?php

namespace Database\Seeders;

use App\Models\Attribute_value;
use App\Models\Product_variant;
use App\Models\Product_variant_value;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVariantValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variants = Product_variant::all();

        foreach ($variants as $variant) {
            $attributeValues = Attribute_value::inRandomOrder()->take(2)->get();

            foreach ($attributeValues as $value) {
                Product_variant_value::create([
                    'product_variant_id' => $variant->id,
                    'attribute_value_id' => $value->id,
                ]);
            }
        }
    }
}
