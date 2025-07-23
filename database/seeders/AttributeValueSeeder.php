<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
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
        ];

        foreach ($values as $attributeName => $attributeValues) {
            $attribute = Attribute::where('name', $attributeName)->first();

            if ($attribute) {
                foreach ($attributeValues as $value) {
                    AttributeValue::create([
                        'attribute_id' => $attribute->id,
                        'value'        => $value,
                    ]);
                }
            }
        }
    }
}
