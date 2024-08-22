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
        Schema::create('loan_users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('contact');
            $table->string('password');
            $table->string('token', 64)->unique();
            $table->text('nin')->nullable();
            $table->boolean('active')->nullable(false)->default(0);
            $table->timestamp('confirmed_at')->nullable(true);
            $table->timestamp('deleted_at')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_users');
    }
};
