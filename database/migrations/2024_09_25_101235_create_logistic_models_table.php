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
        Schema::create('logistics', function (Blueprint $table) {
            $table->id();
            $table->integer('statistic')->nullable()->default(0);
            $table->string('name', 255)->nullable();
            $table->string('surname', 255)->nullable();
            $table->string('patronymic', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->text('document')->nullable();
            $table->text('series')->nullable();
            $table->text('number')->nullable();
            $table->text('issued')->nullable();
            $table->text('date_issued')->nullable();
            $table->string('transport', 255)->nullable();
            $table->string('info', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logistics');
    }
};
