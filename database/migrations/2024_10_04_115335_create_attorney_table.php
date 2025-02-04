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
        Schema::create('attorney', function (Blueprint $table) {
            $table->id();
            $table->string('company')->nullable();
            $table->string('numberDov', 255)->nullable();
            $table->date('date_ot')->nullable();
            $table->date('date_do')->nullable();
            $table->string('id_logist', 15)->nullable();
            $table->string('companyProvider', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->text('info')->nullable();
            $table->string('id_manager')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attorney');
    }
};
