<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SellerRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Cho phép tất cả các yêu cầu
        return true;
    }

    public function rules(): array
    {
        // Quy tắc xác thực cho yêu cầu người bán
        return [
            'seller_name'          => 'required|string|max:100',
            'seller_phone_number'  => 'required|string|max:15',
        ];
    }

    // Xử lý khi xác thực thất bại để trả về phản hồi JSON
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
