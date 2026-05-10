<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\CustomerRequest;

class CustomerController extends Controller
{
    // ===============================
    // 1. Danh sách khách hàng
    // ===============================
    public function index()
    {
        $customers = Customer::paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Danh sách khách hàng',
            'data' => $customers
        ]);
    }

    // ===============================
    // 2. Tạo khách hàng mới
    // ===============================
    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Tạo khách hàng thành công',
            'data' => $customer
        ], 201);
    }

    // ===============================
    // 3. Chi tiết 1 khách hàng
    // ===============================
    public function show(Customer $customer)
    {
        return response()->json([
            'status' => true,
            'message' => 'Chi tiết khách hàng',
            'data' => $customer
        ]);
    }

    // ===============================
    // 4. Cập nhật khách hàng
    // ===============================
    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật khách hàng thành công',
            'data' => $customer
        ]);
    }

    // ===============================
    // 5. Xóa khách hàng
    // ===============================
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa khách hàng thành công'
        ]);
    }
}
