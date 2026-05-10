<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tạo bảng Bưu cục
return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('post_offices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            $table->string('branch_office', 100);
            $table->string('post_add', 255);
            $table->string('hotline', 15);
            $table->string('operating_hour', 50);
            $table->timestamps();
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('post_offices');
    }
};
