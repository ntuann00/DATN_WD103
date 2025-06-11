<?php

namespace Database\Seeders;

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
        $faker    = Faker::create();
        $products = Product::all();

        foreach ($products as $product) {
            foreach (range(1, 2) as $i) {
                Product_variant::create([
                    'product_id' => $product->id,
                    'sku'        => strtoupper($faker->bothify('SKU-###??')),
                    'color'      => $faker->safeColorName,
                    'capacity'   => $faker->randomElement(['30ml', '50ml', '100ml', '200ml']),
                    'scent'      => $faker->randomElement(['Lavender', 'Vanilla', 'Citrus', 'Mint']),
                    'texture'    => $faker->randomElement(['Smooth', 'Matte', 'Glossy', 'Rough']),
                ]);
            }
        }
    }
}
