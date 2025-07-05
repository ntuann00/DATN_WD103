<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['pending', 'processing', 'completed', 'cancelled', 'refunded'];

        foreach ($statuses as $status) {
            Status::updateOrInsert(
                ['name' => ucfirst($status)],
                ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        }
    }
}
