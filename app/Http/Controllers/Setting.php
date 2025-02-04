<?php

namespace App\Http\Controllers;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Setting extends Controller
{
    /**
     * Вывод общей информации о пользователе
     */
    public function index(): \Illuminate\Http\JsonResponse
    {

        $users['user'] = \App\Models\Setting::user();
        $otdel = \App\Models\Setting::otdel($users['user']->otdel);
        $users['user']->otdel = $otdel->name ;
        $users['user']->id_otdel = $otdel->id ;
        $departament = \App\Models\Setting::departement($users['user']->dolzhost);
        $users['user']->dolzhost = $departament->name ;
        $users['user']->id_dolzhost = $departament->id ;
        $users['name'] = \App\Models\Setting::nameAllUsers();
        $users['post'] = \App\Models\Setting::postAll();
        $users['department'] = \App\Models\Setting::departmentAll();
        return response()->json($users);
    }

    /**
     * Запрос информации о выбранном пользователе
     */
    public function userSelected(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|min:1',
        ]);

        $id = UtilityHelper::get_variable($validated['id']);
        $users = \App\Models\Setting::nameUserById($id);
        $otdel = \App\Models\Setting::otdel($users->otdel);
        $users->otdel = $otdel->name ;
        $users->id_otdel = $otdel->id ;
        $departament = \App\Models\Setting::departement($users->dolzhost);
        $users->dolzhost = $departament->name ;
        $users->id_dolzhost = $departament->id ;
        return response()->json($users);
    }

    /**
     * обновление данных о пользователе
     * @throws ValidationException
     */
    public function setUsers(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'admin' => 'boolean',
            'work' => 'boolean',
            'post' => 'required|integer',
            'youth' => 'required|integer',
            'prefix' => 'required|string|min:1',
            'numberCheck' => 'required|integer',
            'numberContract' => 'required|integer',
            'salary' => 'required|integer',
            'bonus_do' => 'required|string|min:1',
            'bonus_after' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }

        $validated = (object) $validator->validated();

        return response()->json(\App\Models\Setting::updateUser($validated));
    }

    /**
     * Сохранение данных о должности/отделе
     * @throws ValidationException
     */
    public function setPost(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|min:1',
            'name' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }

        $validated = (object) $validator->validated();

        $post['id'] = \App\Models\Setting::setPost($validated);
        $post['name'] = $validated->name;
        $post['type'] = $validated->type;
            return response()->json($post);
    }
}
