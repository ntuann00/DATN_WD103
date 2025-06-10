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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // tên loại thanh toán (e.g. Visa, Paypal)
            $table->string('provider')->nullable(); // nhà cung cấp (e.g. Techcombank)
            $table->string('account_no')->nullable(); // số tài khoản/thẻ
            $table->string('expiry_date')->nullable(); // ngày hết hạn thẻ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
