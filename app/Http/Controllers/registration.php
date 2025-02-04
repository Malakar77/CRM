<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\Reg;

class registration extends Controller
{
    /**
     * Метод для обработки запроса регистрации пользователя.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Валидация входных данных
            $validatedData = $request->validate([
                'innCompany' => 'required|string|max:255', // ИНН компании обязательно, строка, максимум 255 символов
                'login' => 'required|email|max:255', // Логин обязательно, формат email, максимум 255 символов
                'password' => 'required|min:8|confirmed', // Пароль обязателен, минимум 8 символов, требуется подтверждение
            ]);

            // Проверка на существование записи в базе данных через модель
            if (Reg::recordExists($validatedData)) {
                // Логируем ошибку при попытке повторной регистрации
                Log::channel('errors')->error('Повторная регистрация пользователя', [
                    'user' => $validatedData['login'],
                    'company' => $validatedData['innCompany'],
                    'time' => now()->toDateTimeString() // Время ошибки
                ]);

                // Возвращаем ответ с ошибкой 422 (Unprocessable Entity)
                return response()->json([
                    'errors' => [
                        'login' => ['Record with this login already exists.'] // Сообщаем, что такой логин уже зарегистрирован
                    ]
                ], 422);
            }

            // Проверка на существование компании через модель
            if (Reg::checkCompanyExists((object)$validatedData)) {
                // Если компания существует, создаем новую запись
                if (Reg::createNew($validatedData)) {
                    // Отправляем email при успешной регистрации
                    Reg::sendEmail((object)$validatedData);

                    // Логируем успешную регистрацию
                    Log::channel('registrations')->info('Пользователь зарегистрирован', [
                        'user' => $validatedData['login'], // Логин пользователя
                        'company' => $validatedData['innCompany'], // Компания
                        'time' => now()->toDateTimeString() // Время регистрации
                    ]);

                    // Возвращаем успешный ответ
                    return response()->json([
                        'message' => 'Registration was successful'
                    ], 200);
                }

                // Логируем ошибку, если создание записи не удалось
                Log::channel('errors')->error('Не удалось зарегистрировать пользователя', [
                    'user' => $validatedData['login'],
                    'company' => $validatedData['innCompany'],
                    'time' => now()->toDateTimeString() // Время ошибки
                ]);

                // Возвращаем ответ с ошибкой 422
                return response()->json([
                    'errors' => 'Failed to register'
                ], 422);
            }

            // Если компания не существует, логируем ошибку
            Log::channel('errors')->error('Попытка регистрации для несуществующей компании', [
                'user' => $validatedData['login'],
                'company' => $validatedData['innCompany'],
                'time' => now()->toDateTimeString() // Время ошибки
            ]);

            // Возвращаем ответ с ошибкой 422
            return response()->json([
                'errors' => 'The company does not exist'
            ], 422);
        } catch (ValidationException $e) {
            // Возвращаем ошибки валидации с кодом 422
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }
}
