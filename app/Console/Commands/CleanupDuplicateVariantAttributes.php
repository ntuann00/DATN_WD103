<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupDuplicateVariantAttributes extends Command
{
    protected $signature = 'cleanup:variants';
    protected $description = 'Xóa các giá trị attribute bị trùng trong mỗi product_variant';

    public function handle()
    {
        $rows = DB::table('product_variant_values')
            ->join('attribute_values', 'product_variant_values.attribute_value_id', '=', 'attribute_values.id')
            ->select('product_variant_values.variant_id', 'attribute_values.attribute_id', 'product_variant_values.id as pvv_id')
            ->orderBy('product_variant_values.variant_id')
            ->get()
            ->groupBy(function ($item) {
                return $item->variant_id . '-' . $item->attribute_id;
            });

        $deleted = 0;

        foreach ($rows as $group) {
            if ($group->count() > 1) {
                $group->shift(); // giữ lại 1
                $idsToDelete = $group->pluck('pvv_id')->toArray();
                DB::table('product_variant_values')->whereIn('id', $idsToDelete)->delete();
                $deleted += count($idsToDelete);
            }
        }

        $this->info("Đã xoá $deleted dòng bị trùng.");
    }
}
