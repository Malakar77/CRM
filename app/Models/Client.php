<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use CURLFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\table;

class Client extends Model
{
    use HasFactory;

    /**
     * Получение списка клиентов
     * @return \Illuminate\Support\Collection
     */
    public static function index(): \Illuminate\Support\Collection
    {
       return DB::table('companies')
            ->select('companies.id', 'companies.name',
                DB::raw("SUM(CASE WHEN check_sale.status != '100'
                                  AND check_sale.status != 'close'
                                  THEN 1 ELSE 0 END) as count"))
            ->leftJoin('check_sale', 'companies.id', '=', 'check_sale.id_client')
                   ->where([
                       ['companies.user_id', '=', Auth::user()->id],
                       ['companies.status', '=', 'client']
                   ])
            ->groupBy('companies.id', 'companies.name')
            ->orderByDesc('count')
            ->get();
    }

    /**
     * Получение данных активной компании
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public static function getActiveCompany(int $id): \Illuminate\Support\Collection
    {
        return DB::table('companies')
            ->leftJoin('info_companies', 'info_companies.id_company', '=', 'companies.id')
            ->leftJoin('users', 'companies.user_id', '=', 'users.id')
            ->select(
                'users.name',
                'companies.id',
                'companies.inn',
                'companies.address',
                'info_companies.name_contact',
                'info_companies.phone_contact',
                'info_companies.email_contact',
                'info_companies.sait_company',
                'info_companies.info_company'
            )
            ->where('companies.id', $id)
            ->where('companies.status', 'client')
            ->where(function($query) {
                $query->where('info_companies.status', 'add')
                    ->orWhereNull('info_companies.status');
            })
            ->groupBy(
                'users.name',
                'companies.id',
                'companies.inn',
                'companies.address',
                'info_companies.name_contact',
                'info_companies.phone_contact',
                'info_companies.email_contact',
                'info_companies.sait_company',
                'info_companies.info_company'
            )
            ->get();
    }

    /**
     * Получение счетов активной компании
     * @param $id
     * @return \Illuminate\Support\Collection
     */
    public static function getCheckActiveCompany(int $id): \Illuminate\Support\Collection
    {

        return DB::table('check_sale')
            ->join('check_position', 'check_position.id_check', '=', 'check_sale.id')
            ->select(
                'check_sale.id',
                'check_sale.id_client',
                'check_sale.number_check',
                'check_sale.date_check',
                'check_sale.status',
                DB::raw('SUM(CAST(check_position.result AS numeric)) as result')
            )
            ->where('check_sale.id_client', $id)
            ->whereNotIn('check_sale.status', ['old', 'close', '100'])
            ->whereNotIn('check_position.status', ['old', 'close', '100'])
            ->groupBy(
                'check_sale.id',
                'check_sale.id_client',
                'check_sale.number_check',
                'check_sale.date_check',
                'check_sale.status'
            )
            ->get();
    }

    /**
     * Смена статуса счета
     * @param $check
     * @return bool
     */
    public static function setStatusProgress($check): bool
    {
        $arr = array_map('\App\Services\UtilityHelper\UtilityHelper::get_variable', $check);

        return DB::table('check_sale')
            ->where('id', $arr['id'])
            ->update([
                'status' => $arr['size'],
                'updated_at' => \Carbon\Carbon::now()
            ]);
    }

    /**
     * Получение детализации счетов
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public static function detailsCheck(int $id): \Illuminate\Support\Collection
    {
        return DB::table('check_position')
            ->select('name', 'unit', 'count', 'price' ,'result')
            ->where('id_check', $id)
            ->whereNotIn('status', ['old', 'close'])
            ->get();

    }

    /**
     * Получение всех закрытых счетов
     * @param int $id
     * @return \Illuminate\Support\Collection
     */
    public static function checkClose(int $id): \Illuminate\Support\Collection
    {
        return DB::table('check_sale')
            ->join('check_position', 'check_position.id_check', '=', 'check_sale.id')
            ->select(
                'check_sale.id',
                'check_sale.id_client',
                'check_sale.number_check',
                'check_sale.date_check',
                'check_sale.status',
                DB::raw('SUM(CAST(check_position.result AS numeric)) as result')
            )
            ->where('check_sale.id_client', $id)
            ->where('check_sale.status',  '100')
            ->whereNotIn('check_position.status', ['old', 'close'])
            ->groupBy(
                'check_sale.id',
                'check_sale.id_client',
                'check_sale.number_check',
                'check_sale.date_check',
                'check_sale.status'
            )
            ->get();
    }

    /**
     * Отправка на согласование в телеграмм
     * @param object $data
     * @return void
     */
    public static function sentTelegramm(object $data)
    {
        $token = env('BOT_TOKEN');  // Замените на ваш токен бота
        $chat_id = env('CHAT_BOT');  // ID группы


        $document = new CURLFile(realpath(Storage::path('public/' . $data->name . '.pdf')));

        $post_fields = [
            'chat_id' => $chat_id,
            'document' => $document,
            'caption' => '
    Запрос на отсрочку
    1. Номер счета ' . $data->name . '
    2. Сумма закупки ' . $data->sumProvider . '
    3. Сумма логистики ' . $data->sumLogist . '
    4. Срок доставки ' . $data->countDayLogist . '
    5. Срок оплаты ' . $data->countDayPay . '
    6. Условия ' . $data->usloviya . '
    7. Менеджер ' . Auth::user()->login,
            'reply_markup' => json_encode([
                'inline_keyboard' => [
                    [
                        ['text' => 'Согласовать', 'callback_data' => 'approve_' . $data->name],
                        ['text' => 'Не согласовывать', 'callback_data' => 'disapprove_' . $data->name]
                    ]
                ]
            ])
        ];

        $ch = curl_init('https://api.telegram.org/bot' . $token . '/sendDocument');
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:multipart/form-data']);
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $token . '/sendDocument');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        if ($output === false) {
            // Если произошла ошибка при выполнении запроса
             http_response_code(500); // Отправляем код ответа "Внутренняя ошибка сервера"
        } else {
            // Если запрос выполнен успешно
            http_response_code(200); // Отправляем код ответа "Успешно"

        }
        curl_close($ch);
    }

