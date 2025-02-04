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
        Schema::create('check_position', function (Blueprint $table) {
            $table->id();
            $table->integer("id_check")->nullable();
            $table->string("name", 255)->nullable();
            $table->string("unit", 255)->nullable();
            $table->string("count", 255)->nullable();
            $table->string("price", 255)->nullable();
            $table->string("sum", 255)->nullable();
            $table->string("nds", 255)->nullable();
            $table->string("sum_nds", 255)->nullable();
            $table->string("result", 255)->nullable();
            $table->string("status", 255)->nullable();
            $table->timestamps();
            // Добавляем связь с таблицей check_sale
//            $table->foreign('id_check')->references('id')->on('check_sale')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_position');
    }
};
