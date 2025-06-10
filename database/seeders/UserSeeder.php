<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Status;
use App\Models\Users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $roleIds = Role::pluck('id')->toArray();
        $statusIds = Status::pluck('id')->toArray();

        foreach (range(1, 20) as $i) {
            Users::create([
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'gender' => $faker->randomElement(['male', 'female']),
                'birthday' => $faker->date(),
                'password' => bcrypt('password'),
                'status_id' => $faker->randomElement($statusIds),
                'role_id' => $faker->randomElement($roleIds),
            ]);
        }
    }
}
