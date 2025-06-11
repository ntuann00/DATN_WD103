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
            $table->string('code')->unique(); // Mã khuyến mãi
            $table->string('description')->nullable();
            $table->decimal('discount_value', 8, 2); // Giá trị giảm giá
            $table->enum('discount_type', ['percent', 'fixed']); // Loại: phần trăm hoặc cố định
            $table->integer('quantity')->nullable(); // Số lượng mã khuyến mãi
            $table->decimal('minimum_order_value', 10, 2)->nullable();
            $table->decimal('max_discount_value', 10, 2)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
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
