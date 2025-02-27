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
        Schema::create('providers', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('catalog', 100)->nullable('other');
            $table->string('name', 256)->nullable('other');
            $table->string('phone', 256)->nullable('other');
            $table->string('city', 256)->nullable('other');
            $table->string('link', 256)->nullable('other');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
