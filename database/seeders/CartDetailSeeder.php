<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Cart_detail;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CartDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $products = Product::all();

        foreach (Cart::all() as $cart) {
            foreach ($products->random(2) as $product) {
                Cart_detail::create([
                    'cart_id' => $cart->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 5),
                ]);
            }
        }
    }
}
