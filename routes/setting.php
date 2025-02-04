<?php

use Illuminate\Support\Facades\Route;

/**
 * Вывод общей информации о пользователе
 */
Route::post('/index', [\App\Http\Controllers\Setting::class, 'index'])->middleware('auth');

/**
 * Запрос информации о выбранном пользователе
 */
Route::post('/userSelected', [\App\Http\Controllers\Setting::class, 'userSelected'])->middleware('auth');

/**
 * Запись данных пользователе
 */
Route::post('/setUsers', [\App\Http\Controllers\Setting::class, 'setUsers'])->middleware('auth');

/**
 * Запись новой должности/отдела
 */
Route::post('/setPost', [\App\Http\Controllers\Setting::class, 'setPost'])->middleware('auth');
