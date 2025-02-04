<?php

use Illuminate\Support\Facades\Route;

/**
 * Роутер страницы поставщика контроллер
 */
Route::post('/ProviderController', [\App\Http\Controllers\ProviderController::class, 'getCategories'])->middleware('auth');

/**
 * Роутер вывода всех компаний
 */
Route::post('/getCompany', [\App\Http\Controllers\ProviderController::class, 'getCompany'])->middleware('auth');

/**
 * Роутер добавления поставщика страница provider
 */
Route::post('/addProvider', [\App\Http\Controllers\ProviderController::class, 'addProvider'])->middleware('auth');

/**
 * Роутер поиска компании по ссылке
 */
Route::post('/searchCompany', [\App\Http\Controllers\ProviderController::class, 'search'])->middleware('auth');

/**
 * Роутер удаления компании
 */
Route::post('/delete', [\App\Http\Controllers\ProviderController::class, 'delete'])->middleware('auth');

/**
 * Роутер редактирования компании
 */
Route::post('/getProvider', [\App\Http\Controllers\ProviderController::class, 'getProvider'])->middleware('auth');

/**
 * Роутер редактирования компании
 */
Route::post('/update', [\App\Http\Controllers\ProviderController::class, 'update'])->middleware('auth');
