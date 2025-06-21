<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create();

        // Lấy danh sách tất cả user ID
        $userIds = Users::pluck('id')->toArray();

        foreach ($userIds as $userId) {
            // Chỉ tạo địa chỉ nếu user chưa có
            if (!Address::where('user_id', $userId)->exists()) {
                Address::create([
                    'user_id' => $userId,
                    'address' => $faker->streetAddress . ', ' . $faker->city . ', ' . $faker->country,
                ]);
            }
        }
    }
}
