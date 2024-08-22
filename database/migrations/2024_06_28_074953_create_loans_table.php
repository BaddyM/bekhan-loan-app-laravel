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
        $year = date("Y",strtotime(now()));
        Schema::create('loans_'.$year.'', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("loan_limit")->nullable(false)->default(0);
            $table->integer("loan_amount")->nullable(false)->default(0);
            $table->integer("loan_balance")->nullable(false)->default(0);
            $table->string("loan_status");
            $table->integer("days")->nullable(false)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $year = date("Y",strtotime(now()));
        Schema::dropIfExists('loans_'.$year.'');
    }
};
