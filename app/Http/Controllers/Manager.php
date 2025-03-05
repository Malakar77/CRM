<?php

namespace App\Http\Controllers;

use App\Models\ManagerModel;
use App\Services\Pagination;
use Illuminate\Http\Request;

class Manager extends Controller
{

    /**
     * Метод вывода менеджеров
     */
    public function printManager(Request $request): \Illuminate\Http\JsonResponse
    {

        $validPage = $request->validate([
            'page' => 'required|integer|min:1',
            'search' => 'nullable|string'
        ]);

        $search = $validPage['search'] ?? 'all';
        $page = (int)$validPage['page'];

        // Вызываем метод managerAll с корректными параметрами
        $var = ManagerModel::managerAll($search, $page);

            $result[0] = Pagination::printPage($var->lastPage(), $var->currentPage());
            $result[1] = $var->items();
            $result[2] = $var->currentPage();

        return response()->json($result);
    }

    /**
     * Метод вывода компаний поставщиков в форму
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getCompanyProvider(Request $request): \Illuminate\Http\JsonResponse
    {
        $result = ManagerModel::getCompanyProvider();
        return response()->json($result);
    }

    /**
     * Метод добавления менеджера поставщиков
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function addManager(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $valideData = $request->validate([
                'companyProvider' => 'required|string|max:15',
                'name'  => 'required|string|max:150',
                'phone' => 'required|string|max:25',
                'email' => 'required|string|max:150',
            ]);
            $result = ManagerModel::getManagerById(ManagerModel::addManager($valideData));

            return response()->json($result);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 422);
        }
    }

    /**
     * Метод редактирования менеджера
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function editManager(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required|integer',
                'name'  => 'required|string|max:150',
                'phone' => 'required|string|max:250',
                'email' => 'required|string|max:150',
            ]);

            $result = ManagerModel::editManager($validatedData);
            if ($result !== false) {
                return response()->json($request);
            }
            return response()->json(false);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Метод удаления менеджера
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    static function deleteManager(Request $request): \Illuminate\Http\JsonResponse
    {
        $valideData = $request->validate(['id' => 'required|integer']);
        ManagerModel::deleteManager((int) $valideData['id']);
        return response()->json(true);
    }
}
