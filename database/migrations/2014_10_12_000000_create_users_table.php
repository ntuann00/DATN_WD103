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
        Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('phone');
    $table->string('email')->unique();
    $table->string('img')->nullable(); // ảnh đại diện
    $table->date('birthday');
    $table->string('password');
    $table->enum('gender', ['male', 'female']);

    // FK: KHÔN ràng buộc chặt
    $table->unsignedBigInteger('role_id');
    $table->boolean('status')->default(true);
    
    $table->timestamps();

    $table->foreign('role_id')->references('id')->on('roles')->onDelete('restrict');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
