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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // tên chương trình khuyến mãi
            $table->text('description')->nullable(); // mô tả thêm
            $table->unsignedTinyInteger('discount_percent'); // phần trăm giảm
            $table->dateTime('start_date'); // ngày bắt đầu
            $table->dateTime('end_date');   // ngày kết thúc
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_seeders');
    }
};
