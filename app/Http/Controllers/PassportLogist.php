<?php

namespace App\Http\Controllers;

use App\Models\PassportsModel;
use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Http\Request;


class PassportLogist extends Controller
{
    public string $encryptKey;

    public function __construct()
    {
        $this->encryptKey = file_get_contents(storage_path('encrypt.key'));
    }

    public function getPassportLogist(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->input('id');

        $data = PassportsModel::getPassportLogistics ($id);

        $passport = [
            'name'          => $data->name ?? null,
            'surname'       => $data->surname ?? null,
            'patronymic'    => $data->patronymic ?? null,
            'document_type' => $this->decryptOrFallback($data-> document),
            'series'        => $this->decryptOrFallback($data-> series),
            'number'        => $this->decryptOrFallback($data-> number),
            'issued'        => $this->decryptOrFallback($data-> issued),
            'date_issued'   => $this->decryptOrFallback($data-> date_issued),
        ];

        return response()->json($passport);
    }

    public function addDover(Request $request): \Illuminate\Http\JsonResponse
    {
        // Получение данных паспорта с проверкой на наличие
        $passport = [
            'document'       => $this->encryptOrFallback(UtilityHelper::get_variable($request->input('document'))),
            'seria'          => $this->encryptOrFallback(UtilityHelper::get_variable($request->input('seria'))),
            'numberPassport' => $this->encryptOrFallback(UtilityHelper::get_variable($request->input('numberPassport'))),
            'given'          => $this->encryptOrFallback(UtilityHelper::get_variable($request->input('given'))),
            'dateGiven'      => $this->encryptOrFallback(UtilityHelper::get_variable($request->input('dateGiven'))),
        ];

        // Проверка успешности добавления паспорта

        if($request -> input ( 'nameLogist' ) !== null ){
            $passportAdded = PassportsModel::addPassport((int)UtilityHelper::get_variable($request->input('idLogist')), $passport);
            if (!$passportAdded) {
                return response()->json(['error' => 'Failed to add passport data'], 500);
            }
        }

        // Попытка добавить данные доверенности
        $attorneyId = PassportsModel::addAttorney((object)$request->all());

        if (!$attorneyId) {
            return response()->json(['error' => 'Failed to add attorney data'], 500);
        }

        return response()->json(['attorney_id' => $attorneyId]);
    }


    private function decryptOrFallback($value): bool|string|null
    {
        return $value ? UtilityHelper::decrypt($value, $this->encryptKey) : null;
    }

    private function encryptOrFallback($value): bool|string|null
    {
        return $value ? UtilityHelper::encrypt($value, $this->encryptKey) : null;
    }

}
