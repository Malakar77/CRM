<?php

namespace App\Services;

class Pagination
{
    /**
     * Публичный метод для генерации переключателей страниц
     * @param $countPage int Последняя страница
     * @param $actPage int активная страница
     * @return array
     */
    public static function printPage(int $countPage, int $actPage): array
    {
        // Если страниц 0 или 1, вернём пустой массив (переключатели не выводятся)
        if ($countPage == 0 || $countPage == 1)
            return array();

        $pageArray = array();
        if ($countPage > 10) {
            // Если страниц больше 10, заполним массив pageArray переключателями в зависимости от активной страницы
            if ($actPage <= 4 || $actPage + 3 >= $countPage) {
                for ($i = 0; $i <= 4; $i++) {
                    $pageArray[$i] = $i + 1;
                }
                $pageArray[5] = "...";
                for ($j = 6, $k = 4; $j <= 10; $j++, $k--) {
                    $pageArray[$j] = $countPage - $k;
                }
            } else {
                $pageArray[0] = 1;
                $pageArray[1] = 2;
                $pageArray[2] = "...";
                $pageArray[3] = $actPage - 2;
                $pageArray[4] = $actPage - 1;
                $pageArray[5] = $actPage;
                $pageArray[6] = $actPage + 1;
                $pageArray[7] = $actPage + 2;
                $pageArray[8] = "...";
                $pageArray[9] = $countPage - 1;
                $pageArray[10] = $countPage;
            }
        } else {
            // Если страниц меньше 10, просто заполним массив переключателей всеми номерами страниц подряд.
            for ($n = 0; $n < $countPage; $n++) {
                $pageArray[$n] = $n + 1;
            }
        }
        return $pageArray;
    }
}
