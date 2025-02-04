<?php
use Illuminate\Support\Facades\Route;

/**
 * Получение данных о компании
 */
Route::post('/getDateCompany', [\App\Http\Controllers\Check::class, 'getDateCompany'])->middleware('auth');

/**
 * Добавление компании поставщика
 */
Route::post('/addCompanyProvider', [\App\Http\Controllers\Check::class, 'addCompanyProvider'])->middleware('auth');

/**
 * Получение компаний поставщика
 */
Route::post('/getCompanyProvider', [\App\Http\Controllers\Check::class, 'getCompanyProvider'])->middleware('auth');

/**
 * Удаление компании поставщика
 */
Route::post('/deleteCompanyProvider', [\App\Http\Controllers\Check::class, 'deleteCompanyProvider'])->middleware('auth');

/**
 * Получение данных о редактируемой компании
 */
Route::post('/getEditCompanyProvider', [\App\Http\Controllers\Check::class, 'getEditCompanyProvider'])->middleware('auth');

/**
 * Обновление данных о компании поставщике
 */
Route::post('/updateCompanyProvider', [\App\Http\Controllers\Check::class, 'updateCompanyProvider'])->middleware('auth');

/**
 * Получение номера счета пользователя
 */
Route::post('/numberCheckUser', [\App\Http\Controllers\Check::class, 'numberCheckUser'])->middleware('auth');

/**
 * Выставление счета
 */
Route::post('/check', [\App\Http\Controllers\Check::class, 'check'])->middleware('auth');

/**
 * Генератор номера
 */
Route::post('/generateNumber', [\App\Http\Controllers\Check::class, 'generateNumber'])->middleware('auth');

/**
 * Данные ранее выставленного счета
 */
Route::post('/getDataCheck', [\App\Http\Controllers\Check::class, 'getDataCheck'])->middleware('auth');
