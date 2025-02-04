<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Check_total;

Route::get('/', [App\Http\Controllers\Check_total::class, 'index']);

/**
 * Запись примечания
 */
Route::post('/setComment', [App\Http\Controllers\Check_total::class, 'setComment']);

/**
 * Получение PDF-файла
 */
Route::post('/getFile', [App\Http\Controllers\Check_total::class, 'getFile']);

/**
 * Получение XLSX-файла
 */
Route::post('/exelCheck', [App\Http\Controllers\Check_total::class, 'exelCheck']);

/**
 * Роутер получение данных о компании модельное окно отправки Email
 */
Route::post('/dataCompany', [App\Http\Controllers\Check_total::class, 'dataCompany']);

/**
 * Отправка сообщения
 */
Route::post('/sentEmail', [App\Http\Controllers\Check_total::class, 'sentEmail']);
