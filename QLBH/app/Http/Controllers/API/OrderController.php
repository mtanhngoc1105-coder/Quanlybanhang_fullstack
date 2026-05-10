<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Http\Requests\OrderRequest;

class OrderController
{
    // ============================
    // 1. Danh sách Orders
    // ============================
    public function index()
    {
        $search = request()->input('search');

        $query = Order::with(['customer', 'postOffice', 'voucher']);

        if ($search) {
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        return response()->json([
            'message' => 'Danh sách đơn hàng',
            'data' => $query->paginate(10)
        ]);
    }

    // ============================
    // 2. Tạo đơn hàng
    // ============================
    public function store(OrderRequest $request)
    {
        $order = Order::create($request->validated());

        // load lại quan hệ
        $order->load(['customer', 'postOffice', 'voucher']);

        return response()->json([
            'message' => 'Tạo đơn hàng thành công',
            'data' => $order
        ], 201);
    }

    // ============================
    // 3. Chi tiết đơn hàng
    // ============================
    public function show($id)
    {
        $order = Order::with([
            'customer',
            'postOffice',
            'voucher',
            'items.product'
        ])->find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Không tìm thấy đơn hàng'
            ], 404);
        }

        return response()->json([
            'message' => 'Chi tiết đơn hàng',
            'data' => $order
        ]);
    }

    // ============================
    // 4. Cập nhật
    // ============================
    public function update(OrderRequest $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Không tìm thấy đơn hàng'
            ], 404);
        }

        $order->update($request->validated());
        $order->load(['customer', 'postOffice', 'voucher']);

        return response()->json([
            'message' => 'Cập nhật đơn hàng thành công',
            'data' => $order
        ]);
    }

    // ============================
    // 5. Xóa
    // ============================
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Không tìm thấy đơn hàng'
            ], 404);
        }

        $order->delete();

        return response()->json([
            'message' => 'Xóa đơn hàng thành công'
        ]);
    }
}
