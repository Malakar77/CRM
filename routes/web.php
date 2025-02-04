<?php

use App\Http\Controllers\LoginOut;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use UniSharp\LaravelFilemanager\Lfm;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/**
 * Роутер страницы регистрации
 */
Route::get('registration', function () {
    return view('reg');
})->middleware('guest');

/**
 * Роутер страницы авторизации
 */
Route::get('/', function () {
    return view('index');
})->name('/')->middleware('guest');

/**
 * Роутер главной страницы
 */
Route::get('/api/main', function () {
    return view('main');
})->middleware('auth');

/**
 * Роутер страницы поставщики
 */
Route::get('/provider', function () {
    return view('provider');
})->middleware('auth');

/**
 * Роутер страницы экспедиторы
 */
Route::get('/logistic', function () {
    return view('logistic');
})->middleware('auth');

/**
 * Роутер страницы доверенности
 */
Route::get('/attorney', function () {
    return view('attorney');
})->middleware('auth');

/**
 * Роутер страницы менеджер поставщиков
 */
Route::get('/manager', function () {
    return view('manager');
})->middleware('auth');

/**
 * Роутер страницы зарплатный проект
 */
Route::get('/calls', function () {
    return view('calls');
})->middleware('auth');

/**
 * Роутер страницы зарплатный проект
 */
Route::get('/company', function () {
    return view('companyCall');
})->middleware('auth');

/**
 * Роутер страницы зарплатный проект
 */
Route::get('/my_company', function () {
    return view('my_company');
})->middleware('auth');


Route::get('/check', function () {
    return view('check');
})->middleware('auth');

Route::get('/profile', function () {
    return view('profile');
})->middleware('auth');


Route::get('/setting', function () {
    return view('setting');
})->middleware('auth');


//Route::get('/fileManager', function () {
//    return view('fileManager');
//})->middleware('auth');

Route::group(['prefix' => 'fileManager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});

/**
 * Роутер запроса регистрации пользователя
 */
Route::post('/api/send-data', [\App\Http\Controllers\registration::class, 'store']);

/**
 * Роутер авторизации пользователя
 */
Route::post('/api/auth-data', [\App\Http\Controllers\AuthUser::class, 'authenticate']);

/**
 * Роутер выхода пользователя
 */
Route::post('/api/logout', [LoginOut::class, 'logout'])->name('logout');

/**
 * Роутер получения данных о пользователе
 */
Route::get('/api/user-data', [\App\Http\Controllers\GetByUser::class, 'getUserData'])->middleware('auth');


/**
 * Роутер добавления/удаления пользовательского меню
 */
Route::post('/UserMenu', [\App\Http\Controllers\UserMenu::class, 'menu'])->middleware('auth');

/**
 * Роутер вывода пользовательского меню
 */
Route::post('/readJsonSettings', [\App\Http\Controllers\UserMenu::class, 'readJsonSettings'])->middleware('auth');
