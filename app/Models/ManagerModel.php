<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ManagerModel extends Model
{
    use HasFactory;


    /**
     * Метод вывода всех менеджеров
     * @param string $search поисковой запрос если есть в противном случае all
     * @param int $page номер страницы
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function managerAll(string $search, int $page = 1): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {

        $query = DB::table('providers')
            ->join('managers', 'providers.id', '=', 'managers.id_company')
            ->select('providers.name', 'managers.id', 'managers.name_manager', 'managers.phone', 'managers.email', 'managers.status');

        if ($search !== 'all') {
            $query->where('providers.name', 'ILIKE', '%' . $search . '%')
                ->orWhere('managers.name_manager', 'ILIKE', '%' . $search . '%')
                ->orWhere('managers.phone', 'ILIKE', '%' . $search . '%')
                ->orWhere('managers.email', 'ILIKE', '%' . $search . '%');
        }

        $query->where('managers.status', '!=', false);

        return   $query->paginate(24, ['*'], 'page', $page);
    }


    /**
     * Метод получения данных о компаниях поставщиков
     * @return Collection
     */
    public static function getCompanyProvider(): Collection
    {
        return DB::table('providers')
        ->select('id', 'name')
        ->get();
    }

    /**
     * Метод добавления менеджера
     * @param $data array массив данных их формы
     * @return false|int id добавленной записи
     */
    public static function addManager($data)
    {
        $result = DB::table('managers')->insertGetId([
            'id_company' => UtilityHelper::get_variable($data['companyProvider']),
            'name_manager' => UtilityHelper::get_variable($data['name']),
            'phone'      => UtilityHelper::get_variable($data['phone']),
            'email'      => UtilityHelper::get_variable($data['email']),
            'status'     => true,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        return $result ?: false;
    }


    /**
     * Метод редактирования менеджера
     * @param $data
     * @return false|int
     */
    public static function editManager($data)
    {
        $result = DB::table('managers')->where('id', $data['id'])->update([
            'name_manager' => UtilityHelper::get_variable($data['name']),
            'phone' => UtilityHelper::get_variable($data['phone']),
            'email' => UtilityHelper::get_variable($data['email']),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        return $result ?: false;
    }


    /**
     * Метод вывода менеджера компании
     * @param $id int id менеджера которого только добавили
     * @return Collection
     */
    public static function getManagerById($id)
    {
        return DB::table('providers')
                ->join('managers', 'providers.id', '=', 'managers.id_company')
                ->select('providers.name', 'managers.name_manager', 'managers.phone', 'managers.email')
                ->where('managers.id', $id)
                ->get();
    }

    /**
     * Метод удаления компании
     * @param int $id записи
     * @return int
     */
    public static function deleteManager(int $id): int
    {
        $result = DB::table('managers')->where('id', $id)->update([
            'status' => false,
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        return $result ?: false;
    }
}
