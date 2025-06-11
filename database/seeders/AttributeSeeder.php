<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $attributes = ['Color', 'Size', 'Material', 'Weight', 'Length', 'Width', 'Height', 'Volume', 'Capacity', 'Scent'];

        foreach ($attributes as $attribute) {
            Attribute::create([
                'name' => $attribute
            ]);
        }
    }
}
