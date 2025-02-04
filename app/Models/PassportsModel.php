<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PassportsModel extends Model
{
    use HasFactory;
    protected $table = 'logistics';

    public static function getPassportLogistics(int $id): mixed
    {
        return self::query()->select('id', 'name', 'surname', 'patronymic', 'document', 'series', 'number', 'issued', 'date_issued' )
            ->where('id', UtilityHelper::get_variable($id))->first();
    }

    public static function addPassport(int $id, array $passport ): mixed
    {
        return self::query()->where('id', $id)
            ->update([
                'document' => $passport['document'],
                'series' => $passport['seria'],
                'number' => $passport['numberPassport'],
                'issued' => $passport['given'],
                'date_issued' => $passport['dateGiven'],
                ]);
    }

    public static function addAttorney(object $data)
    {

        // Проверяем дату и заменяем '0000-00-00' на null
        $dateOt = UtilityHelper::get_variable($data->date_ot);
        $dateDo = UtilityHelper::get_variable($data->date_do);

        $dateOt = ($dateOt && $dateOt != '0000-00-00') ? $dateOt : null;
        $dateDo = ($dateDo && $dateDo != '0000-00-00') ? $dateDo : null;

        $id_logist = ($data->idLogist !== null) ? UtilityHelper::get_variable($data->idLogist) : null;

        return DB::table('attorney')->insertGetId([
            'company' => UtilityHelper::get_variable($data->company),
            'numberDov' => UtilityHelper::get_variable($data->numberDov),
            'date_ot' => $dateOt,
            'date_do' => $dateDo,
            'id_logist' => $id_logist,
            'companyProvider' => UtilityHelper::get_variable($data->companyProvider),
            'info' => UtilityHelper::get_variable($data->info),
            'id_manager' => Auth::user()->getAuthIdentifier(),
            'status' => true,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }


}
