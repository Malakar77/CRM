<?php
use Illuminate\Support\Facades\Route;

/**
 * Роутер вывода менеджеров
 */
Route::post('/printManager', [\App\Http\Controllers\Manager::class, 'printManager'])->middleware('auth');

/**
 * Роутер вывода компаний поставщиков в форму добавить
 */
Route::post('/getCompanyProvider', [\App\Http\Controllers\Manager::class, 'getCompanyProvider'])->middleware('auth');

/**
 * Роутер добавления менеджера
 */
Route::post('/addManager', [\App\Http\Controllers\Manager::class, 'addManager'])->middleware('auth');

/**
 * Роутер редактирования менеджера
 */
Route::post('/editManager', [\App\Http\Controllers\Manager::class, 'editManager'])->middleware('auth');

/**
 * Роутер удаления менеджера
 */
Route::post('/deleteManager', [\App\Http\Controllers\Manager::class, 'deleteManager'])->middleware('auth');
