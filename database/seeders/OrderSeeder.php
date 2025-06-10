<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::all();
        $products = Product::all();
        $payments = Payment::pluck('id')->toArray();

        foreach ($users as $user) {
            $address = Address::where('user_id', $user->id)->first();
            if (!$address) continue;

            $order = Order::create([
                'user_id' => $user->id,
                'payment_id' => $faker->randomElement($payments),
                'address_id' => $address->id,
                'phone' => $user->phone,
                'total' => 0,
                'description' => $faker->sentence,
            ]);

            $total = 0;
            foreach ($products->random(2) as $product) {
                $quantity = rand(1, 3);
                $price = $product->price;
                $total += $price * $quantity;

                Order_detail::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $price * $quantity,
                ]);
            }

            $order->update(['total' => $total]);
        }
    }
}
