<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DriverRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'driver_name'  => 'required|string|max:100',
            'driver_phone' => 'required|string|max:15',
            'status'       => 'required|in:active,inactive',
            'plate_number' => 'required|string|max:20|unique:drivers,plate_number,' . $this->route('driver'),
        ];
    }

    /**
     * ❗ FIX: Không cho Laravel trả HTML
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors'  => $validator->errors()
            ], 422)
        );
    }
}
