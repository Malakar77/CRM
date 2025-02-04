<?php

use Illuminate\Support\Facades\Route;

/**
 * Роутер страницы поставщика контроллер
 */
Route::post ('/search', [\App\Http\Controllers\Attorney::class, 'search'])->middleware('auth');


/**
 * РОутер добавления компании
 */
Route::post ('/addCompany', [\App\Http\Controllers\Attorney::class, 'addCompany'])->middleware('auth');


Route::post ('/print', [\App\Http\Controllers\Attorney::class, 'print'])->middleware('auth');
