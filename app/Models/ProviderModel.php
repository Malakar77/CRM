<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ProviderModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'providers';

    protected $fillable = ['updated_at'];

    const DELETED_AT = 'deleted_at';

    /**
     * Метод вывода всех категорий
     * @return \Illuminate\Support\Collection
     */
    public static function getAllCategories(): \Illuminate\Support\Collection
    {
        return DB::table('providers')
            ->select('catalog')
            ->distinct()
            ->whereNull('providers.deleted_at')
            ->orderBy('catalog')
            ->get();
    }

    /**
     * Метод получения компаний и их разбитие по страницам
     * @param int $page номер страницы для вывода по умолчанию 1
     * @return LengthAwarePaginator
     */
    public static function getAllProviders(int $page = 1): LengthAwarePaginator
    {
        return DB::table('providers')
            ->select('id', 'catalog', 'name', 'phone', 'city', 'link')
            ->whereNull('providers.deleted_at')
            ->paginate(24, ['*'], 'page', $page);
    }

    /**
     * Метод поиска компаний по ссылкам
     * @param int $page
     * @param $categorize
     * @return LengthAwarePaginator
     */
    public static function searchCompany($categorize, int $page = 1): LengthAwarePaginator
    {
        // Получаем список столбцов таблицы
        $columns = Schema::getColumnListing('providers');

        return DB::table('providers')
            ->where(function ($query) use ($categorize, $columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', '%' . $categorize . '%');
                }
            })
            ->whereNull('providers.deleted_at')
            ->paginate(24, ['*'], 'page', $page);
    }

    /**
     * Метод Добавления компании
     * @param $data
     * @return int
     */
    public static function addProvider($data): int
    {
        return DB::table('providers')->insertGetId([
            'catalog' => UtilityHelper::get_variable($data->categories),
            'name' => UtilityHelper::get_variable($data->name),
            'phone' => UtilityHelper::get_variable($data->phone),
            'link' => UtilityHelper::get_variable($data->website),
            'city' => UtilityHelper::get_variable($data->city),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }

    public static function deleteProvider(int $id): int
    {
        return self::findOrFail($id)->delete();
    }

    public static function getProvider(int $id)
    {
        return self::find($id);
    }

    public static function updateProvider(object $data): int
    {
        return DB::table('providers')
            ->where('id', $data->id)
            ->update([
                'catalog' => $data->categories,
                'name' => $data->name,
                'phone' => $data->phone,
                'link' => $data->website,
                'city' => $data->city,
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }

}
