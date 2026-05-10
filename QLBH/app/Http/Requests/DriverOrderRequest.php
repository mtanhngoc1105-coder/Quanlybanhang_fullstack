<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DriverOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Cho phép tất cả các yêu cầu
        return true;
    }

    public function rules(): array
    {
        // Quy tắc xác thực cho yêu cầu gán đơn hàng cho tài xế
        return [
            'order_id' => 'required|exists:orders,id',
            'driver_id' => 'required|exists:drivers,id',
            'assign_date' => 'nullable|date',
        ];
    }

    public function messages(): array
    {
        // Thông điệp tùy chỉnh cho các lỗi xác thực
        return [
            'order_id.required' => 'Vui lòng chọn đơn hàng.',
            'driver_id.required' => 'Vui lòng chọn tài xế.',
        ];
    }
}
