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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id(); // id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY
            $table->unsignedBigInteger('product_variant_id')->nullable(); // BIGINT UNSIGNED DEFAULT NULL
            $table->string('image_url'); // VARCHAR(255) NOT NULL
            $table->string('alt_text')->nullable(); // VARCHAR(255) DEFAULT NULL
            $table->integer('sort_order'); // INT NOT NULL
            $table->timestamps(); // created_at, updated_at

            // Foreign key constraint (chỉ thêm khi dữ liệu hợp lệ)
            $table->foreign('product_variant_id')
                  ->references('id')->on('product_variants')
                  ->onDelete('restrict')->onUpdate('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
