<?php

namespace App\Rules;

use App\Models\Voucher;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MinimumPurchaseRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $voucher = Voucher::getVoucher($value);
        $totalAmount = request()->input('original_price');

        if ($totalAmount < $voucher->minimum_purchase) {
            $fail('Total amount does not meet the minimum purchase requirement to apply the voucher.');
        }
    }
}
