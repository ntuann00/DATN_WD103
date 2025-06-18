<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = Users::all();

        foreach ($users as $user) {
            // Tránh trùng cart nếu chạy lại nhiều lần
            if (!Cart::where('user_id', $user->id)->exists()) {
                Cart::create([
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
