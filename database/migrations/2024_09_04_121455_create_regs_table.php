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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('innCompany')->nullable(false);
            $table->string('login')->nullable(false);
            $table->string('password')->nullable(false);
            $table->boolean('admin')->nullable()->default(false);
            $table->string('prefix')->nullable()->default('ААА');
            $table->string('numberCheck')->nullable()->default(100);
            $table->string('numberContract')->nullable()->default(100);
            $table->integer('post')->default(0);
            $table->boolean('work')->default(true);
            $table->float('zp_do_plan', 8, 3)->nullable()->default(0.128);
            $table->float('zp_posl_plan', 8, 3)->nullable()->default(0.128);
            $table->integer('oklad')->nullable()->default(0);
            $table->integer('otdel')->default(1);
            $table->integer('dolzhost')->default(1);
            $table->string('rop')->nullable()->default('Не выбрано');
            $table->string('mobile')->nullable()->default('Не выбрано');
            $table->string('phone')->nullable()->default('Не выбрано');
            $table->string('name')->nullable()->default('Пользователь');
            $table->date('date_work')->nullable()->default(DB::raw('CURRENT_DATE'));
            $table->string('link_ava')->nullable()->default('images/bot.png');
            $table->string('signature')->nullable()->default('Отправлено из CRM');
            $table->text('pass_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
