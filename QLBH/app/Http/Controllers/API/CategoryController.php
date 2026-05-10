<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // ===============================
    // GET ALL CATEGORIES (tree)
    // ===============================
    public function index()
    {
        $categories = Category::whereNull('parent_id')
                        ->with('children')
                        ->orderBy('id','asc')
                        ->get();

        return response()->json([
            'status' => true,
            'data' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create(
            [...$request->validated(), 'slug' => Str::slug($request->name)]
            );

        return response()->json([
            'status' => true,
            'data' => $category
        ], 201);
    }

    // ===============================
    // DELETE CATEGORY
    // ===============================
    public function destroy($id)
    {
        Category::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Deleted successfully'
        ]);
    }

    // ===============================
    // SHOW DETAIL
    // ===============================
    public function show(Category $category)
    {
        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }

    // ===============================
    // UPDATE CATEGORY
    // ===============================
    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }
}