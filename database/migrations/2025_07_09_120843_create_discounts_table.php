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
        $table->string('code');
        $table->text('description')->nullable();
        $table->decimal('discount_value', 15, 2);
        $table->enum('discount_type', ['percent', 'amount']);
        $table->integer('quantity');
        $table->bigInteger('minimum_order_value')->nullable(); // SỬA: dùng bigInteger
        $table->bigInteger('max_discount_value')->nullable();  // SỬA: dùng bigInteger
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
