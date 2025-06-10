<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            Payment::create([
                'name' => $faker->creditCardType,
                'provider' => $faker->company,
                'account_no' => $faker->creditCardNumber,
                'expiry_date' => $faker->creditCardExpirationDateString,
            ]);
        }
    }
}
