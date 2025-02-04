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
        Schema::create('sent_emails', function (Blueprint $table) {
            $table->id();
            $table->string('to'); // Получатель
            $table->string('bcc')->nullable(); // Скрытая копия
            $table->string('subject'); // Тема письма
            $table->text('body'); // Текст письма
            $table->string('attachment')->nullable(); // Вложение (если есть)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Кто отправил
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sent_emails');
    }
};
