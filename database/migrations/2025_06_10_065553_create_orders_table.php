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
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('status_id');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('address_id');
            $table->text('cancel_reason')->nullable();

            $table->string('phone');
            $table->decimal('total', 12, 2)->default(0.00);
            $table->timestamps();

            //relationship
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
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
