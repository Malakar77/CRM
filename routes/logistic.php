<?php


use Illuminate\Support\Facades\Route;

/**
 * Роутер страницы поставщика контроллер
 */
Route::post ('/getCategories', [\App\Http\Controllers\LogisticController::class, 'getCategories'])->middleware('auth');

/**
 * Роутер вывода позиций
 */
Route::post ('/getLogistics', [\App\Http\Controllers\LogisticController::class, 'getLogistics'])->middleware('auth');

/**
 * Роутер обработки формы добавить
 */
Route::post('/addLogistic', [\App\Http\Controllers\LogisticController::class, 'addLogistic'])->middleware('auth');

/**
 * Роутер получение дополнительной информации о логисте
 */
Route::post('/getInfoLogistics', [\App\Http\Controllers\LogisticController::class, 'getInfoLogistics'])->middleware('auth');

/**
 * Роутер получения паспорта логиста
 */
Route::post('/getPassportLogist', [\App\Http\Controllers\PassportLogist::class, 'getPassportLogist'])->middleware('auth');

/**
 * Роутер для добавления доверенности
 */
Route::post ('/addDover', [\App\Http\Controllers\PassportLogist::class, 'addDover'])->middleware('auth');

/**
 * Роутер заполнения компании для доверенности
 */
Route::post ('/getCompany', [\App\Http\Controllers\Attorney::class, 'getCompany'])->middleware('auth');

/**
 * Роутер заполнения формы обновления компании
 */
Route::post ('/getDataCompany', [\App\Http\Controllers\Attorney::class, 'getDataCompany'])->middleware('auth');

/**
 * Роутер обновления компании
 */
Route::post ('/updateCompany', [\App\Http\Controllers\Attorney::class, 'updateCompany'])->middleware('auth');

/**
 * Роутер запроса архива доверенностей
 */
Route::post ('/getAttorneyUser', [\App\Http\Controllers\Attorney::class, 'getAttorneyUser'])->middleware('auth');

/**
 * Роутер удаления доверенностей
 */
Route::post ('/deleteAttorneyUser', [\App\Http\Controllers\Attorney::class, 'deleteAttorneyUser'])->middleware('auth');
