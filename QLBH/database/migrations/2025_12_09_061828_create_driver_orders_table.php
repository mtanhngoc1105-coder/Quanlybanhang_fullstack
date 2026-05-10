<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tạo bảng Đơn hàng của Tài xế
return new class extends Migration
{
    public function up(): void
    {
        // Bảng liên kết giữa Đơn hàng và Tài xế
        Schema::create('driver_orders', function (Blueprint $table) {
            // Khóa ngoại
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('driver_id');
            $table->dateTime('assign_date')->nullable();

            // Khóa chính kết hợp
            $table->primary(['order_id', 'driver_id']);

            // Ràng buộc khóa ngoại
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Xóa bảng liên kết
        Schema::dropIfExists('driver_orders');
    }
};
