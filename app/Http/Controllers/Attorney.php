<?php

namespace App\Http\Controllers;

use App\Models\AttorneyModel;

use App\Services\UtilityHelper\UtilityHelper;
use FontLib\Table\Type\name;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Attorney extends Controller
{
    public string $encryptKey;

    public function __construct()
    {
        $this->encryptKey = file_get_contents(storage_path('encrypt.key'));
    }


    /**
     * Метод поиска
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {

        $validatedData = $request->validate([
            'id' => 'required|string|max:5',
        ]);

        $result = self::infoAttorney((int) $validatedData['id']);

        return response()->json($result);
    }

    public function print(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'id' => 'required|string|max:5',
        ]);

        $data = self::infoAttorney((int) $validatedData['id']);

        return response()->json(AttorneyModel::printFile((object)$data));
    }


    private function infoAttorney(int $id)
    {
        $result = AttorneyModel::getAttorney($id);

        $logist = AttorneyModel::getByLogist ((int)$result['id_logist']);
        $MyCompany = AttorneyModel::getByCompany((int)$result['company']);
        $providerCompany = AttorneyModel::getByCompany((int)$result['companyProvider']);

        $logist->document    = UtilityHelper::decrypt ($logist->document, $this->encryptKey);
        $logist->series	     = UtilityHelper::decrypt ($logist->series, $this->encryptKey);
        $logist->number	     = UtilityHelper::decrypt ($logist->number, $this->encryptKey);
        $logist->issued	     = UtilityHelper::decrypt ($logist->issued, $this->encryptKey);
        $logist->date_issued = UtilityHelper::decrypt ($logist->date_issued, $this->encryptKey);

        $result->logist = array_map ('htmlspecialchars_decode', (array)$logist );
        $result->company = array_map ('htmlspecialchars_decode', (array)$MyCompany );
        $result->providerCompany = array_map ('htmlspecialchars_decode', (array)$providerCompany );

        return $result;
    }

    /**
     * Метод добавления компании
     * @param Request $request
     * @return JsonResponse
     */
    public function addCompany(Request $request): JsonResponse
    {
        try{
            $validatedData = $request->validate([
                'nameCompanySearch' => 'required|string|max:225',
                'innCompanySearch' => 'required|digits_between:10,12',
                'kppCompanySearch' => 'required|digits:9',
                'adCompanySearch' => 'required|string|max:255',
                'urCompanySearch' => 'required|string|max:255',
                'bank' => 'required|string|max:255',
                'bikBankCompany' => 'required|string|max:255',
                'korChet' => 'required|string|max:255',
                'rasChet' => 'required|string|max:255',
                'status' => 'required|string|max:5',
            ]);

            $result = AttorneyModel::addCompany((object)$validatedData);

            if(!$result){
                return response()->json('Ошибка записи компании', 422);
            };

            return response()->json(['id' => $result, 'name' => $validatedData['nameCompanySearch']], 201);

        }catch (\Exception $exception){
            return response()->json($exception->getMessage (), 422);
        }
    }

    /**
     * Метод получения данных о компании
     * @param Request $request
     * @return JsonResponse
     */
    public function getCompany(Request $request): JsonResponse
    {
        $result = AttorneyModel::getCompany ();

        return response()->json($this->htmlSpecial($result), 200);
    }

    /**
     * Функция получения данных о компании
     * @param Request $request  id обновляемой компании
     * @return JsonResponse возвращает все колонки из базы данных
     */
    public function getDataCompany(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'id' => 'required|string|max:5',
        ]);

        $result = AttorneyModel::getDataCompany ((int)$validatedData['id']);

        return response()->json($this->htmlSpecial($result), 200);
    }

    /**
     * Метод Контроллера обнавления компании
     * @param Request $request  Данные формы обновления компаниях
     * @return JsonResponse
     */
    public function updateCompany(Request $request): JsonResponse
    {
        try{
            $validatedData = $request->validate([
                'id' => 'required|string|max:5',
                'nameCompanyEdit' => 'string|max:225|nullable',
                'innCompanyEdit' => 'digits_between:10,12|nullable',
                'kppCompanyEdit' => 'digits:9|nullable',
                'adCompanyEdit' => 'string|max:255|nullable',
                'urCompanyEdit' => 'string|max:255|nullable',
                'bankEdit' => 'string|max:255|nullable',
                'bikBankEdit' => 'string|max:255|nullable',
                'korChetEdit' => 'string|max:255|nullable',
                'rasChetEdit' => 'string|max:255|nullable',
            ]);

            $result = AttorneyModel::updateCompany((object)$validatedData);

            if(!$result){
                return response()->json('Ошибка записи компании', 422);
            };

            return response ()->json ($validatedData, 200);

        }catch (\Exception $exception){
            return response()->json($exception->getMessage (), 422);
        }
    }

    /**
     * Метод получения всех данных о доверенностях
     * сформированных пользователем
     * @return JsonResponse
     */
    public function getAttorneyUser(): JsonResponse
    {
        $result = AttorneyModel::getAttorneyUser();
        $company = [];
        for($i=0; $i<count($result); $i++){
            $company[$i]['name']   = '';
            if(isset($result[$i]->id_logist)){

                $nameLogist = AttorneyModel::getDataLogist ((int)$result[$i]->id_logist);

                $company[$i]['name']   = $nameLogist[0]->surname;

            }
            $company[$i]['id']    = $result[$i]->id;
            $company[$i]['date']   = $result[$i]->date_ot;
        }

        return response()->json($company, 200);
    }

    /**
     * Метод удаления доверенности
     */
    static function deleteAttorneyUser(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'id' => 'required|string|max:5',
        ]);

        AttorneyModel::deleteAttorneyUser((int)$validatedData['id']);

        return response ()->json (true, 200);

    }

    /**
     * Дополнительный метод
     * Преобразовывает специальные HTML-сущности обратно в символы
     * @param $result
     * @return mixed
     */
    private function htmlSpecial($result): mixed
    {
        return $result->map(function ($item) {
            return array_map(function ($value) {
                return is_string($value) ? htmlspecialchars_decode($value) : $value;
            }, (array) $item);
        });
    }
}
