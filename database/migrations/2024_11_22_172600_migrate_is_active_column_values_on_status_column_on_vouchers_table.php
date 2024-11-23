<?php

use App\Models\Voucher;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Voucher::query()
            ->update([
                'voucher_status_id' => DB::raw("
                    CASE
                        WHEN is_active = 1 THEN 2
                        WHEN is_active = 0 THEN 1
                        ELSE NULL
                    END
                ")
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
