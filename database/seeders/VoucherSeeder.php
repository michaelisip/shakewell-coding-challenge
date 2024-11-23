<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // fixed vouchers
        Voucher::factory()
            ->fixed()
            ->expiration()
            ->count(10)
            ->create();

        // percentage vouchers
        Voucher::factory()
            ->percentage()
            ->expiration()
            ->count(10)
            ->create();
    }
}
