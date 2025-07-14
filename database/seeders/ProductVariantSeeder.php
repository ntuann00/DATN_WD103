<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Product_variant;
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
        // Lấy 1 attribute_value ngẫu nhiên
        $randomAttrValue = AttributeValue::inRandomOrder()->first();

        Product_variant::create([
            'product_id'         => $product->id,
            'sku'                => strtoupper($faker->bothify('SKU-###??')),
            'price'              => $faker->randomFloat(2, 100000, 999999),
            'attribute_value_id' => $randomAttrValue->id,
        ]);
    }
}
    }
}
