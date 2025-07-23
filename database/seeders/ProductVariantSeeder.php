<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Product;

use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $products = Product::all();

        foreach ($products as $product) {
            foreach (range(1, 2) as $i) {
                // Tạo biến thể
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'sku'        => strtoupper($faker->bothify('SKU-###??')),
                    'price'      => $faker->randomFloat(2, 100000, 999999),
                    'quantity'   => rand(10, 100),
                ]);

                // Gắn các attribute_value ngẫu nhiên (VD: màu, size)
                $attributeValues = AttributeValue::inRandomOrder()->take(rand(1, 2))->pluck('id');
                $variant->attributeValues()->attach($attributeValues);
            }
        }
    }
}
