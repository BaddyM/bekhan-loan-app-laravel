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
        $current_year = date("Y",strtotime(now()));
        Schema::create('pending_payment_'.$current_year.'', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("amount_paid");
            $table->integer("contact");
            $table->string("status");
            $table->string("confirmed_by");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_payment');
    }
};
