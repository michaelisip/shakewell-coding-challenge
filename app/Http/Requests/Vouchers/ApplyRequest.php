<?php

namespace App\Http\Requests\Vouchers;

use App\Rules\ActiveVoucherRule;
use App\Rules\MinimumPurchaseRule;
use Illuminate\Foundation\Http\FormRequest;

class ApplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'voucher' => [
                'bail',
                'required',
                'exists:vouchers,code',
                new ActiveVoucherRule,
                new MinimumPurchaseRule
            ],
            'original_price' =>  'required|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'voucher.exists' => 'The voucher code is either invalid or inactive.',
        ];
    }
}
