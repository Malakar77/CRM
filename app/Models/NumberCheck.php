<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NumberCheck extends Model
{
    use HasFactory;

    /**
     * Поиск последнего счета
     * @param string $baseNumber
     * @return string
     */
    public static function generateNumber(string $baseNumber): string
    {
        // Ищем все номера, начинающиеся с базового
        $numbers = DB::table('check_sale')
            ->where('number_check', 'LIKE', "{$baseNumber}%")
            ->pluck('number_check')
            ->toArray();

        // Если точного номера нет, возвращаем его как есть
        if (!in_array($baseNumber, $numbers)) {
            preg_match('/\d+/u', $baseNumber, $matches); // Ищем первую последовательность цифр
            $output = $matches[0] ?? '';
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['numberCheck' => $output]);
            return $baseNumber;
        }

        // Инициализируем массив для суффиксов
        $suffixes = [0]; // Добавляем 0, чтобы учитывать базовый номер без суффикса

        foreach ($numbers as $number) {
            // Проверяем, есть ли суффикс после "/"
            if (preg_match('/\/(\d+)$/', $number, $matches)) {
                // Извлекаем числовой суффикс
                $suffixes[] = (int)$matches[1];
            }
        }

        // Определяем следующий суффикс
        $nextSuffix = max($suffixes) + 1;

        // Если базовый номер уже имеет суффикс, отрезаем его
        $cleanBase = preg_replace('/\/\d+$/', '', $baseNumber);

        // Формируем новый номер
        return "{$cleanBase}/{$nextSuffix}";
    }





}
