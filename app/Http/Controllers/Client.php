<?php

namespace App\Http\Controllers;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Client extends Controller
{

    public function index(): JsonResponse
    {
        $result['company'] = \App\Models\Client::index();
        $result['admin'] = Auth::user()->admin;
        return response()->json($result);
    }

    /**
     * Данные активной компании
     * @param Request $request
     * @return JsonResponse
     */
    public function getActiveCompany(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        $result['check'] = \App\Models\Client::getCheckActiveCompany($validated['id']);

        $result['company'] = \App\Models\Client::getActiveCompany($validated['id']);

        return response()->json($result);
    }

    /**
     * Смена статуса счета
     * @throws ValidationException
     */
    public function progressCheck(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'size' => 'required|numeric',
            ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }
        // Получить проверенные данные...
        $validated = $validator->validated();

        return response()->json(\App\Models\Client::setStatusProgress($validated));
    }

    /**
     * Детализация счета
     * @param Request $request
     * @return JsonResponse
     */
    public function getDetailsCheck(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);
        $id = UtilityHelper::get_variable($validated['id']);
        return response()->json(\App\Models\Client::detailsCheck((int)$id));
    }

    /**
     * Получение архива счетов
     * @param Request $request
     * @return JsonResponse
     */
    public function checkClose(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);
        $id = UtilityHelper::get_variable($validated['id']);

        return response()->json(\App\Models\Client::checkClose((int)$id));
    }

    /**
     * Получение списка счетов
     * @param Request $request
     * @return JsonResponse
     */
    public function checkNoClose(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        $id = UtilityHelper::get_variable($validated['id']);
        return response()->json(\App\Models\Client::getCheckActiveCompany((int)$id));
    }

    /**
     * Отправка сообщений в телеграмм
     * @throws ValidationException
     */
    public function sentMessage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'sumProvider' => 'required|string|min:1',
            'sumLogist' => 'required|string|min:1',
            'countDayLogist' => 'required|string|min:1',
            'countDayPay' => 'required|string|min:1',
            'usloviya' => 'required|string|min:1',
            'id' => 'required|integer',
            'size' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }
        // Получить проверенные данные...
        $validated = $validator->validated();
        $file = UtilityHelper::getFilePDF($validated['id']);
        $validated['url'] = $file['url'];
        $validated['name'] = $file['name'];

        \App\Models\Client::sentTelegramm((object)$validated);
        return response()->json(\App\Models\Client::setStatusProgress($validated));
    }

    /**
     * Чтение файла и отправка в таблицу на странице
     * @param Request $request
     * @return JsonResponse
     */
    public function sentFile(Request $request): JsonResponse
    {

        // Проверяем, был ли загружен файл
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Копируем временный файл в хранилище
            $path = Storage::disk('public')->putFileAs('/fileTime', $file, $file->getClientOriginalName());

            // Загружаем файл с помощью PhpSpreadsheet
            $spreadsheet = IOFactory::load(storage_path('app/public/' . $path));

            // Получаем данные из первого листа
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();  // Получаем данные в виде массива

            // Возвращаем данные в формате JSON
            return response()->json($data);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }

    /**
     * Добавление счета из файла
     * @param Request $request
     * @return JsonResponse
     */
    public function addCheckExel(Request $request): JsonResponse
    {
        return response()->json(\App\Models\Client::addPositionExel($request['position'], \App\Models\Client::headCheckExel($request['head'])));
    }


    /**
     * Добавление комментария компании
     * @throws ValidationException
     */
    public function addComment(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text' => 'nullable|string',
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }
        // Получить проверенные данные...
        $validated = $validator->validated();

        return response()->json(\App\Models\Client::addComment((object)$validated));
    }

    /**
     * Вывод всех компаний
     * @param Request $request
     * @return JsonResponse
     */
    public function allCompany(Request $request): JsonResponse
    {
        $result['company'] = \App\Models\Client::allCompany();
        $result['admin'] = Auth::user()->admin;
        return response()->json($result);
    }

    /**
     * Вывод данных о компании в окно редактирования
     * @throws ValidationException
     */
    public function editCompany(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }
        // Получить проверенные данные...
        $validated = $validator->validated();

        $arr = \App\Models\Client::getCompany((int)$validated['id']);
        $result['company'] = array_map('htmlspecialchars_decode', (array)$arr[0]);
        $result['users'] = \App\Models\Client::getAllUsers();

        return response()->json($result);
    }

    /**
     * Сохранение изменений компании
     * @throws ValidationException
     */
    public function saveEditCompany(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'contact' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|string',
            'site' => 'nullable|string',
            'users' => 'required|integer',
            'id_company' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }
        // Получить проверенные данные...
        $validated = $validator->validated();

        return response()->json(\App\Models\Client::saveEditCompany($validated));
    }

    /**
     * Вывод списка пользователей для добавления компании
     * @return JsonResponse
     */
    public function allUsers(): JsonResponse
    {
        return response()->json(\App\Models\Client::getAllUsers());
    }

    /**
     * Добавление компании
     * @throws ValidationException
     */
    public function addCompany(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:1',
            'inn' => 'required|string|min:1',
            'kpp' => 'required|string|min:1',
            'address' => 'required|string|min:1',
            'contact' => 'required|string|min:1',
            'phone' => 'required|string|min:1',
            'email' => 'required|string|min:1',
            'user' => 'required|string|min:1',
            'info' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }
        // Получить проверенные данные...
        $validated = $validator->validated();
        $arr = array_map('\App\Services\UtilityHelper\UtilityHelper::get_variable', $validated);

        return response()->json(\App\Models\Client::addCompany((object)$arr));
    }

    /**
     * Поиск по компаниям
     * @throws ValidationException
     */
    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json('Ошибка Данных', 422);
        }

        // Получить проверенные данные...
        $validated = $validator->validated();
        $text = UtilityHelper::get_variable($validated['text']);
        $result['company'] = \App\Models\Client::search($text);
        $result['admin'] = Auth::user()->admin;
        return response()->json($result);
    }
}
