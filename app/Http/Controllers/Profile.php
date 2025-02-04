<?php

namespace App\Http\Controllers;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Profile extends Controller
{
    /**
     * Смена подписи и пароля от почты
     * @throws ValidationException
     */
    public function setSignature(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'pass' => 'nullable|string|min:8',
            'signature' => 'nullable|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }

        $validated = (object) $validator->validated();
        return response()->json(\App\Models\Profile::setSignature($validated));
    }

    /**
     * Установка аватарки
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setFile(Request $request): \Illuminate\Http\JsonResponse
    {
        // Проверяем, был ли загружен файл
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Копируем временный файл в хранилище
            $path = Storage::disk('public')->putFileAs('/avatarUser', $file, $file->getClientOriginalName());

            $url = Storage::url($path);

            $file->id = UtilityHelper::get_variable($request['id']);
            $file->path = $url;

            \App\Models\Profile::setFile($file);
            // Возвращаем данные в формате JSON
            return response()->json($url);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     *  Установка имени
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function setName(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'name' => 'nullable|string',
            'surname' => 'nullable|string',
            'patronymic' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }

        $validated = (object) $validator->validated();

        return response()->json(\App\Models\Profile::setName($validated));
    }
}
