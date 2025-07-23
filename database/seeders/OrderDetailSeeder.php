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
        $faker    = Faker::create();
        $products = Product::has('variants')->get();

        foreach (Order::all() as $order) {
            $total = 0;

            foreach ($products->random(2) as $product) {
                $variant = $product->variants->first();

                // Nếu không có variant thì bỏ qua
                if (!$variant) {
                    continue;
                }

                $quantity = rand(1, 3);
                $price = $variant->price;
                $subtotal = $price * $quantity;

                Order_detail::create([
                    'order_id'           => $order->id,
                    'product_id'         => $product->id,
                    'product_variant_id' => $variant->id,
                    'quantity'           => $quantity,
                    'price'              => $price,
                    'total'              => $subtotal,
                ]);

                $total += $subtotal;
            }

            // Cập nhật lại tổng tiền đơn hàng cho từng order
            $order->update([
                'total' => $total
            ]);
        }
    }
}
