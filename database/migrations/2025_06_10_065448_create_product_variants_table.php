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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            // FK
            $table->unsignedBigInteger('product_id');
            $table->string('sku')->unique();
            $table->string('color')->nullable();
            $table->string('capacity')->nullable();
            $table->string('scent')->nullable();
            $table->string('texture')->nullable();
            $table->timestamps();

            // relationship
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
