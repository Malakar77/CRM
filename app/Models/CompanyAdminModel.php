<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CompanyAdminModel extends Model
{
    use HasFactory;

    /**
     * Метод назначения менеджера
     * @param array $request
     * @return bool
     */
    public static function setManager(array $request): bool
    {

        for ($i = 0; $i < count($request['id']); $i++) {
            DB::table ('companies')
                ->where('id', '=', UtilityHelper::get_variable ($request['id'][$i]))
                ->update([
                    'user_id' => UtilityHelper::get_variable ($request['id_manager']),
                    'name_export' => UtilityHelper::get_variable ($request['name_export']),
                    'date_export' => \Carbon\Carbon::now(),
                    'status' => 'new',
                    'updated_at' => \Carbon\Carbon::now()
                ]);
        }
        return true;
    }

    /**
     * Метод удаления компаний
     * @param array $request
     * @return true
     */
    public static function deleteCompany(array $request): bool
    {
        for ($i = 0; $i < count($request); $i++) {
            DB::table ('companies')
                ->where('id', '=', UtilityHelper::get_variable ($request[$i]))
                ->update([
                    'status' => 'trash',
                    'updated_at' => \Carbon\Carbon::now()
                ]);
        }
        return true;
    }

    /**
     * Заполнение данными select
     * @return Collection
     */
    public static function getManager(): Collection
    {
        return DB::table('users')
            ->select ('id', 'name')
            ->where('work', true)
            ->get();
    }

    /**
     * Метод вывода списка выгрузок
     * @return Collection
     */
    public static function unLoadCompany(): Collection
    {
        return  DB::table('companies')
            ->join('users', 'users.id', '=', 'companies.user_id')
            ->select('companies.name_export', 'companies.date_export', 'users.name', DB::raw('count(*) as count'))
            ->where ('companies.status', '!=', 'client')
            ->where ('companies.status', '!=', 'trash')
            ->groupBy('companies.name_export', 'companies.date_export', 'users.name')
            ->get();
    }

    /**
     * Метод чтения файла эксель
     * @param string $file
     * @return array
     */
    static function writeFile(string $file): array
    {
        $reader = IOFactory::createReader('Xlsx');

        $spreadsheet = $reader->load($file);

        // Только чтение данных
        $reader->setReadDataOnly(true);

        // Данные в виде массива
        return $spreadsheet->getActiveSheet()->toArray();
    }

    /**
     * Метод добавления компаний
     * @param array $fileData
     * @return true
     */
    static function addCompany(array $fileData): bool
    {
        // Получаем все ИНН из файла
        $inns = array_column($fileData, 1);

        // Получаем уже существующие ИНН в базе
        $existingInns = DB::table('companies')
            ->whereIn('inn', $inns)
            ->pluck('inn')
            ->toArray();

        // Массив для новых записей
        $newCompanies = [];

        foreach ($fileData as $data) {
            $inn = UtilityHelper::get_variable($data[1]);

            // Пропускаем, если ИНН уже существует
            if (in_array($inn, $existingInns)) {
                continue;
            }

            // Добавляем данные в массив для массовой вставки
            $newCompanies[] = [
                'name' => UtilityHelper::get_variable($data[0]),
                'inn' => $inn,
                'address' => UtilityHelper::get_variable($data[2]),
                'status' => 'add',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];
        }

        // Массовая вставка данных
        if (!empty($newCompanies)) {
            DB::table('companies')->insert($newCompanies);
        }

        return true;
    }


    /**
     * Метод вывода компаний
     * @param string $search
     * @param int $page
     * @param string $status
     * @return LengthAwarePaginator
     */
    static function writeCompany(string $search='all', int $page = 1, string $status = 'add'): LengthAwarePaginator
    {

        if ($status == 'new') {
            $search = UtilityHelper::get_variable($search);
            $query = DB::table("companies")
                ->select("*")
                ->where ('name_export', '=', $search )
                ->where ('status', '!=', 'trash')
                ->where ('status', '!=', 'client')
                ->groupBy('id');
            return   $query->paginate(100, ['*'], 'page', $page);
        }

        $query = DB::table('companies')
            ->select('id', 'inn', 'name', 'address', 'status')
            ->where('status', '=', $status);

        if ($search !== 'all') {
            $query->where(function($query) use ($search) {
                global $status;
                $search = UtilityHelper::get_variable($search); // Оставляем ввод пользователя как есть
                $query->where('inn', 'ILIKE', '%' . $search . '%')
                    ->orWhere('name', 'ILIKE', '%' . $search . '%')
                    ->orWhere('address', 'ILIKE', '%' . $search . '%')
                    ->where('status', '=', $status);
            });
        }

        return $query->paginate(100, ['*'], 'page', $page);

    }



}
