<?php

namespace App\Http\Controllers\API;

use App\Models\DriverOrder;
use App\Http\Requests\DriverOrderRequest;

class DriverOrderController
{
    // ==========================
    // 1. Danh sách tài xế - đơn hàng
    // ==========================
    public function index()
    {
        $data = DriverOrder::with(['order', 'driver'])->get();

        // Trả về danh sách tài xế - đơn hàng
        return response()->json([
            'message' => 'Danh sách tài xế - đơn hàng',
            'data' => $data
        ]);
    }

    // ==========================
    // 2. Gán tài xế cho đơn hàng
    // ==========================
    public function store(DriverOrderRequest $request)
    {
        $driverOrder = DriverOrder::create($request->validated());

        // Trả về thông tin quan hệ vừa tạo
        return response()->json([
            'message' => 'Gán tài xế thành công',
            'data' => $driverOrder
        ], 201);
    }

    // ==========================
    // 3. Chi tiết
    // ==========================
    public function show($order_id)
    {
        $data = DriverOrder::where('order_id', $order_id)
            ->with(['order', 'driver'])
            ->get();

            // Trả về thông tin chi tiết tài xế theo đơn hàng
        return response()->json([
            'message' => 'Chi tiết tài xế theo đơn hàng',
            'data' => $data
        ]);
    }

    // ==========================
    // 4. Cập nhật (chỉ cập nhật assign_date)
    // ==========================
    public function update(DriverOrderRequest $request, $order_id)
    {
        $driverOrder = DriverOrder::where('order_id', $order_id)
            ->where('driver_id', $request->driver_id)
            ->firstOrFail();

        $driverOrder->update($request->validated());

        // Trả về thông tin sau khi cập nhật
        return response()->json([
            'message' => 'Cập nhật thành công',
            'data' => $driverOrder
        ]);
    }

    // ==========================
    // 5. Xóa quan hệ (bỏ giao tài xế)
    // ==========================
    public function destroy($order_id)
    {
        DriverOrder::where('order_id', $order_id)->delete();

        // Trả về phản hồi sau khi xóa
        return response()->json([
            'message' => 'Hủy giao tài xế thành công'
        ]);
    }
}