    /**
     * Добавление счета из файла exel
     * @param $id_client int id компании клиента
     * @return int id счета
     */
    public static function headCheckExel(int $id_client): int
    {
        $result['user'] = DB::table('users')
            ->select('prefix', 'numberCheck')
            ->where('id', Auth::user()->id)
            ->first();

        $result['provider'] = DB::table('company')
                            ->select('id')
                            ->where('type', 'check')
                            ->where('user', Auth::user()->id)
                            ->first();


        $Id = DB::table('check_sale')
            ->insertGetId([
                'id_user' => Auth::id(),
                'id_client' => UtilityHelper::get_variable($id_client),
                'id_company' => $result['provider']->id,
                'number_check' => $result['user']->prefix . $result['user']->numberCheck,
                'date_check' => date('Y-m-d'),
                'comment' => '',
                'status' => '16.6',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        $numberCheck = $result['user']->prefix . $result['user']->numberCheck;
        if (preg_match('/^[А-Яа-я]{3}\d{3}$/u', $numberCheck)) {
            // Если формат AAA100, вызываем функцию updateNumber
            UtilityHelper::updateNumber();
        }
        return $Id;
    }

    /**
     * Добавление позиций счета из файла
     * @param $data array позиции в виде массива
     * @param $id int id счета
     * @return bool
     */
    public static function addPositionExel(array $data, int $id): bool
    {

        for ($i = 0; $i < count($data); $i++) {
            DB::table('check_position')->insert([
                'id_check' => UtilityHelper::get_variable($id),
                'name' => UtilityHelper::get_variable($data[$i]['name']),
                'unit' => UtilityHelper::get_variable($data[$i]['unit']),
                'count' => UtilityHelper::get_variable($data[$i]['count']),
                'price' => UtilityHelper::get_variable($data[$i]['price']),
                'sum' => 0,
                'nds' => 'decrease',
                'sum_nds' => 0,
                'result' => 0,
                'status' => '20',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        return true;
    }

    /**
     * Добавление комментария компании
     * @param object $data text комментария, id компании
     * @return bool
     */
    public static function addComment(object $data): bool
    {

        return DB::table('info_companies')
            ->where('id_company', $data->id)
            ->update([
                'info_company' => UtilityHelper::get_variable($data->text),
                'updated_at' => \Carbon\Carbon::now()
            ]);
    }

    /**
     * Вывод всех компаний
     * @return \Illuminate\Support\Collection
     */
    public static function allCompany(): \Illuminate\Support\Collection
    {
        return DB::table('companies')
        ->select('companies.id', 'companies.name',
            DB::raw("SUM(CASE WHEN check_sale.status != '100'
                          AND check_sale.status != 'close'
                          THEN 1 ELSE 0 END) as count"))
        ->leftJoin('check_sale', 'companies.id', '=', 'check_sale.id_client')
        ->where([
            ['companies.status', '=', 'client']
        ])
        ->groupBy('companies.id', 'companies.name')
        ->orderByDesc('count')
        ->get();
    }

    /**
     * Данные для формы редактирования
     * @param int $id id активной компании
     * @return object|\Illuminate\Support\Collection
     */
    public static function getCompany(int $id): object
    {
        return DB::table('companies')
            ->leftJoin('info_companies', 'companies.id', '=', 'info_companies.id_company')
            ->select (
                'companies.name',
                'companies.inn',
                'companies.address',
                'info_companies.name_contact',
                'info_companies.phone_contact',
                'info_companies.email_contact',
                'info_companies.sait_company'
            )
            ->where ('companies.id', '=', $id)
            ->get();
    }

    /**
     * Список пользователей для select
     * @return \Illuminate\Support\Collection
     */
    public static function getAllUsers(): \Illuminate\Support\Collection
    {
        return DB::table('users')
            ->select('id', 'name')
            ->get();
    }

    /**
     * Сохранение формы редактирования
     * @param array $data массив данных о компании
     * @return bool
     */
    public static function saveEditCompany(array $data): bool
    {
        $arr = array_map('\App\Services\UtilityHelper\UtilityHelper::get_variable', $data);

        DB::table('companies')
            ->where('id', $arr['id_company'])
            ->update([
                'user_id' => $arr['users'],
                'updated_at' => \Carbon\Carbon::now()
            ]);

        $search = DB::table('info_companies')
            ->where('id_company', $arr['id_company'])
            ->first();

        if(!$search){
            return  DB::table('info_companies')
                ->where('id_company', $arr['id_company'])
                ->insert([
                    'id_company' => $arr['id_company'],
                    'name_contact' => $arr['contact'],
                    'phone_contact' => $arr['phone'],
                    'email_contact' => $arr['email'],
                    'sait_company' => $arr['site'],
                    'updated_at' => \Carbon\Carbon::now(),
                    'created_at' => \Carbon\Carbon::now(),
                ]);
        }

        return  DB::table('info_companies')
            ->where('id_company', $arr['id_company'])
            ->update([
                'name_contact' => $arr['contact'],
                'phone_contact' => $arr['phone'],
                'email_contact' => $arr['email'],
                'sait_company' => $arr['site'],
                'updated_at' => \Carbon\Carbon::now()
            ]);
    }

    /**
     * Добавление клиента
     * @param object $data
     * @return bool
     */
    public static function addCompany(object $data): bool
    {
         $id =  DB::table('companies')
            ->insertGetId([
                'name' => $data->name,
                'inn' => $data->inn,
                'address' => $data->address,
                'status' => 'client',
                'user_id' => $data->user,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ]);

        return  DB::table('info_companies')
            ->insert([
                'id_company' => $id,
                'name_contact' => $data->contact,
                'phone_contact' => $data->phone,
                'email_contact' => $data->email,
                'info_company' => $data->info,
                'updated_at' => \Carbon\Carbon::now(),
                'created_at' => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Поиск по компаниям
     * @param string $text
     * @return \Illuminate\Support\Collection
     */
    public static function search(string $text): \Illuminate\Support\Collection
    {
        $text = strtoupper($text);
        // Получаем список столбцов таблицы
        $columnsCompanies = Schema::getColumnListing('companies');
        $columnsInfo = Schema::getColumnListing('info_companies');
        $columnCheck = Schema::getColumnListing('check_sale');

        $query = DB::table('companies')
            ->select('companies.id', 'companies.name')
            ->leftJoin('info_companies', 'companies.id', '=', 'info_companies.id_company')
            ->leftJoin('check_sale', 'companies.id', '=', 'check_sale.id_client')
            ->where('companies.status', '=', 'client');

        if (Auth::user()->admin !== true) {
            $query->where('companies.user_id', Auth::user()->id);
        }

        $query->where(function ($query) use ($columnsCompanies, $text) {
            foreach ($columnsCompanies as $column) {
                $query->orWhere('companies.' . $column, 'LIKE', '%' . $text . '%');
            }
        })
            ->orWhere(function ($query) use ($columnsInfo, $text) {
                $query->where('info_companies.status', '=', 'client'); // Фильтруем по статусу здесь
                foreach ($columnsInfo as $column) {
                    $query->orWhere('info_companies.' . $column, 'ILIKE', '%' . $text . '%');
                }
            })
            ->orWhere(function ($query) use ($columnCheck, $text) {
                $query->where('check_sale.status', '!=', ['100', 'trash']); // Фильтруем по статусу здесь
                foreach ($columnCheck as $column) {
                    $query->orWhere('check_sale.' . $column, 'LIKE', '%' . $text . '%');
                }
            })
        ->groupBy('companies.id', 'companies.name');

        return $query->get();
    }


}
