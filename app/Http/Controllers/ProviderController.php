<?php

namespace App\Http\Controllers;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Http\Request;
use App\Models\ProviderModel;
use Illuminate\Support\Facades\Log;
use App\Services\Pagination;

class ProviderController extends Controller
{
    public function delete(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        return response()->json(\App\Models\ProviderModel::deleteProvider((int) $validatedData['id']));
    }

    /**
     * Метод вывода всех категорий
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(ProviderModel::getAllCategories());
    }

    public function getCompany(Request $request): \Illuminate\Http\JsonResponse
    {
        $var = ProviderModel::getAllProviders($request->page);

        $result[0] = Pagination::printPage($var->lastPage(), $var->currentPage());
        $result[1] = $var->items();
        $result[2] = $var->currentPage();

        return response()->json($result);
    }

    /**
     * Метод поиска компаний по ссылкам
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $var = ProviderModel::searchCompany($request->search, $request->page);

        $result[0] = Pagination::printPage($var->lastPage(), $var->currentPage());
        $result[1] = $var->items();
        $result[2] = $var->currentPage();

        return response()->json($result);
    }

    /**
     * Метод добавления компании
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addProvider(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Валидация данных
            $validatedData = $request->validate([
                'categories' => 'required|string|max:50',
                'name' => 'required|string|max:50',
                'phone' => 'required|string|max:15',
                'website' => 'required|string|max:50',
                'city' => 'required|string|max:50',
            ]);

            $arr = array_map('\App\Services\UtilityHelper\UtilityHelper::get_variable', $validatedData);
            // Преобразуем данные в объект
            $data = (object) $arr;

            // Вставляем данные в базу
            $id = \App\Models\ProviderModel::addProvider($data);
            Log::info('New provider added', ['user_id' => auth()->id(), 'provider_name' => $data->name]);
            // Возвращаем успешный JSON-ответ
            return response()->json([
                'categories' => $data->categories,
                'id'         => $id,
                'name'       => $data->name,
                'phone'      => $data->phone,
                'website'    => $data->website,
                'city'       => $data->city,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Возвращаем ошибки валидации в формате JSON
            return response()->json([$e->validator->errors()// Это содержит все ошибки валидации
            ], 422);  // 422 Unprocessable Entity — код ошибки для неправильных данных
        }
    }

    /**
     * Метод заполнения формы редактирования компании
     */
    public function getProvider(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        $id = (int) UtilityHelper::get_variable($validatedData['id']);
        $result['categories'] = \App\Models\ProviderModel::getAllCategories();
        $result['provider'] = \App\Models\ProviderModel::getProvider($id);

        return response()->json($result);
    }

    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validate([
            'id' => 'required|integer|min:1',
            'categories' => 'required|string|max:50',
            'name' => 'required|string|max:50',
            'phone' => 'required|string|max:15',
            'website' => 'required|string|max:50',
            'city' => 'required|string|max:50',
        ]);

        $arr = array_map('\App\Services\UtilityHelper\UtilityHelper::get_variable', $validatedData);

        // Преобразуем данные в объект
        $data = (object) $arr;
        $result = \App\Models\ProviderModel::updateProvider($data);
        if ($result) {
            return response()->json([
                'categories' => $data->categories,
                'id'         => $data->id,
                'name'       => $data->name,
                'phone'      => $data->phone,
                'website'    => $data->website,
                'city'       => $data->city,
            ]);
        }
        return response()->json(false);
    }
}
