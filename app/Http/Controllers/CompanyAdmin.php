<?php

namespace App\Http\Controllers;

use App\Models\CompanyAdminModel;
use App\Services\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyAdmin extends Controller
{

    /**
     * Метод назначения менеджера
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    static function setManager(Request $request)
    {
        return response ()->json (CompanyAdminModel::setManager ($request->all ()));
    }

    /**
     * Удаление компании
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function deleteCompany(Request $request){

        return response ()->json (CompanyAdminModel::deleteCompany($request->all ()));
    }

    /**
     * Заполнение данными select пользователей
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getManager()
    {
        return response ()->json (CompanyAdminModel::getManager());
    }

    /**
     * Метод вывода списка выгрузок
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function writeUnload(Request $request): \Illuminate\Http\JsonResponse
    {
        return response ()->json (CompanyAdminModel::unLoadCompany());
    }

    /**
     * Добавление компаний через фаил
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function addCompany(Request $request): \Illuminate\Http\JsonResponse
    {
        // Проверяем, загружен ли файл
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            // Указываем директорию для загрузки в storage/app/public (с доступом через public/storage)
            $uploadDir = 'fileTime';

            // Получаем оригинальное имя файла
            $fileName = $request->file('file')->getClientOriginalName();

            // Сохраняем файл в указанную директорию внутри storage/app/public
            $filePath = $request->file('file')->storeAs($uploadDir, $fileName, 'public');
//            dd(Storage::path( $filePath));
            if ($filePath) {
                // Читаем файл в массив
                $fileData = CompanyAdminModel::writeFile(Storage::path( $filePath));

                // Записываем в базу данных
                CompanyAdminModel::addCompany($fileData);

                // Возвращаем успешный результат
                return response()->json($fileData, 200);
            } else {
                // Возвращаем ошибку
                return response()->json(['error' => 'Ошибка загрузки файла'], 500);
            }
        } else {
            // Если файл не был загружен
            return response()->json(['error' => 'Файл не был загружен или невалидный'], 400);
        }
    }

    /**
     * Вывод списка компаний
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function writeCompany(Request $request): \Illuminate\Http\JsonResponse
    {
        $validPage = $request->validate ([
            'page' => 'required|integer|min:1',
            'position' => 'nullable|string',
            'status' => 'nullable|string'
        ]);

        $var = CompanyAdminModel::writeCompany($validPage['position'], $validPage['page'], $validPage['status']);

        $result[0] = Pagination::printPage ($var->lastPage (), $var->currentPage ());
        $result[1] = $var->items ();
        $result[2] = $var->currentPage ();

        return response()->json($result, 200);
    }
}
