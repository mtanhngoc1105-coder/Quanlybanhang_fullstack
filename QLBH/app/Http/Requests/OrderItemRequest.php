<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Cho phép tất cả các yêu cầu
        return true;
    }

    public function rules(): array
    {
        // Quy tắc xác thực cho yêu cầu mục đơn hàng
        return [
            'order_id'   => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
        ];
    }
}
