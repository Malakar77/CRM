<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LogisticModel extends Model
{
    use HasFactory;

    protected $table = 'logistics';

    /**
     * Метод вывода города
     * @return \Illuminate\Support\Collection
     */
    public static function getCity(): \Illuminate\Support\Collection
    {
        return self::query()->distinct()->pluck('city');
    }


    public static function getLogistics(int $page = 1, string $search = 'all'): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = self::query()->select('id', 'statistic', 'name', 'surname', 'patronymic', 'phone', 'transport', 'city');

        if ($search !== 'all') {
            $query->where(function($query) use ($search) {
                $search = UtilityHelper::get_variable($search); // Оставляем ввод пользователя как есть
                $query->where('name', 'ILIKE', '%' . $search . '%')
                    ->orWhere('surname', 'ILIKE', '%' . $search . '%')
                    ->orWhere('patronymic', 'ILIKE', '%' . $search . '%')
                    ->orWhere('phone', 'ILIKE', '%' . $search . '%')
                    ->orWhere('transport', 'ILIKE', '%' . $search . '%')
                    ->orWhere('city', 'ILIKE', '%' . $search . '%');
            });
        }

        return $query->paginate(21, ['*'], 'page', $page);

    }

    /**
     * Метод добавления экспедитора
     */
    public static function addLogist(object $data): void
    {
        $logist= self::where('phone', UtilityHelper::get_variable($data->phone))->first();

        if($logist !== null){
            throw new Exception('Логист с таким номером телефона уже существует.');
        }

        self::query()->insert([
            'city' => UtilityHelper::get_variable($data->city),
            'info' => UtilityHelper::get_variable($data->info),
            'name' => UtilityHelper::get_variable($data->name),
            'patronymic' => UtilityHelper::get_variable($data->patronymic),
            'phone' => UtilityHelper::get_variable($data->phone),
            'surname' => UtilityHelper::get_variable($data->surname),
            'transport' => UtilityHelper::get_variable($data->transport),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        Log::info('New logistic added', ['id' => auth()->id(), 'logistic_name' => $data->name]);

    }

    public static function getInfoLogistics(int $id): mixed
    {

        return self::query()->select('id', 'statistic', 'name', 'surname', 'patronymic', 'phone', 'transport', 'info')
                                ->where('id', UtilityHelper::get_variable($id))->first();
    }





}
