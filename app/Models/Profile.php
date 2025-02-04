<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    use HasFactory;

    /**
     * Смена подписи и пароля от почты
     * @param object $profile
     * @return int
     */
    public static function setSignature(object $profile): int
    {
        return DB::table('users')
            ->where('id', $profile->id)
            ->update([
                'pass_email' => $profile->pass,
                'signature' => $profile->signature,
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Обновление аватарки
     * @param object $file
     * @return int
     */
    public static function setFile(object $file): int
    {
        return DB::table('users')
            ->where('id', $file->id)
            ->update([
                'link_ava' => $file->path,
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Вывод всех пользователей, постов и отделов
     * @return \Illuminate\Support\Collection
     */
    public static function getAllData(): \Illuminate\Support\Collection
    {
        // Получение пользователей
        $users = DB::table('users')
            ->select('id', 'name')
            ->where('id', Auth::user()->id)
            ->get();

        // Получение постов
        $posts = DB::table('post_youth')
            ->select('id', 'name')
            ->where([
                'type' => 'post',
                'status' => 'work',
            ])
            ->get();

        // Получение отделов
        $departments = DB::table('post_youth')
            ->select('id', 'name')
            ->where([
                'type' => 'department',
                'status' => 'work',
            ])
            ->get();

        // Возвращаем все данные в одном объекте или массиве
        return collect([
            'users' => $users,
            'posts' => $posts,
            'departments' => $departments
        ]);
    }

    /**
     * Установка имени пользователя
     * @param object $name
     * @return int
     */
    public static function setName(object $name): bool|int|string
    {
        if (!is_object($name)) {
            throw new \InvalidArgumentException('Expected an object, got ' . gettype($name));
        }

        $id = UtilityHelper::get_variable($name->id);
        $nameUser = UtilityHelper::get_variable($name->name);
        $surname = UtilityHelper::get_variable($name->surname);
        $patronymic = UtilityHelper::get_variable($name->patronymic);

        $res =  DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $surname . ' ' . $nameUser . ' ' . $patronymic,
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        if ($res) {
            return $surname . ' ' . $nameUser . ' ' . $patronymic;
        }

        return false;
    }
}
