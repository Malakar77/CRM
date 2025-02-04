<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserMenuModal;
use Illuminate\Support\Facades\Log;

class UserMenu extends Controller
{

    /**
     * Метод добавления и удаления позиций пользовательского меню
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function menu(Request $request)
    {
        switch (true) {
            case isset($request->add):
                UserMenuModal::addJsonSettings($request);
                $result['title'] = $request->title;
                $result['href'] = $request->href;
                return response()->json($result);  // Вернуть ответ
            case isset($request->remove):
                UserMenuModal::removeJsonSettings('title', $request->title);
                $result['title'] = $request->title;
                return response()->json($result);  // Вернуть ответ
            default:
                Log::channel('errors')->error('Ошибка запроса. Попытка записи', [
                    'error' => 'Ошибка: ' . $request,
                    'time' => now()->toDateTimeString() // Время ошибки
                ]);
                return response()->json(['error' => 'Ошибка добавления'], 404);  // Вернуть ответ
        }
    }

    /**
     * Метод вывода избранных позиций пользовательского меню
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public static function readJsonSettings(Request $request): mixed
    {
        return UserMenuModal::readJsonSettings($request->user);
    }



}
