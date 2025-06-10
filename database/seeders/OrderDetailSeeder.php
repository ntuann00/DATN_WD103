<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $products = Product::all();

        foreach (Order::all() as $order) {
            $total = 0;

            foreach ($products->random(2) as $product) {
                $quantity = rand(1, 3);
                $price = $product->price;
                $subtotal = $price * $quantity;

                Order_detail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $subtotal,
                ]);

                $total += $subtotal;
            }

            $order->update(['total' => $total]);
        }
    }
}
