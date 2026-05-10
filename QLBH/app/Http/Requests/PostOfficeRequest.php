<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostOfficeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seller_id'      => 'required|exists:sellers,id',
            'branch_office'  => 'required|string|max:100',
            'post_add'       => 'required|string|max:255',
            'hotline'        => 'required|string|max:15',
            'operating_hour' => 'required|string|max:50',
        ];
    }

    // 🔥 BẮT BUỘC: ép trả JSON khi lỗi
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
