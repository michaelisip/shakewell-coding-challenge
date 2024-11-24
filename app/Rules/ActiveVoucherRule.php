<?php

namespace App\Rules;

use App\Models\Voucher;
use App\Models\VoucherStatus;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ActiveVoucherRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $voucher = Voucher::getVoucher($value);

        $activeStatus = VoucherStatus::getStatus('active');

        if ($voucher->voucherStatus != $activeStatus) {
            $fail('The voucher code is either invalid or inactive.');
        }
    }
}
