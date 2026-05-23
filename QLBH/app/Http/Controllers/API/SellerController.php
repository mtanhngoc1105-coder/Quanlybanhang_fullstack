<?php

namespace App\Http\Controllers\API;

use App\Models\Seller;
use App\Http\Requests\SellerRequest;
use Illuminate\Http\Request;

class SellerController
{
    // =====================================
    // 1. Danh sách Seller (có search + paginate)
    // =====================================
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Seller::query();

        // Nếu có từ khóa tìm kiếm, thêm điều kiện lọc
        if ($search) {
            $query->where('seller_name', 'like', "%$search%");
        }

        // Trả về danh sách Seller với phân trang
        return response()->json([
            'status' => true,
            'message' => 'Danh sách người bán',
            'data' => $query->paginate(10)
        ]);
    }

    // =====================================
    // 2. Tạo Seller
    // =====================================
    public function store(SellerRequest $request)
    {
        $seller = Seller::create($request->validated());

        // Trả về thông tin Seller vừa tạo
        return response()->json($seller, 201);
    }

    // =====================================
    // 3. Lấy chi tiết Seller
    // =====================================
    public function show($id)
    {
        $seller = Seller::findOrFail($id);

        // Trả về thông tin chi tiết Seller
        return response()->json($seller);
    }

    // =====================================
    // 4. Cập nhật Seller
    // =====================================
    public function update(SellerRequest $request, $id)
    {
        $seller = Seller::findOrFail($id);

        $seller->update($request->validated());

        // Trả về thông tin Seller sau khi cập nhật
        return response()->json([
            'message' => 'Seller updated successfully',
            'data' => $seller
        ]);
    }

    // =====================================
    // 5. Xóa Seller
    // =====================================
    public function destroy($id)
    {
        Seller::destroy($id);

        // Trả về phản hồi sau khi xóa
        return response()->json([
            'message' => 'Seller deleted successfully'
        ]);
    }
}
