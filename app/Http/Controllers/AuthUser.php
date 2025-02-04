<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\AuthUserModal;
use JetBrains\PhpStorm\NoReturn;
use Laravel\Passport\HasApiTokens;


class AuthUser extends Controller
{

    /**
     * Метод авторизации пользователя
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
     public static function authenticate(Request $request): \Illuminate\Http\JsonResponse
    {


      // Валидация данных
        $credentials = $request->validate([
            'login' => ['required', 'email'],
            'password' => ['required'],
        ]);

       // Поиск пользователя в таблице user по логину
        $user = AuthUserModal::SearchUser($credentials);

//
      if ($user) {

            // Попытка аутентификации
            if (Auth::attempt($credentials)) {

                $innCompany = $user->innCompany;

                // Поиск компании в таблице companyCrm
                $company = AuthUserModal::SearchCompany($innCompany);

                if ($company) {
                    // Проверка срока действия компании
                    if (now()->lessThan($company->time)) {
                        // Генерация токена через Passport
                        $token = $user->createToken('authToken')->accessToken;
                        Log::channel('loginIn')->info('Успешный вход: '.$credentials['login'], [
                            'ip'   => $request->ip(),
                            'time' => now()->toDateTimeString()
                        ]);
                        return response()->json([
                            'message' => 'Успешная аутентификация.',
                            'token'   => $token
                        ], 200);
                    } else {
//                        Session::flush();
                        // Срок действия компании истек
                        return AuthUserModal::errorText('Срок действия регистрации истек.', 403);
                        // Выход пользователя
                    }
                } else {
//                    Session::flush();
                    // Компания не найдена
                    return AuthUserModal::errorText('Компания не найдена: ' . $innCompany, 422);
                }
            } else {
//            Session::flush();
                // Неверные учетные данные
                return AuthUserModal::errorText('Неверные учетные данные.', 401);
            }
        } else {
//            Session::flush();
            // Пользователь не найден
            return AuthUserModal::errorText('Пользователь не найден: ' . $credentials['login'], 422);
       }
    }

}
