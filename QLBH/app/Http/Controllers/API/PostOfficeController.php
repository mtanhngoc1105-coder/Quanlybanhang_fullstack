<?php

namespace App\Http\Controllers\API;

use App\Models\PostOffice;
use App\Http\Requests\PostOfficeRequest;

class PostOfficeController
{
    // ==================================
    // 1. Danh sách bưu cục
    // ==================================
    public function index()
    {
        $postOffices = PostOffice::with('seller')->paginate(10);

        // Trả về danh sách bưu cục với phân trang
        return response()->json([
            'message' => 'Danh sách bưu cục',
            'data' => $postOffices
        ]);
    }

    // ==================================
    // 2. Tạo bưu cục mới
    // ==================================
    public function store(PostOfficeRequest $request)
    {
        $postOffice = PostOffice::create($request->validated());

        // Trả về thông tin bưu cục vừa tạo
        return response()->json([
            'message' => 'Tạo bưu cục thành công',
            'data' => $postOffice
        ]);
    }

    // ==================================
    // 3. Chi tiết bưu cục
    // ==================================
    public function show($id)
    {
        $postOffice = PostOffice::with('seller')->find($id);

        // Kiểm tra nếu không tìm thấy bưu cục
        if (!$postOffice) {
            return response()->json([
                'message' => 'Không tìm thấy bưu cục'
            ], 404);
        }

        // Trả về thông tin chi tiết bưu cục
        return response()->json([
            'message' => 'Chi tiết bưu cục',
            'data' => $postOffice
        ]);
    }

    // ==================================
    // 4. Cập nhật bưu cục
    // ==================================
    public function update(PostOfficeRequest $request, $id)
    {
        $postOffice = PostOffice::find($id);

        //  Kiểm tra nếu không tìm thấy bưu cục
        if (!$postOffice) {
            return response()->json([
                'message' => 'Không tìm thấy bưu cục'
            ], 404);
        }

        $postOffice->update($request->validated());

        // Trả về thông tin bưu cục sau khi cập nhật
        return response()->json([
            'message' => 'Cập nhật bưu cục thành công',
            'data' => $postOffice
        ]);
    }

    // ==================================
    // 5. Xóa bưu cục
    // ==================================
    public function destroy($id)
    {
        $postOffice = PostOffice::find($id);

        // Kiểm tra nếu không tìm thấy bưu cục
        if (!$postOffice) {
            return response()->json([
                'message' => 'Không tìm thấy bưu cục'
            ], 404);
        }

        $postOffice->delete();

        // Trả về phản hồi sau khi xóa
        return response()->json([
            'message' => 'Xóa bưu cục thành công'
        ]);
    }
}
