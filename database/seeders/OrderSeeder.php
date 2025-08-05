<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Status;
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

        $users    = User::all();
        $products = Product::all();
        $statuses = Status::pluck('id')->toArray();
        $payments = Payment::pluck('id')->toArray();

        foreach ($users as $user) {
            $address = Address::where('user_id', $user->id)->first();
            if (!$address) continue;

            // Tạo đơn hàng
            $order = Order::create([
                'user_id'     => $user->id,
                'name'        => 'Order #' . $faker->unique()->numerify('1000##'),
                'payment_id'  => $faker->randomElement($payments),
                'status_id'   => $faker->randomElement($statuses),
                'address_id'  => $address->id,
                'phone'       => $user->phone ?? $faker->phoneNumber,
                'total'       => 0, // sẽ cập nhật lại sau
                'description' => $faker->sentence,
                 'cancel_reason' => $faker->paragraph,
            ]);

            // Gán sản phẩm vào đơn hàng
            $total = 0;
            foreach ($products->random(2) as $product) {
                $quantity = rand(1, 3);
                $price = $product->price ?? $faker->randomFloat(2, 50000, 2000000);
                $lineTotal = $price * $quantity;
                $total += $lineTotal;

                Order_detail::create([
                    'order_id'  => $order->id,
                    'product_id'=> $product->id,
                    'quantity'  => $quantity,
                    'price'     => $price,
                    'total'     => $lineTotal,
                ]);
            }

            // Cập nhật tổng tiền đơn hàng
            $order->update([
                'total' => $total
            ]);
        }
    }
}
