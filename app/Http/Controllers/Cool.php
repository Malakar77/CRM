<?php

namespace App\Http\Controllers;

use App\Models\CoolModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class Cool extends Controller
{
    /**
     * Получение сообщения коммерческого предложения
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getMassage(Request $request)
    {

        $path = public_path('json/massage.json');
        $massage = '';

        if (File::exists($path)) {
            $json = File::get($path);
            $massage = json_decode($json, true);
        }

        $validated = $request->validate([
            'id'=> 'required|integer|min:1',
        ]);
        $emailCompany = CoolModel::getMassage($validated['id']);

            $result = [
                'massage' => $massage['message_template'] ?? '',
                'subject' => 'Коммерческое предложение',
                'emailCompany' => (isset($emailCompany[0]->email_contact)) ? $emailCompany[0]->email_contact : '',
                'email' => Auth::user()->login
            ];
            return response()->json($result);
    }

    /**
     * Поиск компаний
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public static function getSearch(Request $request)
    {
        $validated = $request->validate([
            'value' => 'nullable|string|max:255',
        ]);

        $search = ($request['value'] == null) ? '' : $request['value'];
        return CoolModel::getSearch($search);
    }

    /**
     * Удаление активного задания
     * @param Request $request
     * @return bool
     */
    public static function deleteTodo(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'id_company' => 'required|integer',
            'text' => 'string|max:255',
        ]);

        return CoolModel::deleteTodo($validated);
    }

    /**
     * Метод получения всех активных заданий
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public static function getTodo(Request $request): \Illuminate\Support\Collection
    {
        $validated = $request->validate([
            'id' => 'required|integer'
        ]);

        return CoolModel::getTodo($validated['id']);
    }

    /**
     * Метод добавления задания
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function setTodo(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'date' => 'required',
            'id' => 'required|integer',
            'status' => 'required|string|max:3',
            'text' => 'required|string|max:255',
        ]);

        return response()->json(CoolModel::setTodo($validated));
    }

    /**
     * Метод отправки коммерческого предложения
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sentOffer(Request $request)
    {
        try {
            $validated = $request->validate([
                'id' => 'required|integer|min:1',
                'email' => 'required|email',
                'emailUser' => 'required|email',
            ]);

            // Инициализируем путь файла по умолчанию
            $fullFilePath = '';

            // Проверяем, загружен ли файл
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                // Указываем директорию для загрузки в storage/app/public (с доступом через public/storage)
                $uploadDir = 'fileTime/';

                // Получаем оригинальное имя файла
                $fileName = $request->file('file')->getClientOriginalName();

                // Сохраняем файл в указанную директорию внутри storage/app/public
                $filePath = $request->file('file')->storeAs($uploadDir, $fileName, 'public');

                // Получаем полный путь к файлу в файловой системе
                $fullFilePath = public_path('storage/' . $uploadDir . $fileName);
            }
            $mail['id_company'] = $validated['id'];
            $mail['email'] = $validated['email'];
            $mail['emailUser'] = $validated['emailUser'];
            $mail['file'] = $fullFilePath;
            $mail['subject'] = $request->input('subject');
            $mail['body'] = $request->input('text');
            $mail['fileOffer'] = $request->input('fileOffer');
            $mail['fileCard'] = $request->input('fileCard');

//            dd(decrypt(Auth::user()->pass_email, file_get_contents(storage_path('encrypt.key'))));
            return response()->json(CoolModel::php_mailer($mail));
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Метод смены статуса компании
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function editStatus(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'status' => 'required|string|max:25',
        ]);
        return response()->json(CoolModel::editStatus($validated));
    }


    /**
     * добавление доп. данных
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getInfoCompany(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'contact' => 'nullable|max:255',
                'email' => 'nullable|email:rfc,dns',
                'id' => 'required|numeric',
                'phone' => 'string|nullable|max:255',
                'site' => 'string|nullable|max:255',
                'text' => 'string|nullable|max:255',
            ]);

            return response()->json(CoolModel::setInfoCompany($validatedData));
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
    /**
     * Логирование действий
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function log(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'text' => 'required|string',
        ]);
        return response()->json(CoolModel::log($validated['id'], $validated['text']));
    }

    /**
     * Запрос данных компании
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getCompany(Request $request): \Illuminate\Http\JsonResponse
    {
        $validData = $request->validate(['id' => 'required|integer']);
        $result['company'] = CoolModel::getCompany($validData['id']);
        $result['info'] = CoolModel::getInfoCompany($validData['id']);
        $result['log'] = CoolModel::getLog($validData['id']);

        return response()->json($result, 200);
    }

    /**
     * Запрос данных всех компаний
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getCompanyAll(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(CoolModel::getCompanyAll());
    }
}
