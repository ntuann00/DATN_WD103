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
        $faker    = Faker::create();
        $products = Product::all();

        foreach (Cart::all() as $cart) {
            // Chọn ngẫu nhiên 2–3 sản phẩm cho mỗi giỏ hàng
            $selectedProducts = $products->random(rand(2, 3));

            foreach ($selectedProducts as $product) {
                // Kiểm tra tránh duplicate product trong cùng cart
                if (!Cart_detail::where('cart_id', $cart->id)->where('product_id', $product->id)->exists()) {
                    Cart_detail::create([
                        'cart_id'    => $cart->id,
                        'product_id' => $product->id,
                        'quantity'   => rand(1, 5),
                    ]);
                }
            }
        }
    }
}
