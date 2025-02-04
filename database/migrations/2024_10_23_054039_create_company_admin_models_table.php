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
        Schema::create('companies', function (Blueprint $table) {
            $table->id()->autoIncrement ();
            $table->string("name", 255)->nullable();
            $table->string("inn", 255)->nullable();
            $table->string("address", 255)->nullable();
            $table->string("status", 255)->default('add');
            $table->integer("user_id")->nullable();
            $table->string("name_export", 255)->nullable();
            $table->date("date_export")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
