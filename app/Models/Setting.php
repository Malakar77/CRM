<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Setting extends Model
{
    use HasFactory;

    /**
     * Вывод общей информации о пользователе
     */
    public static function user()
    {
        return DB::table('users')
            ->select('users.*')
            ->where('users.id', Auth::user()->id)
            ->first();
    }

    /**
     * Получение данных о должности
     * @param $id
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function otdel($id)
    {
        return DB::table('post_youth')
            ->select('post_youth.*')
            ->where('post_youth.id', $id)
            ->first();
    }

    /**
     * Получение данных о отделе
     * @param $id
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function departement($id)
    {
        return DB::table('post_youth')
            ->select('post_youth.*')
            ->where('post_youth.id', $id)
            ->first();
    }

    /**
     * Вывод имени и id пользователя
     */
    public static function nameAllUsers(): \Illuminate\Support\Collection
    {
        return DB::table('users')
            ->select('id', 'name')
            ->get();
    }

    /**
     * Вывод всех отделов
     * @return \Illuminate\Support\Collection
     */
    public static function postAll(): \Illuminate\Support\Collection
    {
        return DB::table('post_youth')
            ->select('id', 'name')
            ->where([
                'type' => 'post',
                'status' => 'work',
            ])
            ->get();
    }

    /**
     * Вывод всех должностей
     * @return \Illuminate\Support\Collection
     */
    public static function departmentAll(): \Illuminate\Support\Collection
    {
        return DB::table('post_youth')
            ->select('id', 'name')
            ->where([
                'type' => 'department',
                'status' => 'work',
            ])
            ->get();
    }


    /**
     * Получение данных о пользователе
     * @param $id
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function nameUserById($id)
    {
        return DB::table('users')
            ->select('*')
            ->where('id', $id)
            ->first();
    }

    /**
     * Обновление данных о пользователе
     * @param object $data
     * @return bool
     */
    public static function updateUser(object $data): bool
    {
        return DB::table('users')
            ->where('id', $data->id)
            ->update([
                'admin' => $data->admin,
                'work' => $data->work,
                'otdel' => $data->post,
                'dolzhost' => $data->youth,
                'prefix' => $data->prefix,
                'numberCheck' => $data->numberCheck,
                'numberContract' => $data->numberContract,
                'oklad' => $data->salary,
                'zp_do_plan' => $data->bonus_do,
                'zp_posl_plan' => $data->bonus_after,
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Добавление нового отдела/должности
     * @param object $data
     * @return int
     */
    public static function setPost(object $data): int
    {
        $type = UtilityHelper::get_variable($data->type);
        $name = UtilityHelper::get_variable($data->name);

        return DB::table('post_youth')
            ->insertGetId([
                'type' => $type,
                'name' => $name,
                'status' => 'work',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }
}
