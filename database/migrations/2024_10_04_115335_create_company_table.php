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
        Schema::create('company', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('type')->nullable();
            $table->string('company_name', 255)->nullable();
            $table->string('inn_company', 255)->nullable();
            $table->string('kpp_company', 255)->nullable();
            $table->string('ur_address_company', 255)->nullable();
            $table->string('address_company', 255)->nullable();
            $table->string('bank', 255)->nullable();
            $table->string('bik_bank_company', 255)->nullable();
            $table->string('kor_chet', 255)->nullable();
            $table->string('ras_chet', 255)->nullable();
            $table->string('user', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
