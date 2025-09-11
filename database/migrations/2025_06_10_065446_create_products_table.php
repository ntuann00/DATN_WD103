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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // FK
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('attribute_id')->nullable();
            $table->unsignedBigInteger('promotion_id')->nullable();

            $table->string('brand');
            $table->text('description');
            $table->boolean('status')->default(true); // true: active, false: inactive
            $table->timestamps();

            // relationship
            // $table->foreign('productVariant_id')->references('id')->on('product_variants')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('set null');
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
