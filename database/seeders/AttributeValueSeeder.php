<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Attribute_value;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $values = [
            'Color'    => ['Red', 'Blue', 'Green', 'Black', 'White'],
            'Size'     => ['S', 'M', 'L', 'XL'],
            'Material' => ['Cotton', 'Polyester', 'Leather'],
            'Weight'   => ['0.5kg', '1kg', '1.5kg'],
            'Length'   => ['30cm', '50cm', '70cm'],
        ];

        foreach ($values as $attributeName => $attributeValues) {
            $attribute = Attribute::where('name', $attributeName)->first();

            if ($attribute) {
                foreach ($attributeValues as $value) {
                    Attribute_value::create([
                        'attribute_id' => $attribute->id,
                        'value'        => $value,
                    ]);
                }
            }
        }
    }
}
