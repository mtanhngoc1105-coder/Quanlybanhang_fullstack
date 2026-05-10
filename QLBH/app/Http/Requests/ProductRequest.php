<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_code' => 'required|string|max:50|unique:products,product_code,' . $this->route('id'),
            'product_name' => 'required|string|max:100',
            'price'        => 'required|numeric|min:0',

            // thêm validate mới
            'category_id'  => 'nullable|exists:categories,id',
            'state'        => 'required|in:active,inactive,out_of_stock',
            'quantity'     => 'required|integer|min:0',
            'details'      => 'nullable|string',
            
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}