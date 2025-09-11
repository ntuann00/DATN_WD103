<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Lấy danh sách ID từ các bảng liên kết
        $categoryIds  = Category::pluck('id')->toArray();
        $attributeIds = Attribute::pluck('id')->toArray();
        $promotionIds = Promotion::pluck('id')->toArray();
        $productVariantIds = ProductVariant::pluck('id')->toArray();

        foreach (range(1, 20) as $i) {
            Product::create([
                'name'            => ucfirst($faker->unique()->words(2, true)),
                'category_id'     => $faker->randomElement($categoryIds),
                'attribute_id'    => $faker->randomElement($attributeIds),
                'promotion_id'    => $faker->randomElement($promotionIds),
                'brand'           => $faker->company,
                'description'     => $faker->paragraph,
               
                'status' => $faker->randomElement([1, 0]), // 1 = active, 0 = inactive
            ]);
        }
    }
}
