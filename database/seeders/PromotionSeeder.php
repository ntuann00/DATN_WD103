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
            $startDate = $faker->dateTimeBetween('-1 month', 'now');
            $endDate   = $faker->dateTimeBetween('now', '+1 month');

            Promotion::create([
                'code'                 => strtoupper($faker->bothify('PROMO-###??')),
                'description'          => $faker->sentence,
                'discount_value'       => $faker->randomFloat(2, 5, 50),
                'discount_type'        => $faker->randomElement(['percent', 'fixed']),
                'quantity'             => $faker->numberBetween(50, 500),
                'minimum_order_value'  => $faker->randomFloat(2, 100000, 500000),
                'max_discount_value'   => $faker->randomFloat(2, 50000, 200000),
                'start_date'           => $startDate,
                'end_date'             => $endDate,
            ]);
        }
    }
}
