<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Check extends Model
{
    use HasFactory;

    /**
     * Получение данных о компании
     * @param int $id ID компании
     * @return Collection возвращает id и имя компании
     */
    public static function getDateCompany(int $id): Collection
    {
        return DB::table('companies')
            ->select('id', 'name')
            ->where('id', $id)
            ->get();
    }

    /**
     * Метод добавления компании поставщика
     * @param object $data
     * @return bool|int
     */
    public static function addCompanyProvider(object $data): bool|int
    {
        $result = DB::table('company')->insertGetId([

            'type' => 'check',
            'company_name' => UtilityHelper::get_variable($data->nameCompany),
            'inn_company' => UtilityHelper::get_variable($data->companyInn),
            'kpp_company' => UtilityHelper::get_variable($data->kppCompany),
            'ur_address_company' => UtilityHelper::get_variable($data->addressCompany),
            'address_company' => UtilityHelper::get_variable($data->addressCompany),
            'bank' => UtilityHelper::get_variable($data->nameBank),
            'bik_bank_company' => UtilityHelper::get_variable($data->bikCompany),
            'kor_chet' => UtilityHelper::get_variable($data->corCheck),
            'ras_chet' => UtilityHelper::get_variable($data->companyAccountNumber),
            'user' => Auth::user()->id,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        return $result ?: false;
    }

    /**
     * Вывод списка компаний поставщика
     * @return Collection
     */
    public static function getCompanyProvider(): Collection
    {
        return DB::table('company')
        ->select('id', 'company_name', 'bank')
            ->where('type', '=', 'check')
            ->where('user', '=', Auth::id())
            ->get();
    }

    /**
     * Удаление компании поставщика
     * @param int $id id компании
     * @return bool
     */
    public static function deleteCompanyProvider(int $id): bool
    {
        return DB::table('company')
            ->where('id', $id)
            ->update([
                'type' => 'trash',
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Получение данных о компании поставщика
     * @param int $id
     * @return Collection
     */
    public static function getEditDataCompany(int $id): Collection
    {
        return DB::table('company')
            ->select(
                'id',
                'company_name',
                'inn_company',
                'kpp_company',
                'ur_address_company',
                'bank',
                'bik_bank_company',
                'kor_chet',
                'ras_chet'
            )
            ->where('id', '=', $id)
            ->get();
    }

    /**
     * Обновление данных о компании поставщике
     */
    public static function updateCompanyProvider(object $data): bool
    {
        return DB::table('company')
            ->where('id', $data->id)
            ->update([
                'company_name' => UtilityHelper::get_variable($data->nameEditCompany),
                'inn_company' => UtilityHelper::get_variable($data->innEditCompany),
                'kpp_company' => UtilityHelper::get_variable($data->kppEditCompany),
                'ur_address_company' => UtilityHelper::get_variable($data->addressEditCompany),
                'bank' => UtilityHelper::get_variable($data->bankEdit),
                'bik_bank_company' => UtilityHelper::get_variable($data->bikEditCompany),
                'kor_chet' => UtilityHelper::get_variable($data->correspondentAccount),
                'ras_chet' => UtilityHelper::get_variable($data->editAccountNumber),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }

    public static function numberCheckUser()
    {
        return DB::table('users')
            ->select('prefix', 'numberCheck as number')
            ->where('id', '=', Auth::id())
            ->first();
    }

    /**
     * Добавление заголовков счета
     * @param object $data
     * @return array
     */
    public static function addHeaders(object $data)
    {
        $numberCheck = UtilityHelper::get_variable($data->number);

        // Проверяем наличие записи с таким номером счета
        $check = DB::table('check_sale')
            ->where('number_check', $numberCheck)
            ->whereNotIn('status', ['old', 'close'])
            ->first();

        if ($check) {
            // Обновляем существующую запись
            DB::table('check_sale')
                ->where('id', $check->id)
                ->update([
                    'id_user' => Auth::id(),
                    'id_client' => UtilityHelper::get_variable($data->id_company),
                    'id_company' => UtilityHelper::get_variable($data->companyProvider),
                    'number_check' => $numberCheck,
                    'date_check' => UtilityHelper::get_variable($data->date),
                    'comment' => htmlspecialchars(trim($data->comment)),
                    'status' => '16.6',
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
            $result['id_check_sale'] = $check->id;
            $result['new_id'] = $check->id;
        } else {
            // Создаем новую запись
            $newId = DB::table('check_sale')
                ->insertGetId([
                    'id_user' => Auth::id(),
                    'id_client' => UtilityHelper::get_variable($data->id_company),
                    'id_company' => UtilityHelper::get_variable($data->companyProvider),
                    'number_check' => $numberCheck,
                    'date_check' => UtilityHelper::get_variable($data->date),
                    'comment' => htmlspecialchars(trim($data->comment)),
                    'status' => '16.6',
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);


            if (preg_match('/^[А-Яа-я]{3}(?:[0-8]?\d{0,5}|900000)$/u', $numberCheck)) {
                // Если формат AAA100, вызываем функцию updateNumber
                UtilityHelper::updateNumber();
            }

            $result['id_check_sale'] = null;
            $result['new_id'] = $newId;
        }

        return $result;
    }

    /**
     * Добавление позиций счета
     * @param array $data
     * @param array $res
     * @return bool
     */
    public static function addPositions(array $data, array $res): bool
    {
        if (isset($res['id_check_sale'])) {
            // Преобразуем id для использования в запросах
            $idCheck = UtilityHelper::get_variable($res['id_check_sale']);

            // Обновляем статус всех строк с id_check = $idCheck и статусом, не равным 'old' или 'close'
            DB::table('check_position')
                ->where('id_check', $idCheck)
                ->where('status', '!=', ['old', 'close'])
                ->update([
                    'status' => 'old',
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
        }

        // Вставляем новые записи
        foreach ($data as $item) {
            DB::table('check_position')->insert([
                'id_check' => UtilityHelper::get_variable($res['new_id']),
                'name' => UtilityHelper::get_variable($item['name']),
                'unit' => UtilityHelper::get_variable($item['unitOfMeasurement']),
                'count' => UtilityHelper::get_variable($item['count']),
                'price' => UtilityHelper::get_variable($item['price']),
                'sum' => UtilityHelper::get_variable($item['sumPrice']),
                'nds' => UtilityHelper::get_variable($item['selectNds']),
                'sum_nds' => UtilityHelper::get_variable($item['sumNalog']),
                'result' => UtilityHelper::get_variable($item['sumPosition']),
                'status' => '20',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        return true;
    }

    /**
     * Получение всех данных счета
     * @param string $baseNumber
     * @return Collection
     */
    public static function getCheck(string $baseNumber): Collection
    {
        $checkId = UtilityHelper::get_variable($baseNumber);

        return DB::table('check_position')
            ->join('check_sale', 'check_position.id_check', '=', 'check_sale.id')
            ->leftJoin('companies', 'check_sale.id_client', '=', 'companies.id')
            ->select(
                'check_position.name as positionName',
                'check_position.unit',
                'check_position.count',
                'check_position.price',
                'check_position.sum',
                'check_position.nds',
                'check_position.sum_nds',
                'check_position.result',
                'check_sale.number_check',
                'check_sale.date_check',
                'check_sale.comment',
                'companies.id as companyId',
                'companies.name as companyName'
            )
            ->where('check_sale.id', '=', $checkId)
            ->where('check_position.status', '!=', ['old', 'close'])
            ->get();
    }
}
