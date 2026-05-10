<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tạo bảng Người bán
return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id(); // SellerID
            $table->string('seller_name', 100);
            $table->string('seller_phone_number', 15);
            $table->timestamps();
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
