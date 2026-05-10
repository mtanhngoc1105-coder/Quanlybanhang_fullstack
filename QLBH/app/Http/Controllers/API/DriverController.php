<?php

namespace App\Http\Controllers\API;

use App\Models\Driver;
use App\Http\Requests\DriverRequest;

class DriverController
{
    // ===============================
    // 1. Danh sách tài xế
    // ===============================
    public function index()
    {
        $drivers = Driver::paginate(10);

        // Trả về danh sách tài xế với phân trang
        return response()->json([
            'message' => 'Danh sách tài xế',
            'data' => $drivers
        ]);
    }

    // ===============================
    // 2. Tạo mới tài xế
    // ===============================
    public function store(DriverRequest $request)
    {
        $driver = Driver::create($request->validated());

        // Trả về thông tin tài xế vừa tạo
        return response()->json([
            'message' => 'Tạo tài xế thành công',
            'data' => $driver
        ]);
    }

    // ===============================
    // 3. Chi tiết tài xế
    // ===============================
    public function show($id)
    {
        $driver = Driver::find($id);

        // Kiểm tra nếu không tìm thấy tài xế
        if (!$driver) {
            return response()->json([
                'message' => 'Không tìm thấy tài xế'
            ], 404);
        }

        // Trả về thông tin chi tiết tài xế
        return response()->json([
            'message' => 'Chi tiết tài xế',
            'data' => $driver
        ]);
    }

    // ===============================
    // 4. Cập nhật tài xế
    // ===============================
    public function update(DriverRequest $request, $id)
    {
        $driver = Driver::find($id);

        //  Kiểm tra nếu không tìm thấy tài xế
        if (!$driver) {
            
            return response()->json([
                'message' => 'Không tìm thấy tài xế'
            ], 404);
        }

        $driver->update($request->validated());

        // Trả về thông tin tài xế sau khi cập nhật
        return response()->json([
            'message' => 'Cập nhật tài xế thành công',
            'data' => $driver
        ]);
    }

    // ===============================
    // 5. Xóa tài xế
    // ===============================
    public function destroy($id)
    {
        $driver = Driver::find($id);

        // Kiểm tra nếu không tìm thấy tài xế
        if (!$driver) {
            return response()->json([
                'message' => 'Không tìm thấy tài xế'
            ], 404);
        }

        // Xóa tài xế
        $driver->delete();

        // Trả về phản hồi sau khi xóa
        return response()->json([
            'message' => 'Xóa tài xế thành công'
        ]);
    }
}
