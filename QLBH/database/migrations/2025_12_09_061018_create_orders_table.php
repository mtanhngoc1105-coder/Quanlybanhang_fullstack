<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tạo bảng Đơn hàng
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Khách hàng
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->onDelete('cascade');

            // Mã giảm giá
            $table->string('promo_code', 50)->nullable();
            $table->foreign('promo_code')->references('code')->on('vouchers')->nullOnDelete();

            // Bưu cục
            $table->foreignId('post_office_id')
                  ->constrained('post_offices')
                  ->onDelete('cascade');

             // Thông tin đơn hàng
            $table->decimal('shipping_fee', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('dest_address', 255);
            $table->dateTime('order_date');
            $table->string('payment_status', 50);
            $table->string('shipping_status', 50);
            $table->string('note', 255)->nullable();

            $table->timestamps();
        });
    }
     // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
