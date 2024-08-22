<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_documents', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->string("national_id");
            $table->string("personal_photo")->nullable(true);
            $table->string("phone_contacts")->nullable(true);
            $table->string("phone_details")->nullable(true);
            $table->string("sms_details")->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_documents');
    }
};
