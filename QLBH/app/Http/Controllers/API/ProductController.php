<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class ProductController
{
    // =====================================
    // 1. Danh sách sản phẩm (search + filter + paginate)
    // =====================================
    public function index(Request $request)
    {
        $search      = $request->input('search');
        $categoryId  = $request->input('category_id');
        $state       = $request->input('state');

        // eager load category để frontend dùng luôn
        $query = Product::with('category');

        //  search theo tên
            if ($search) {
    $query->where(function ($q) use ($search) {
        $q->where('product_name', 'like', "%$search%")
          ->orWhere('product_code', 'like', "%$search%");
    });
}
        //  filter theo category
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        //  filter theo state
        if ($state) {
            $query->where('state', $state);
        }

        $products = $query->latest()->paginate(10);

        return response()->json([
            'status' => true,
            'data'   => $products
        ]);
    }

    // =====================================
    // 2. Tạo sản phẩm
    // =====================================
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());

        return response()->json([
            'status'  => true,
            'message' => 'Product created successfully',
            'data'    => $product
        ], 201);
    }

    // =====================================
    // 3. Chi tiết sản phẩm
    // =====================================
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $product
        ]);
    }

    // =====================================
    // 4. Update sản phẩm
    // =====================================
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());

        return response()->json([
            'status'  => true,
            'message' => 'Product updated successfully',
            'data'    => $product
        ]);
    }

    // =====================================
    // 5. Xóa sản phẩm
    // =====================================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product deleted successfully'
        ]);
    }
}