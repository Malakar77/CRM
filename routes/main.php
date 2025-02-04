<?php
use Illuminate\Support\Facades\Route;

/**
 * Получение всех активных заданий
 */
Route::post('/getActiveTodo', [\App\Http\Controllers\Main::class, 'getActiveTodo'])->middleware('auth');

/**
 * Обновление активного задания
 */
Route::post('/setTodo', [\App\Http\Controllers\Main::class, 'setTodo']) ->middleware('auth');

/**
 * Закрытие активного задания
 */
Route::post('/deleteTodo', [\App\Http\Controllers\Main::class, 'deleteTodo']) ->middleware('auth');

/**
 * Добавить задание
 */
Route::post('/addTodo', [\App\Http\Controllers\Main::class, 'add']) ->middleware('auth');
