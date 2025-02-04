<?php


use Illuminate\Support\Facades\Route;

/**
 * Роутер запроса всех компаний
 */
Route::post('/getCompanyAll', [\App\Http\Controllers\Cool::class, 'getCompanyAll']);

/**
 * Роутер запроса данных компании
 */
Route::post('/getCompany', [\App\Http\Controllers\Cool::class, 'getCompany']);

/**
 * Роутер логирования
 */
Route::post('/log', [\App\Http\Controllers\Cool::class, 'log']);

/**
 * Роутер добавление информации о компании
 */
Route::post ('/getInfoCompany', [\App\Http\Controllers\Cool::class, 'getInfoCompany']);

/**
 * Роутер смены статуса компании
 */
Route::post ('/editStatus', [\App\Http\Controllers\Cool::class, 'editStatus']);

/**
 * Роутер отправки коммерческого предложения
 */
Route::post ('/sentOffer', [\App\Http\Controllers\Cool::class, 'sentOffer']);

/**
 * Роутер добавления Задания
 */
Route::post ('/setTodo', [\App\Http\Controllers\Cool::class, 'setTodo']);

/**
 * Роутер получения активных заданий
 */
Route::post ('/getTodo', [\App\Http\Controllers\Cool::class, 'getTodo']);

/**
 * Роутер удаления активного задания
 */
Route::post ('/deleteTodo', [\App\Http\Controllers\Cool::class, 'deleteTodo']);

/**
 * Роутер поиска компаний
 */
Route::post ('/getSearch', [\App\Http\Controllers\Cool::class, 'getSearch']);

/**
 * Получение сообщения коммерческого предложения
 */
Route::post ('/getMassage', [\App\Http\Controllers\Cool::class, 'getMassage']);
