<?php

namespace App\Http\Controllers;

use App\Models\LogisticModel;
use App\Services\Pagination;
use Illuminate\Http\Request;

class LogisticController extends Controller
{
    /**
     * Метод вывода городов
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getCategories(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(LogisticModel::getCity());
    }


    public static function getLogistics(Request $request): \Illuminate\Http\JsonResponse
    {
        $var = LogisticModel::getLogistics($request->page, $request->search);

        $result[0] = Pagination::printPage ($var->lastPage (), $var->currentPage ());
        $result[1] = $var->items ();
        $result[2] = $var->currentPage ();

        return response()->json($result);
    }

    /**
     * Метод добавления логиста
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function addLogistic(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            // Валидация данных
            $validatedData = $request->validate([
                'name'          => 'required|string|max:50',
                'surname'       => 'required|string|max:50',
                'patronymic'    => 'required|string|max:50',
                'phone'         => 'required|string|max:20',
                'transport'     => 'required|string|max:50',
                'city'          => 'required|string|max:50',
                'info'          => 'nullable|string|max:255',
            ]);

            // Преобразование данных в объект для передачи в модель
            $data = (object) $validatedData;

            $result['name'] = $data->name;
            $result['surname'] = $data->surname;
            $result['patronymic'] = $data->patronymic;
            $result['phone'] = $data->phone;
            $result['transport'] = $data->transport;
            $result['city'] = $data->city;
            $result['id'] = LogisticModel::addLogist($data);

            // Возвращаем успешный ответ
            return response()->json($result);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Возвращаем ошибки валидации
            return response()->json([
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $exception) {
            // Ловим исключения из модели
            return response()->json([
                'error' => $exception->getMessage(),
            ], 422);
        }
    }

    public static function getInfoLogistics(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $validatedData = $request->validate([
                'id' => 'required|string|max:5',
            ]);

            $data = (int) $validatedData['id'];

            return response()->json(LogisticModel::getInfoLogistics($data));

        }catch (\Exception $exception){
            return response()->json([
                'error' => $exception->getMessage(),
            ], 422);
        }
    }
}
