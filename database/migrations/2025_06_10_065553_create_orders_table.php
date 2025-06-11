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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // FK
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();

            $table->string('phone')->nullable();
            $table->decimal('total', 12, 2)->default(0.00);
            $table->timestamps();

            //relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('set null');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
