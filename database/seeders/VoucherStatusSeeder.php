<?php

namespace Database\Seeders;

use App\Models\VoucherStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class VoucherStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $voucherStatus = new VoucherStatus();
        $statuses = $voucherStatus->getStatuses();

        foreach ($statuses as $key => $status) {
            $newStatus = VoucherStatus::firstOrCreate(
                ['key' => Str::upper($status)],
                ['name' => $status],
            );
        }
    }
}
