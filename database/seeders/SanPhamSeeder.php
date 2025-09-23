<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SanPhamSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $now = Carbon::now();

            // ========== LẤY ATTRIBUTE VALUE CÓ SẴN ==========
            $attributeValueIds = DB::table('attribute_values')->pluck('id', 'value')->toArray();

            // ========== DANH MỤC ==========
            $danhMucs = [
                ['name' => 'Serum', 'description' => 'Serum dưỡng da', 'status' => 1],
                ['name' => 'Toner', 'description' => 'Nước hoa hồng cân bằng da', 'status' => 1],
                ['name' => 'Kem dưỡng ẩm', 'description' => 'Dưỡng ẩm và phục hồi', 'status' => 1],
                ['name' => 'Phấn mắt', 'description' => 'Trang điểm mắt', 'status' => 1],
                ['name' => 'Son môi', 'description' => 'Đa dạng son', 'status' => 1],
            ];

            $categoryIds = [];
            foreach ($danhMucs as $dm) {
                DB::table('categories')->updateOrInsert(
                    ['name' => $dm['name']],
                    $dm + ['updated_at' => $now, 'created_at' => $now]
                );
                $categoryIds[$dm['name']] = DB::table('categories')->where('name', $dm['name'])->value('id');
            }

            // ========== 20 SẢN PHẨM ==========
            $products = [
                ['name' => 'Serum Vitamin C Balance', 'category' => 'Serum', 'brand' => 'Balance', 'description' => 'Serum sáng da và mờ thâm'],
                ['name' => 'Serum HA The Ordinary', 'category' => 'Serum', 'brand' => 'The Ordinary', 'description' => 'Serum cấp nước HA'],
                ['name' => 'Toner Thayers Witch Hazel', 'category' => 'Toner', 'brand' => 'Thayers', 'description' => 'Toner dịu nhẹ từ thiên nhiên'],
                ['name' => 'Toner Simple Soothing', 'category' => 'Toner', 'brand' => 'Simple', 'description' => 'Nước hoa hồng cho da nhạy cảm'],
                ['name' => 'Kem Dưỡng Ẩm Laneige Water Bank', 'category' => 'Kem dưỡng ẩm', 'brand' => 'Laneige', 'description' => 'Kem dưỡng ẩm sâu'],
                ['name' => 'Kem Dưỡng Ẩm Clinique Moisture Surge', 'category' => 'Kem dưỡng ẩm', 'brand' => 'Clinique', 'description' => 'Gel dưỡng ẩm nhẹ'],
                ['name' => 'Phấn Mắt Huda Beauty Nude', 'category' => 'Phấn mắt', 'brand' => 'Huda Beauty', 'description' => 'Bảng mắt tông nude'],
                ['name' => 'Phấn Mắt Morphe 35O', 'category' => 'Phấn mắt', 'brand' => 'Morphe', 'description' => 'Bảng mắt 35 màu cam đất'],
                ['name' => 'Son YSL Rouge Pur Couture', 'category' => 'Son môi', 'brand' => 'YSL', 'description' => 'Son lì sang trọng'],
                ['name' => 'Son Charlotte Tilbury Pillow Talk', 'category' => 'Son môi', 'brand' => 'Charlotte Tilbury', 'description' => 'Son lì tự nhiên'],
                ['name' => 'Son Gucci Satin', 'category' => 'Son môi', 'brand' => 'Gucci', 'description' => 'Son satin mềm mượt'],
                ['name' => 'Son Hermes Matte', 'category' => 'Son môi', 'brand' => 'Hermes', 'description' => 'Son lì cao cấp'],
                ['name' => 'Serum Estee Lauder Advanced Night Repair', 'category' => 'Serum', 'brand' => 'Estee Lauder', 'description' => 'Serum phục hồi da ban đêm'],
                ['name' => 'Serum Vichy Mineral 89', 'category' => 'Serum', 'brand' => 'Vichy', 'description' => 'Serum cấp ẩm khoáng chất'],
                ['name' => 'Kem Dưỡng Ẩm Innisfree Green Tea', 'category' => 'Kem dưỡng ẩm', 'brand' => 'Innisfree', 'description' => 'Kem dưỡng từ trà xanh'],
                ['name' => 'Kem Dưỡng Ẩm Kiehl’s Ultra Facial Cream', 'category' => 'Kem dưỡng ẩm', 'brand' => 'Kiehl’s', 'description' => 'Kem dưỡng ẩm nổi tiếng'],
                ['name' => 'Phấn Mắt Colourpop Yes Please', 'category' => 'Phấn mắt', 'brand' => 'Colourpop', 'description' => 'Bảng mắt giá rẻ đẹp'],
                ['name' => 'Phấn Mắt Urban Decay Naked Heat', 'category' => 'Phấn mắt', 'brand' => 'Urban Decay', 'description' => 'Bảng mắt tông nóng'],
                ['name' => 'Son Fenty Beauty Stunna Lip Paint', 'category' => 'Son môi', 'brand' => 'Fenty Beauty', 'description' => 'Son kem lì nổi tiếng'],
                ['name' => 'Son Pat McGrath MatteTrance', 'category' => 'Son môi', 'brand' => 'Pat McGrath', 'description' => 'Son lì cao cấp'],
            ];

            $productIds = [];
            foreach ($products as $sp) {
                DB::table('products')->updateOrInsert(
                    ['name' => $sp['name']],
                    [
                        'category_id' => $categoryIds[$sp['category']],
                        'brand'       => $sp['brand'],
                        'description' => $sp['description'],
                        'status'      => 1,
                        'updated_at'  => $now,
                        'created_at'  => $now,
                    ]
                );
                $productIds[$sp['name']] = DB::table('products')->where('name', $sp['name'])->value('id');
            }

            // ========== BIẾN THỂ ==========
            $colors = [
                'Đỏ đô'     => 'DO',
                'Hồng đào'  => 'HONG',
                'Cam cháy'  => 'CAM',
            ];
            $sizes = [
                '30ml' => '30',
                '50ml' => '50',
            ];

            foreach ($products as $sp) {
                $pid = $productIds[$sp['name']];

                foreach ($colors as $colorName => $colorCode) {
                    foreach ($sizes as $sizeName => $sizeCode) {
                        if (!isset($attributeValueIds[$colorName]) || !isset($attributeValueIds[$sizeName])) {
                            continue;
                        }

                        $sku = strtoupper(str_replace(' ', '-', $sp['brand'])) . "-" . $colorCode . "-" . $sizeCode;

                        DB::table('product_variants')->updateOrInsert(
                            ['sku' => $sku],
                            [
                                'product_id' => $pid,
                                'price'      => rand(200000, 2000000),
                                'quantity'   => rand(5, 20),
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]
                        );

                        $vid = DB::table('product_variants')->where('sku', $sku)->value('id');

                        // Gán màu
                        DB::table('product_variant_values')->updateOrInsert(
                            ['variant_id' => $vid, 'attribute_value_id' => $attributeValueIds[$colorName]],
                            ['created_at' => $now, 'updated_at' => $now]
                        );

                        // Gán dung tích
                        DB::table('product_variant_values')->updateOrInsert(
                            ['variant_id' => $vid, 'attribute_value_id' => $attributeValueIds[$sizeName]],
                            ['created_at' => $now, 'updated_at' => $now]
                        );

                        // Ảnh
                        DB::table('product_images')->updateOrInsert(
                            ['product_variant_id' => $vid, 'image_url' => "storage/products/{$sku}.jpg"],
                            [
                                'alt_text'   => $sp['name'] . " - {$colorName} {$sizeName}",
                                'sort_order' => 1,
                                'created_at' => $now,
                                'updated_at' => $now,
                            ]
                        );
                    }
                }
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            echo $th->getMessage();
        }
    }
}
