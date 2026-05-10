<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id'     => 'required|exists:customers,id',

            'promo_code'      => 'nullable|exists:vouchers,code',

            'post_office_id'  => 'required|exists:post_offices,id',
            'shipping_fee'    => 'required|numeric|min:0',
            'total_amount'    => 'required|numeric|min:0',
            'dest_address'    => 'required|string|max:255',
            'order_date'      => 'required|date',
            'payment_status'  => 'required|string|max:50',
            'shipping_status' => 'required|string|max:50',
            'note'            => 'nullable|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
