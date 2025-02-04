<?php

namespace App\Http\Controllers;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Http\Request;

class Main extends Controller
{

    public static function add(Request $request)
    {
        $result = [];

        $validated = $request->validate([
            'id_company' => 'nullable',
            'title' => 'required|max:255',
            'start' => 'required',
            'end' => 'nullable',
            'allDay' => 'boolean',
            'color' => 'required|string|max:8',
        ]);

        $position = (object) $validated;
        $id = \App\Models\Main::addTask($position);

        if (!empty($id)) {
            $result = [
                'id' => $id,
                'title' => $position->title,
                'start' => $position->start,
                'end' => $position->end,
                'color' => $position->color,
                'allDay' => $position->allDay,
            ];
        }
        return response()->json($result);
    }


    /**
     * Обновление активного задания
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function setTodo(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required',
            'text' => 'required|max:255',
            'time' => 'required'
        ]);

        \App\Models\Main::setTodo($validated);

        $result = \App\Models\Main::getTask((int) $validated['id']);
        return response()->json($result);
    }

    /**
     * ЕПолучение всх активных заданий
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getActiveTodo(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = \App\Models\Main::index();
        $result = $result->map(function ($item) {
            return array_map('htmlspecialchars_decode', (array)$item);
        });
        return response()->json($result);
    }

    /**
     * Удаление активного задания
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function deleteTodo(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $id = (int) UtilityHelper::get_variable($validated['id']);
        return response()->json(\App\Models\Main::deletedTodo($id));
    }
}
