<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            Promotion::create([
                'name' => 'Promo ' . $faker->unique()->word,
                'description' => $faker->sentence,
                'discount_percent' => $faker->numberBetween(5, 50),
                'start_date' => $faker->dateTimeBetween('-1 month', 'now'),
                'end_date' => $faker->dateTimeBetween('now', '+1 month'),
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }
    }
}
