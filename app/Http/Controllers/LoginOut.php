<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginOut extends Controller
{

    /**
     * Метод выхода авторизированного пользователя
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        // Выход пользователя
        Auth::logout();

        // Удаление сессии
        $request->session()->invalidate();

        // Генерация нового CSRF-токена
        $request->session()->regenerateToken();

        // Перенаправление на страницу входа
        return response()->json(['message' => 'Выход выполнен']);
    }

}
