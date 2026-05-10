<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code'       => 'required|string|max:50|unique:vouchers,code,' . $this->route('voucher'),
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|numeric|min:1',
            'min_order'  => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'quantity'   => 'required|integer|min:0',
            'status'     => 'required|in:active,inactive',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Vui lòng nhập mã voucher.',
            'code.unique'   => 'Mã voucher đã tồn tại.',

            'type.required' => 'Vui lòng chọn loại voucher.',
            'type.in'       => 'Loại voucher không hợp lệ.',

            'value.required' => 'Vui lòng nhập giá trị giảm.',
            'value.numeric'  => 'Giá trị giảm phải là số.',
            'value.min'      => 'Giá trị giảm phải lớn hơn 0.',

            'start_date.required' => 'Vui lòng nhập ngày bắt đầu.',
            'end_date.required'   => 'Vui lòng nhập ngày kết thúc.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',

            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer'  => 'Số lượng phải là số nguyên.',
            'quantity.min'      => 'Số lượng không được âm.',

            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in'       => 'Trạng thái không hợp lệ.',
        ];
    }

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
