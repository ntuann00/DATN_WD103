<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $categoryIds = Category::pluck('id')->toArray();

        foreach (range(1, 20) as $i) {
            Product::create([
                'name' => ucfirst($faker->unique()->words(2, true)),
                'slug' => $faker->unique()->slug,
                'price' => $faker->randomFloat(2, 10, 500),
                'description' => $faker->paragraph,
                'status' => $faker->randomElement(['active', 'inactive']),
                'category_id' => $faker->randomElement($categoryIds),
            ]);
        }
    }
}
