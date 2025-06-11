<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $i) {
            Category::create([
                'name'        => ucfirst($faker->unique()->word),
                'description' => $faker->sentence,
                'status'      => $faker->randomElement([1, 0]), // 1 = active, 0 = inactive
            ]);
        }
    }
}
