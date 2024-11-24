<?php

namespace App\Http\Controllers\Vouchers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vouchers\ApplyRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function apply(ApplyRequest $request)
    {
        $originalPrice = $request->original_price;
        $voucher = Voucher::getVoucher($request->voucher);

        if ($voucher->type === 'percentage') {
            $discountPercentage = $voucher->value * 100;
            $discountValue = ($originalPrice * $discountPercentage) / 100;
        } else {
            $discountValue = $voucher->value;
        }

        $finalPrice = $originalPrice - $discountValue;

        return response()->json([
            'message' => 'Discount applied successfully.',
            'original_price' => $originalPrice,
            'discount_value' => $discountValue,
            'final_price' => $finalPrice,
            'voucher' => $voucher,
        ]);
    }
}
