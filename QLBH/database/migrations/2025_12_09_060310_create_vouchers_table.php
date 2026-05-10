<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tạo bảng Phiếu giảm giá
return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();        // Mã giảm giá
            $table->enum('type', ['percent', 'fixed']);   // Giảm % hoặc số tiền cố định
            $table->decimal('value', 10, 2);              // Giá trị giảm
            $table->decimal('min_order', 10, 2)->nullable(); // Đơn tối thiểu để áp
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('quantity')->default(0);      // số lượng còn lại
            $table->enum('status', ['active', 'inactive']); // trạng thái
            $table->timestamps();
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
