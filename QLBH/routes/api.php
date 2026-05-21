<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SellerController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\VoucherController;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\API\PostOfficeController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\OrderItemController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\DriverOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\JwtAuthMiddleware;

// ====================== PUBLIC ROUTES ======================
Route::post('login', [AuthController::class, 'login']);

// Công khai: ai cũng có thể xem dữ liệu (chỉ GET)
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{id}', [CategoryController::class, 'show']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);

Route::get('sellers', [SellerController::class, 'index']);
Route::get('sellers/{id}', [SellerController::class, 'show']);

Route::get('reviews', [ReviewController::class, 'index']);
Route::get('reviews/{id}', [ReviewController::class, 'show']);

Route::get('vouchers', [VoucherController::class, 'index']);
Route::get('vouchers/{id}', [VoucherController::class, 'show']);

Route::get('drivers', [DriverController::class, 'index']);
Route::get('drivers/{id}', [DriverController::class, 'show']);

Route::get('postoffices', [PostOfficeController::class, 'index']);
Route::get('postoffices/{id}', [PostOfficeController::class, 'show']);

Route::get('orders', [OrderController::class, 'index']);
Route::get('orders/{id}', [OrderController::class, 'show']);

Route::get('order-items', [OrderItemController::class, 'index']);
Route::get('order-items/{id}', [OrderItemController::class, 'show']);

Route::get('driver-orders', [DriverOrderController::class, 'index']);
Route::get('driver-orders/{id}', [DriverOrderController::class, 'show']);

// ====================== PROTECTED ROUTES ======================
Route::middleware([JwtAuthMiddleware::class])->group(function () {
    Route::get('me', [AuthController::class, 'profile']);

    // POST, PUT, DELETE - chỉ admin/authenticated users
    Route::post('sellers', [SellerController::class, 'store']);
    Route::put('sellers/{id}', [SellerController::class, 'update']);
    Route::delete('sellers/{id}', [SellerController::class, 'destroy']);
    
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
    
    Route::apiResource('customers', CustomerController::class);
    
    Route::post('vouchers', [VoucherController::class, 'store']);
    Route::put('vouchers/{id}', [VoucherController::class, 'update']);
    Route::delete('vouchers/{id}', [VoucherController::class, 'destroy']);
    
    Route::post('drivers', [DriverController::class, 'store']);
    Route::put('drivers/{id}', [DriverController::class, 'update']);
    Route::delete('drivers/{id}', [DriverController::class, 'destroy']);
    
    Route::post('postoffices', [PostOfficeController::class, 'store']);
    Route::put('postoffices/{id}', [PostOfficeController::class, 'update']);
    Route::delete('postoffices/{id}', [PostOfficeController::class, 'destroy']);
    
    Route::post('orders', [OrderController::class, 'store']);
    Route::put('orders/{id}', [OrderController::class, 'update']);
    Route::delete('orders/{id}', [OrderController::class, 'destroy']);
    
    Route::post('order-items', [OrderItemController::class, 'store']);
    Route::put('order-items/{id}', [OrderItemController::class, 'update']);
    Route::delete('order-items/{id}', [OrderItemController::class, 'destroy']);
    
    Route::post('reviews', [ReviewController::class, 'store']);
    Route::put('reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('reviews/{id}', [ReviewController::class, 'destroy']);
    
    Route::post('driver-orders', [DriverOrderController::class, 'store']);
    Route::put('driver-orders/{id}', [DriverOrderController::class, 'update']);
    Route::delete('driver-orders/{id}', [DriverOrderController::class, 'destroy']);
    
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
});
