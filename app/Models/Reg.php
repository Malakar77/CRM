<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Reg extends Model
{
    use HasFactory;

    protected $fillable = ['innCompany', 'login', 'password'];
    protected $table = 'users';

    // Метод для создания новой записи
    public static function createNew(array $data): Reg
    {
        $data = array_map([UtilityHelper::class, 'get_variable'], $data);
        return self::create([
            'innCompany' => $data['innCompany'],
            'login' => $data['login'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Метод для проверки существования записи
     * @param array $data
     * @return mixed
     */
    public static function recordExists(array $data): mixed
    {
        $data = array_map([UtilityHelper::class, 'get_variable'], $data);
        return self::where('login', $data['login'])->exists();
    }

    /**
     * Метод проверки компании на существование
     * @param array $data
     * @return bool
     */
    public static function checkCompanyExists(array $data): bool
    {
        $data = array_map([UtilityHelper::class, 'get_variable'], $data);
        return DB::table('companyCrm')
            ->where('innCompany', $data['innCompany'])
            ->exists();
    }
}
