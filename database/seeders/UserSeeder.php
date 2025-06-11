<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Status;
use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $roleIds   = Role::pluck('id')->toArray();
        $statusIds = Status::pluck('id')->toArray();

        foreach (range(1, 20) as $i) {
            Users::create([
                'name'      => $faker->name,
                'phone'     => $faker->phoneNumber,
                'email'     => $faker->unique()->safeEmail,
                'img'       => $faker->imageUrl(200, 200, 'people', true, 'User'), // random avatar
                'birthday'  => $faker->date('Y-m-d', '-18 years'),
                'password'  => Hash::make('password'),
                'gender'    => $faker->randomElement(['male', 'female']),
                'status'    => $faker->randomElement($statusIds),
                'role_id'   => $faker->randomElement($roleIds),
            ]);
        }
    }
}
