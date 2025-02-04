<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('post_youth', function (Blueprint $table) {
            $table->id();
            $table->string('type', 255)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('status', 255)->nullable();
            $table->timestamps();
        });

        DB::table('post_youth')->insert([
            'id' => 1,
            'type' => 'default',
            'name' => 'не выбрано',
            'status' => 'work',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_youth');
    }
};
