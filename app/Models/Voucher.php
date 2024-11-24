<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use SoftDeletes, HasFactory;

    const LIMIT = 10;

    protected $fillable = [
        'code',
        'user_id',
        'description',
        'amount',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voucherStatus()
    {
        return $this->belongsTo(VoucherStatus::class);
    }

    public static function getVoucher(string $code)
    {
        return Voucher::where('code', $code)->first();
    }
}
