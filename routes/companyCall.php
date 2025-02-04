<?php

/**
 * Роутер поиска компании по ссылке
 */

use Illuminate\Support\Facades\Route;

/**
 * Роутер добавления компании
 */
Route::post ('/addCompany', [\App\Http\Controllers\CompanyAdmin::class, 'addCompany'])->middleware('auth');

/**
 * Роутер вывода всех компаний
 */
Route::post ('/writeCompany', [\App\Http\Controllers\CompanyAdmin::class, 'writeCompany'])->middleware('auth');

/**
 * Роутер вывода всех выгрузок
 */
Route::post ('/writeUnload', [\App\Http\Controllers\CompanyAdmin::class, 'writeUnload'])->middleware('auth');

/**
 * Роутер получение списка менеджеров
 */
Route::post ('/getManager', [\App\Http\Controllers\CompanyAdmin::class, 'getManager'])->middleware('auth');

/**
 * Роутер Удаления компаний
 */
Route::post ('/deleteCompany', [\App\Http\Controllers\CompanyAdmin::class, 'deleteCompany'])->middleware('auth');

/**
 * Роутер назначения менеджера
 */
Route::post ('/setManager', [\App\Http\Controllers\CompanyAdmin::class, 'setManager'])->middleware('auth');
