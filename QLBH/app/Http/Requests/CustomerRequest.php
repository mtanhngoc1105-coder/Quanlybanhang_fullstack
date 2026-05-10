<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Cho phép request chạy
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Rule validate
     */
    public function rules(): array
    {
        // Lấy customer id khi update (route model binding)
        $customerId = $this->route('customer')?->id;

        return [
            'name' => 'required|string|max:100',

            // Khi update sẽ bỏ qua email của chính customer đó
            'email' => 'required|email|max:100|unique:customers,email,' . $customerId,

            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ];
    }

    /**
     * Message lỗi tiếng Việt
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên khách hàng.',
            'name.string'   => 'Tên khách hàng phải là chuỗi.',
            'name.max'      => 'Tên khách hàng tối đa 100 ký tự.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email'    => 'Email không đúng định dạng.',
            'email.unique'   => 'Email đã tồn tại.',
            'email.max'      => 'Email tối đa 100 ký tự.',

            'phone.string' => 'Số điện thoại phải là chuỗi.',
            'phone.max'    => 'Số điện thoại tối đa 20 ký tự.',

            'address.string' => 'Địa chỉ phải là chuỗi.',
            'address.max'    => 'Địa chỉ tối đa 255 ký tự.',
        ];
    }

    /**
     * BẮT BUỘC: ép trả JSON khi validate lỗi
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}
