<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // tên category
            $table->string('name');

            // slug để dùng cho URL (ví dụ /category/anime-figure)
            $table->string('slug')->unique();

            // ảnh category (nếu có)
            $table->string('image')->nullable();

            //  quan trọng: category cha – con
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('categories')
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};