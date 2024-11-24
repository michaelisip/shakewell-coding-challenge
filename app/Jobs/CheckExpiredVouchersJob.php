<?php

namespace App\Jobs;

use App\Models\Voucher;
use App\Models\VoucherStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CheckExpiredVouchersJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $activeStatus = VoucherStatus::getStatus('active');
        $expiredStatus = VoucherStatus::getStatus('expired');

        Voucher::where('end_date', '<', now())
            ->where('voucher_status_id', $activeStatus->id)
            ->update([
                'voucher_status_id' => $expiredStatus->id
            ]);
    }
}
