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
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('img')->nullable(); // ảnh đại diện
            $table->date('birthday')->nullable();
            $table->string('password');
            $table->enum('gender', ['male', 'female'])->nullable();

            // FK
            $table->unsignedBigInteger('role_id')->nullable();
            $table->boolean('status')->default(true); // true = active, false = inactive
            
            $table->timestamps();

            // relationship
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
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
