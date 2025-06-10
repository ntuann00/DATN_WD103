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
        $userIds = Users::pluck('id')->toArray();

        foreach ($userIds as $userId) {
            Address::create([
                'user_id' => $userId,
                'province' => $faker->state,
                'district' => $faker->city,
                'ward' => $faker->streetName,
                'detail' => $faker->streetAddress,
            ]);
        }
    }
}
