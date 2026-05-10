<?php

namespace App\Http\Controllers\API;

use App\Models\Voucher;
use App\Http\Requests\VoucherRequest;

class VoucherController
{
    // ===============================
    // 1. Danh sách voucher
    // ===============================
    public function index()
    {
        $vouchers = Voucher::paginate(10);

        // Trả về danh sách voucher với phân trang
        return response()->json([
            'message' => 'Danh sách voucher',
            'data' => $vouchers
        ]);
    }

    // ===============================
    // 2. Tạo mới
    // ===============================
    public function store(VoucherRequest $request)
    {
        $voucher = Voucher::create($request->validated());

        // Trả về thông tin voucher vừa tạo
        return response()->json([
            'message' => 'Tạo voucher thành công',
            'data' => $voucher
        ]);
    }

    // ===============================
    // 3. Chi tiết
    // ===============================
    public function show($id)
    {
        $voucher = Voucher::find($id);

        // Kiểm tra nếu không tìm thấy voucher
        if (!$voucher) {
            return response()->json([
                'message' => 'Không tìm thấy voucher'
            ], 404);
        }

        // Trả về thông tin chi tiết voucher
        return response()->json([
            'message' => 'Chi tiết voucher',
            'data' => $voucher
        ]);
    }

    // ===============================
    // 4. Cập nhật
    // ===============================
    public function update(VoucherRequest $request, $id)
    {
        $voucher = Voucher::find($id);

        // Kiểm tra nếu không tìm thấy voucher
        if (!$voucher) {
            return response()->json([
                'message' => 'Không tìm thấy voucher'
            ], 404);
        }

        $voucher->update($request->validated());

        // Trả về thông tin voucher sau khi cập nhật
        return response()->json([
            'message' => 'Cập nhật voucher thành công',
            'data' => $voucher
        ]);
    }

    // ===============================
    // 5. Xóa
    // ===============================
    public function destroy($id)
    {
        $voucher = Voucher::find($id);

        // Kiểm tra nếu không tìm thấy voucher
        if (!$voucher) {
            return response()->json([
                'message' => 'Không tìm thấy voucher'
            ], 404);
        }

        $voucher->delete();

        // Trả về phản hồi sau khi xóa
        return response()->json([
            'message' => 'Xóa voucher thành công'
        ]);
    }
}
