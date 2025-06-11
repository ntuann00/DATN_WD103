<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker    = Faker::create();
        $users    = User::all();
        $products = Product::all();

        foreach ($users as $user) {
            // Mỗi user đánh giá ngẫu nhiên 2 sản phẩm
            foreach ($products->random(2) as $product) {
                // Tránh tạo đánh giá trùng lặp
                if (!Review::where('user_id', $user->id)->where('product_id', $product->id)->exists()) {
                    Review::create([
                        'user_id'    => $user->id,
                        'product_id' => $product->id,
                        'rating'     => rand(1, 5),
                        'comment'    => $faker->sentence,
                    ]);
                }
            }
        }
    }
}
