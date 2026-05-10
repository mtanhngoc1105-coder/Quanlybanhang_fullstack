<?php

use Illuminate\Support\Facades\Route;

//  IMPORT ĐÚNG CONTROLLER API
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

// ================= API RESOURCE =================
Route::apiResource('sellers', SellerController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('customers', CustomerController::class);
Route::apiResource('vouchers', VoucherController::class);
Route::apiResource('drivers', DriverController::class);
Route::apiResource('postoffices', PostOfficeController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-items', OrderItemController::class);
Route::apiResource('reviews', ReviewController::class);
Route::apiResource('driver-orders', DriverOrderController::class);
Route::apiResource('categories', CategoryController::class);