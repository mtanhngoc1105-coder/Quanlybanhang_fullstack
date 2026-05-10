<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Cho phép tất cả các yêu cầu
        return true;
    }

    public function rules(): array
    {
        // Quy tắc xác thực cho yêu cầu đánh giá
        return [
            'order_id' => 'required|exists:orders,id',
            'customer_id' => 'required|exists:customers,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        // Thông điệp tùy chỉnh cho các lỗi xác thực
        return [
            'order_id.required' => 'Vui lòng chọn đơn hàng.',
            'customer_id.required' => 'Vui lòng chọn khách hàng.',
            'rating.required' => 'Vui lòng đánh giá số sao.',
            'rating.min' => 'Số sao phải từ 1 đến 5.',
            'rating.max' => 'Số sao phải từ 1 đến 5.',
        ];
    }
}
