<?php

use Illuminate\Support\Facades\Route;

/**
 * Получение списка компаний
 */
Route::post('/getClient', [\App\Http\Controllers\Client::class, 'index'])->middleware('auth');

/**
 * Получение данных активной компании
 */
Route::post('/getActiveCompany', [\App\Http\Controllers\Client::class, 'getActiveCompany'])->middleware('auth');

/**
 * Смена статуса счета
 */
Route::post('/progressCheck', [\App\Http\Controllers\Client::class, 'progressCheck'])->middleware('auth');

/**
 * Получение деталей счета
 */
Route::post('/getDetailsCheck', [\App\Http\Controllers\Client::class, 'getDetailsCheck'])->middleware('auth');

/**
 * Получение архива счетов
 */
Route::post('/checkClose', [\App\Http\Controllers\Client::class, 'checkClose'])->middleware('auth');

/**
 * Получение списка счетов
 */
Route::post('/checkNoClose', [\App\Http\Controllers\Client::class, 'checkNoClose'])->middleware('auth');

/**
 * Отправка счет на согласование
 */
Route::post('/sentMessage', [\App\Http\Controllers\Client::class, 'sentMessage'])->middleware('auth');

/**
 * Отправка файла для выставления счета
 */
Route::post('/sentFile', [\App\Http\Controllers\Client::class, 'sentFile'])->middleware('auth');

/**
 * Выставление счета из эксель
 */
Route::post('/addCheckExel', [\App\Http\Controllers\Client::class, 'addCheckExel'])->middleware('auth');

/**
 * Добавление комментария для компании
 */
Route::post('/addComment', [\App\Http\Controllers\Client::class, 'addComment'])->middleware('auth');

/**
 * Вывод всех компаний
 */
Route::post('/allCompany', [\App\Http\Controllers\Client::class, 'allCompany'])->middleware('auth');

/**
 * Редактирование компании
 */
Route::post('/editCompany', [\App\Http\Controllers\Client::class, 'editCompany'])->middleware('auth');

/**
 * Сохранение данных компании
 */
Route::post('/saveEditCompany', [\App\Http\Controllers\Client::class, 'saveEditCompany'])->middleware('auth');

/**
 * Вывод списка пользователей для добавления компании
 */
Route::post('/allUsers', [\App\Http\Controllers\Client::class, 'allUsers'])->middleware('auth');

/**
 * Добавление клиента
 */
Route::post('/addCompany', [\App\Http\Controllers\Client::class, 'addCompany'])->middleware('auth');

/**
 * Поиск по базе
 */
Route::post('/search', [\App\Http\Controllers\Client::class, 'search'])->middleware('auth');
