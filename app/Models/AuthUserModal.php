<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\HasApiTokens;

class AuthUserModal extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $table = 'users';

    /**
     * Метод поиска пользователя
     * @param array $data
     * @return mixed
     */
    public static function SearchUser(array $data): mixed
    {
        return self::where('login', UtilityHelper::get_variable ($data['login']))->first();
    }


    /**
     * Метод поиска компании
     */
    public static function SearchCompany(string $data)
    {
        return DB::table('companyCrm')
            ->where('innCompany', $data)->first();
    }

    /**
     * Метод логирования действий
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public static function errorText(string $message, int $status): \Illuminate\Http\JsonResponse
    {
        Log::channel('errors')->error($message, [
            'time' => now()->toDateTimeString()
        ]);

        return response()->json([
            'errors' => [
                'login' => [$message]
            ]
        ], $status);
    }

}
