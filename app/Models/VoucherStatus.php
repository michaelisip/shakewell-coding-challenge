<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherStatus extends Model
{
    protected $table = 'voucher_statuses';

    public const STATUSES = [
        'INACTIVE' => 'inactive',
        'ACTIVE' => 'active',
        'EXPIRED' => 'expired',
        'LIMIT_REACHED' => 'limit_reached',
    ];

    public function getStatuses()
    {
        return array_values(self::STATUSES);
    }

    public static function getStatus($name)
    {
        return VoucherStatus::where('name', $name)->first();
    }
}
