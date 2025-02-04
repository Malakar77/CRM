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
        Schema::create('info_companies', function (Blueprint $table) {
            $table->id()->autoIncrement ();
            $table->integer('id_company')->nullable();
            $table->string("name_contact", 255)->nullable();
            $table->string("phone_contact", 255)->nullable();
            $table->string("email_contact", 255)->nullable();
            $table->string("sait_company", 255)->nullable();
            $table->string("info_company", 255)->nullable();
            $table->string("status", 255)->default('add');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_companies');
    }
};
