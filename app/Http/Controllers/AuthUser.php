<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\AuthUserModal;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\NoReturn;
use Laravel\Passport\HasApiTokens;

class AuthUser extends Controller
{

    /**
     * Метод авторизации пользователя
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request): \Illuminate\Http\JsonResponse
    {

        $input = $request->all();

        $validator = $this->validateInput($input);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $validatedData = $validator->validated();

        $user = AuthUserModal::searchUser($validatedData);

        if ($user) {
            // Попытка аутентификации
            if (Auth::attempt($validatedData)) {
                $innCompany = $user->innCompany;

                // Поиск компании в таблице companyCrm
                $company = AuthUserModal::searchCompany($innCompany);

                if ($company) {
                    // Проверка срока действия компании
                    if (now()->lessThan($company->time)) {
                        // Генерация токена через Passport
                        $token = $user->createToken('authToken')->accessToken;
                        Log::channel('loginIn')->info('Успешный вход: '.$validatedData['login'], [
                            'ip'   => $request->ip(),
                            'time' => now()->toDateTimeString()
                        ]);
                        return response()->json([
                            'message' => 'Успешная аутентификация.',
                            'token'   => $token
                        ], 200);
                    }

                    return AuthUserModal::errorText('Срок действия регистрации истек.', 403);
                }

                return AuthUserModal::errorText('Компания не найдена: ' . $innCompany, 422);
            }

            return AuthUserModal::errorText('Неверные учетные данные.', 401);
        }

        return AuthUserModal::errorText('Пользователь не найден: ' . $validatedData['login'], 422);
    }

    /**
     * Валидация формы
     * @param array $input
     * @return \Illuminate\Validation\Validator
     */
    protected function validateInput(array $input): \Illuminate\Validation\Validator
    {
        return Validator::make($input, [
            'login' => 'required|email|max:255',
            'password' => 'required|min:8',
        ], [
            'login.required' => 'Введите пожалуйста логин',
            'login.email' => 'Логин должен быть Email адресом',
            'login.max' => 'Логин должен быть не более 255 символов',
            'password.required' => 'Введите пожалуйста пароль',
            'password.min' => 'Пароль должен быть более 8 символов',
        ]);
    }

    /**
     * Вывод первой ошибки валидации
     * @param $validator
     * @return JsonResponse
     */
    protected function validationErrorResponse($validator): JsonResponse
    {
        $errorMessage = $validator->errors()->first();
        return response()->json(['error' => $errorMessage], 422);
    }
}
