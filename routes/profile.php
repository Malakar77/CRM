<?php

use Illuminate\Support\Facades\Route;

/**
 * Роутер вывода менеджеров
 */
Route::post('/setSignature', [\App\Http\Controllers\Profile::class, 'setSignature'])->middleware('auth');

/**
 * Загрузка аватарки
 */
Route::post('/setFile', [\App\Http\Controllers\Profile::class, 'setFile'])->middleware('auth');

/**
 * Установка имени
 */
Route::post('/setName', [\App\Http\Controllers\Profile::class, 'setName'])->middleware('auth');
