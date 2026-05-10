<?php

namespace App\Http\Controllers\API;

use App\Models\OrderItem;
use App\Http\Requests\OrderItemRequest;

class OrderItemController
{
    // ============================
    // 1. Danh sách order items
    // ============================
    public function index()
    {
        $items = OrderItem::with(['order', 'product'])->paginate(10);

        // Trả về danh sách order items với phân trang
        return response()->json($items);
    }

    // ============================
    // 2. Tạo mới order item
    // ============================
    public function store(OrderItemRequest $request)
    {
        $item = OrderItem::create($request->validated());

        // Trả về thông tin order item vừa tạo
        return response()->json([
            'message' => 'Thêm sản phẩm vào đơn hàng thành công',
            'data' => $item
        ], 201);
    }

    // ============================
    // 3. Chi tiết order item
    // ============================
    public function show($id)
    {
        $item = OrderItem::with(['order', 'product'])->find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy record'], 404);
        }

        // Trả về thông tin chi tiết order item
        return response()->json($item);
    }

    // ============================
    // 4. Cập nhật order item
    // ============================
    public function update(OrderItemRequest $request, $id)
    {
        $item = OrderItem::find($id);

        // Kiểm tra nếu không tìm thấy order item
        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy record'], 404);
        }

        $item->update($request->validated());

        // Trả về thông tin order item sau khi cập nhật
        return response()->json([
            'message' => 'Cập nhật thành công',
            'data' => $item
        ]);
    }

    // ============================
    // 5. Xóa order item
    // ============================
    public function destroy($id)
    {
        $item = OrderItem::find($id);

        // Kiểm tra nếu không tìm thấy order item
        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy record'], 404);
        }

        $item->delete();

        // Trả về phản hồi sau khi xóa
        return response()->json(['message' => 'Xóa thành công']);
    }
}
