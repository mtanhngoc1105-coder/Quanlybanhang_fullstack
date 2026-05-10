<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tạo bảng Tài xế
return new class extends Migration
{
    // Run the migrations.
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('driver_name', 100);
            $table->string('driver_phone', 15);
            $table->string('status', 50);
            $table->string('plate_number', 20)->unique();
            $table->timestamps();
        });
    }

    // Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
