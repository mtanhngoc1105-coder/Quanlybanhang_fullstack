<?php

namespace App\Http\Controllers\API;

use App\Models\Review;
use App\Http\Requests\ReviewRequest;

class ReviewController
{
    // ==========================
    // 1. Danh sách reviews
    // ==========================
    public function index()
    {
        $reviews = Review::with(['order', 'customer'])
            ->paginate(10);

            // Trả về danh sách đánh giá với phân trang
        return response()->json([
            'message' => 'Danh sách đánh giá',
            'data' => $reviews
        ]);
    }

    // ==========================
    // 2. Tạo review
    // ==========================
    public function store(ReviewRequest $request)
    {
        $review = Review::create($request->validated());
        $review->load(['order', 'customer']);

        // Trả về thông tin đánh giá vừa tạo
        return response()->json([
            'message' => 'Tạo đánh giá thành công',
            'data' => $review
        ], 201);
    }

    // ==========================
    // 3. Chi tiết review
    // ==========================
    public function show($id)
    {
        $review = Review::with(['order', 'customer'])->findOrFail($id);

        // Trả về thông tin chi tiết đánh giá
        return response()->json([
            'message' => 'Chi tiết đánh giá',
            'data' => $review
        ]);
    }

    // ==========================
    // 4. Cập nhật review
    // ==========================
    public function update(ReviewRequest $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->update($request->validated());

        // Trả về thông tin đánh giá sau khi cập nhật
        return response()->json([
            'message' => 'Cập nhật đánh giá thành công',
            'data' => $review
        ]);
    }

    // ==========================
    // 5. Xóa review
    // ==========================
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        // Trả về phản hồi sau khi xóa
        return response()->json([
            'message' => 'Xóa đánh giá thành công'
        ]);
    }
}
