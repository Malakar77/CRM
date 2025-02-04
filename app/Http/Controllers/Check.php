<?php

namespace App\Http\Controllers;

use App\Models\NumberCheck;
use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Check extends Controller
{
    /**
     * Удаление компании поставщика
     * @param Request $request id компании
     * @return JsonResponse
     */
    public function deleteCompanyProvider(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
        ]);
        $id = UtilityHelper::get_variable($validatedData["id"]);
        \App\Models\Check::deleteCompanyProvider((int) $id);
        return response()->json($id);
    }

    /**
     * Вывод списка компаний поставщика
     * @return JsonResponse
     */
    public function getCompanyProvider(): JsonResponse
    {
        $result = \App\Models\Check::getCompanyProvider();

        $company = $result->map(function ($item) {
            return [
                'id' => $item->id,
                'company_name' => htmlspecialchars_decode($item->company_name),
                'bank' => htmlspecialchars_decode($item->bank),
            ];
        });
        return response()->json($company);
    }

    /**
     * Получение данных о компании
     * @param Request $request приходит id
     * @return JsonResponse возвращает id и имя компании
     */
    public function getDateCompany(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        $id = UtilityHelper::get_variable($validatedData['id']);
        $result = \App\Models\Check::getDateCompany((int) $id);

        $company = array_map(
            'htmlspecialchars_decode',
            (array)$result[0]
        );

        return response()->json($company);
    }

    /**
     * Метод добавления компании поставщика
     * @param Request $request
     * @return JsonResponse
     */
    public function addCompanyProvider(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'addressCompany' => 'nullable|string|max:255',
            'companyAccountNumber' => 'nullable|string|max:255',
            'bikCompany' => 'nullable|string|max:255',
            'companyInn' => 'nullable|string|max:255',
            'corCheck' => 'nullable|string|max:255',
            'kppCompany' => 'nullable|string|max:255',
            'nameBank' => 'nullable|string|max:255',
            'nameCompany' => 'nullable|string|max:255',
        ]);

        $result['id'] = \App\Models\Check::addCompanyProvider((object) $validatedData);
        $result['name'] = $validatedData['nameCompany'];
        $result['bank'] = $validatedData['nameBank'];

        return response()->json($result);
    }

    /**
     * Получение данных о компании поставщика
     * @param Request $request
     * @return JsonResponse
     */
    public function getEditCompanyProvider(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        $id = UtilityHelper::get_variable($validatedData["id"]);

        $result = \App\Models\Check::getEditDataCompany((int) $id);

        $company = array_map(
            'htmlspecialchars_decode',
            (array)$result[0]
        );
        return response()->json($company);
    }

    /**
     * Обновление данных о компании поставщике
     * @param Request $request
     * @return JsonResponse
     */
    public function updateCompanyProvider(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            "id" => 'required|integer|min:1',
            "addressEditCompany" => 'nullable|string|max:255',
            "bankEdit" => 'nullable|string|max:255',
            "bikEditCompany" => 'nullable|string|max:255',
            "correspondentAccount" => 'nullable|string|max:255',
            "editAccountNumber" => 'nullable|string|max:255',
            "innEditCompany" => 'nullable|string|max:255',
            "kppEditCompany" => 'nullable|string|max:255',
            "nameEditCompany" => 'nullable|string|max:255',
        ]);

        $result = array();

        if (\App\Models\Check::updateCompanyProvider((object) $validatedData)) {
            $result['id'] = $validatedData['id'];
            $result['name'] = $validatedData['nameEditCompany'];
            $result['bank'] = $validatedData['bankEdit'];
        };

        return response()->json($result);
    }

    /**
     * Получение номер счета пользователя
     */
    public static function numberCheckUser(): JsonResponse
    {

        return response()->json(\App\Models\Check::numberCheckUser());
    }

    public function check(Request $request): JsonResponse
    {


        $input = $request->all();

        // Отдельная валидация строк данных
        $dataRules = [
            '*.name' => 'required|string|max:255',
            '*.count' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
            '*.price' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
            '*.sumPrice' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
            '*.sumNalog' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
            '*.sumPosition' => 'required|numeric|regex:/^\d+(\.\d{1,3})?$/',
            '*.unitOfMeasurement' => 'required|string|max:50',
            '*.selectNds' => 'required|in:decrease,increase',
        ];

        $dataValidator = Validator::make(array_filter($input, fn($value, $key) => is_numeric($key), ARRAY_FILTER_USE_BOTH), $dataRules);

        if ($dataValidator->fails()) {
            return response()->json([
                'errors' => $dataValidator->errors(),
            ], 422);
        }

        // Отдельная валидация заголовка
        $headerRules = [
            'headers.id_company' => 'required|integer|exists:companies,id',
            'headers.number' => 'required|string|max:50',
            'headers.date' => 'required|date',
            'headers.companyProvider' => 'required|integer|min:1',
            'headers.comment' => 'nullable|string|max:500',
        ];

        $headerValidator = Validator::make(['headers' => $input['headers'] ?? []], $headerRules);

        if ($headerValidator->fails()) {
            return response()->json([
                'errors' => $headerValidator->errors(),
            ], 422);
        }


        $header = $headerValidator->getData();
        $position = $dataValidator->getData();


        $id = \App\Models\Check::addHeaders((object) $header['headers']);

        $result = [];

        if (\App\Models\Check::addPositions((array)$position, $id)) {
            $result['id'] = $id;
            $result['massage'] = 'Счет сформирован';
        }

        return response()->json([
            $result
        ]);
    }

    /**
     * Генератор номера счета
     * Если счет уже есть добавляет /1...10 и т.д
     * @param Request $request
     * @return JsonResponse
     */
    public function generateNumber(Request $request): JsonResponse
    {
        $input = $request->validate([
            "check" => 'required|string|max:50',
        ]);

        return response()->json(NumberCheck::generateNumber($input["check"]));
    }


    public function getDataCheck(Request $request): JsonResponse
    {
        $input = $request->validate([
            "id" => 'required|string|max:50',
        ]);

        $result = \App\Models\Check::getCheck((int) $input["id"]);

        // Очистка данных от HTML-символов
        $data = $result->map(function ($item) {
            return array_map('htmlspecialchars_decode', (array)$item);
        });

        // Возврат JSON-ответа
        return response()->json($data);
    }
}
