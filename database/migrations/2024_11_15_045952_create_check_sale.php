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
        Schema::create('check_sale', function (Blueprint $table) {
            $table->id();
            $table->integer("id_user")->nullable();
            $table->integer("id_client")->nullable();
            $table->integer("id_company")->nullable();
            $table->string("number_check", 255)->nullable();
            $table->date("date_check")->nullable();
            $table->string("comment", 255)->nullable();
            $table->string("status", 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_sale');
    }
};
