<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Cart_detail;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CartDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker    = Faker::create();
        $products = Product::with('variants')->get(); // Load variants luôn

        foreach (Cart::all() as $cart) {
            $selectedProducts = $products->random(rand(2, 3));

            foreach ($selectedProducts as $product) {
                $variant = $product->variants->first(); // Lấy biến thể đầu tiên

                if (!$variant) continue; // Nếu không có biến thể thì bỏ qua

                if (!Cart_detail::where('cart_id', $cart->id)
                                ->where('product_id', $product->id)
                                ->where('product_variant_id', $variant->id)
                                ->exists()) {
                    Cart_detail::create([
                        'cart_id'            => $cart->id,
                        'product_id'         => $product->id,
                        'product_variant_id' => $variant->id, // THÊM DÒNG NÀY
                        'quantity'           => rand(1, 5),
                    ]);
                }
            }
        }
    }
}
