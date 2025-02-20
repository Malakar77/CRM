<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Models\Reg;

class Registration extends Controller
{
    /**
     * Метод для обработки запроса регистрации пользователя.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = $this->validateInput($input);

        if ($validator->fails()) {
            return $this->validationErrorResponse($validator);
        }

        $validatedData = $validator->validated();

        if (Reg::checkCompanyExists($validatedData)) {
            if (Reg::recordExists($validatedData)) {
                return $this->handleUserExistsError($validatedData);
            }

            if ($this->createUserAndSendEmail($validatedData)) {
                return response()->json(true, 200);
            }

            return $this->registrationError($validatedData);
        }

        return $this->companyNotFoundError($validatedData);
    }

    /**
     * Валидация формы
     * @param array $input
     * @return \Illuminate\Validation\Validator
     */
    protected function validateInput(array $input): \Illuminate\Validation\Validator
    {
        return Validator::make($input, [
            'innCompany' => 'required|min:8|string|max:255',
            'login' => 'required|email|max:255',
            'password' => 'required|min:8|confirmed',
        ], [
            'innCompany.min' => 'ИНН должен быть более 8 символов',
            'innCompany.max' => 'ИНН должен быть не более 255 символов',
            'login.max' => 'Логин должен быть не более 255 символов',
            'login.email' => 'Логин должен быть Email адресом',
            'password.confirmed' => 'Пароли не совпадают',
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

    /**
     * Проверка повторной регистрации
     * @param array $validatedData
     * @return JsonResponse
     */
    protected function handleUserExistsError(array $validatedData): JsonResponse
    {
        Log::channel('errors')->error('Повторная регистрация пользователя', [
            'user' => $validatedData['login'],
            'company' => $validatedData['innCompany'],
            'time' => now()->toDateTimeString()
        ]);

        return response()->json([
            'error' => 'Данный пользователь уже существует'
        ], 422);
    }

    /**
     * Регистрация пользователя и отправка Email
     * @param array $validatedData
     * @return bool
     */
    protected function createUserAndSendEmail(array $validatedData): bool
    {
        if (Reg::createNew($validatedData)) {
            Mail::to($validatedData['login'])
                ->send(new WelcomeEmail($validatedData['login'], $validatedData['password']));

            Log::channel('registrations')->info('Пользователь зарегистрирован', [
                'user' => $validatedData['login'],
                'company' => $validatedData['innCompany'],
                'time' => now()->toDateTimeString()
            ]);

            return true;
        }

        Log::channel('errors')->error('Не удалось зарегистрировать пользователя', [
            'user' => $validatedData['login'],
            'company' => $validatedData['innCompany'],
            'time' => now()->toDateTimeString()
        ]);

        return false;
    }

    /**
     * Ошибка регистрации
     * @param array $validatedData
     * @return JsonResponse
     */
    protected function registrationError(array $validatedData): JsonResponse
    {
        return response()->json([
            'error' => 'Ошибка при регистрации обратитесь в поддержку'
        ], 422);
    }

    /**
     * Ошибка регистрации не существующей компании
     * @param array $validatedData
     * @return JsonResponse
     */
    protected function companyNotFoundError(array $validatedData): JsonResponse
    {
        Log::channel('errors')->error('Попытка регистрации для несуществующей компании', [
            'user' => $validatedData['login'],
            'company' => $validatedData['innCompany'],
            'time' => now()->toDateTimeString()
        ]);

        return response()->json([
            'error' => 'Попытка регистрации для несуществующей компании'
        ], 422);
    }
}

