<?php

namespace App\Services\UtilityHelper;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UtilityHelper
{

    public static function get_variable($entry): string
    {
        // Удаление HTML и PHP тегов
        $entry = strip_tags($entry);

        // Обрезка пробелов с начала и конца строки
        $entry = trim($entry);

        // Преобразование специальных символов в HTML-сущности
        return htmlspecialchars($entry, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    // Шифрование текста с ключом
    public static function encrypt($text, $key): string
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($text, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

// Дешифрование текста с ключом
    public static function decrypt($encryptedText, $key): false|string
    {

        $data = base64_decode($encryptedText);

        $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));

        $encrypted = substr($data, openssl_cipher_iv_length('aes-256-cbc'));

        return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
    }

    public static function formatDate($dateString) {
        $months = ["января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря"];

        // Разделяем строку даты на год, месяц и день
        $dateParts = explode("-", $dateString);

        $number['y'] = $dateParts[0];
        $number['m'] = $months[intval($dateParts[1]) - 1];
        $number['d'] = $dateParts[2];
        $number['full'] = $dateParts[2] . " " . $months[intval($dateParts[1]) - 1] . " " . $dateParts[0];

        return $number;
    }

    /**
     * Возвращает сумму прописью
     * @uses morph(...)
     */

    public static function num2str($num): string

    {

        $nul = 'ноль';

        $ten = array(

            array('', 'один', 'два', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять'),

            array('', 'одна', 'две', 'три', 'четыре', 'пять', 'шесть', 'семь', 'восемь', 'девять')

        );

        $a20 = array('десять', 'одиннадцать', 'двенадцать', 'тринадцать', 'четырнадцать', 'пятнадцать', 'шестнадцать', 'семнадцать', 'восемнадцать', 'девятнадцать');

        $tens = array(2 => 'двадцать', 'тридцать', 'сорок', 'пятьдесят', 'шестьдесят', 'семьдесят', 'восемьдесят', 'девяносто');

        $hundred = array('', 'сто', 'двести', 'триста', 'четыреста', 'пятьсот', 'шестьсот', 'семьсот', 'восемьсот', 'девятьсот');

        $unit = array(

            array('копейка' , 'копейки',   'копеек',     1),

            array('рубль',    'рубля',     'рублей',     0),

            array('тысяча',   'тысячи',    'тысяч',      1),

            array('миллион',  'миллиона',  'миллионов',  0),

            array('миллиард', 'миллиарда', 'миллиардов', 0),

        );

        list($rub, $kop) = explode('.', sprintf("%015.2f", floatval($num)));

        $out = array();

        if (intval($rub) > 0) {

            foreach (str_split($rub, 3) as $uk => $v) {

                if (!intval($v)) continue;

                $uk = sizeof($unit) - $uk - 1;

                $gender = $unit[$uk][3];

                list($i1, $i2, $i3) = array_map('intval', str_split($v, 1));

                // mega-logic

                $out[] = $hundred[$i1]; // 1xx-9xx

                if ($i2 > 1) $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3]; // 20-99

                else $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; // 10-19 | 1-9

                // units without rub & kop

                if ($uk > 1) $out[] = self::morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);

            }

        } else {

            $out[] = $nul;

        }

        $out[] = self::morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub

        $out[] = $kop . ' ' . self::morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop

        return trim(preg_replace('/ {2,}/', ' ', join(' ', $out)));

    }

    /**
     * Склоняем словоформу
     */
    public static function morph($n, $f1, $f2, $f5): mixed
    {

        $n = abs(intval($n)) % 100;

        if ($n > 10 && $n < 20) return $f5;

        $n = $n % 10;

        if ($n > 1 && $n < 5) return $f2;

        if ($n == 1) return $f1;

        return $f5;

    }

    /**
     * @param $str
     * @return string
     */
    public static function mb_ucfirst($str): string
    {
        $fc = mb_strtoupper(mb_substr($str, 0, 1));
        return $fc . mb_substr($str, 1);
    }

    /**
     * Получение файла счета PDF
     * @return array
     */
    public static function getFilePDF($id): array
    {

        $check = \App\Models\Check_total::check(UtilityHelper::get_variable($id));

        $dompdf = new Dompdf();
        $dompdf->setPaper('A4', 'portrait');


        $path   = 'images/Logo.jpg';
        $iso = 'images/ISO.png';
        $images = 'images/Подпись.png';
        $stamp = 'images/Печать.png';



        $position = '';
        $total_position_sum_count = 0;


        foreach ($check['position'] as $key) {
            $price = (int) $key['price'] * 10000000;
            $totalPrice = ($price - ($price * 20 / 120)) / 10000000;
            $value = number_format($totalPrice, 2, '.', ' ');
            $position .= '
                        <tr>
                            <td style="text-align: center">'.$key['i'].'</td>
                            <td style="word-wrap: break-word">'.$key['name'].'</td>
                            <td class="text_end">'.$key['unit'].'</td>
                            <td class="text_end">'.$key['count'].'</td>

                            <td class="text_end">'.$value.'</td>
                            <td style="text-align: center">'.$key['nds'].'</td>
                            <td class="text_end">'.$key['sum_nds'].'</td>
                            <td class="text_end">'.$key['result'].'</td>
                        </tr>
            ';
            $total_position_sum_count += (int) $key['count'];

        }

        $html =  /* @lang HTML */
            '
 <!doctype html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Счет '.$check['number_check'].'от '.$check['date_check'].'.pdf</title>
    <style>
    html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,
    code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,
    dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,
    article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,
    ruby,section,summary,time,mark,audio,
    video{margin:0;padding:0;border:0; font-size:100%; font:inherit;vertical-align:baseline}
    article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}
    html{height:100%}
    body{line-height:1}
    ol,ul{list-style:none}
    blockquote,q{quotes:none}
    table{border-collapse:collapse;border-spacing:0}
    body {
        margin: 25px;
    }

        .container{

            font-size: 9px;
            font-family: "DejaVu Sans", sans-serif;
            display: block;


        }
        .row_images{

            width: 100%;
            height: 80px;
            margin-bottom: 15px;
        }
        .col_images_Logo{
            width: 200px;
            height: 100%;
            display: block;
            margin-left: auto;
        }
        .col_images_Logo img{
            width: 200px;
            height: 80px;
        }
        .col_images_Iso{
            width: 80px;
            height: 100%;
            display: block;
            float: left;
        }
        .col_images_Iso img{
            width: 80px;
            height: 100%;
        }
        .row_head{
            width: 100%;
            height: 130px;
            margin-bottom: 15px;
        }
        .row_text_head{
            display: block;
            padding: 0;
            height: 12px;

        }
        .col_text_head{
            height: 12px;
        }
        .col_text_head p{
            height: 12px;
            font-size: 7px;
            width: auto;
        }
        table{
            width: 100%;
        }
        th, td{
            table-layout: fixed;
            border-collapse: collapse;
            border: 1px solid #d9d9d9;
            padding: 5px;
        }

        .td_center{
            text-align: center;
            vertical-align: middle;
        }
        .td_vertical{
            vertical-align: middle;
        }
        .row_number{
            width: 100%;
            margin-bottom: 20px;
        }
        .col_number h5{
            font-size: 15px;
            font-weight: bold;
            text-align: center;
        }
        .col_comment{
            width: 95%;
            height: auto;
            margin: 0 auto;
        }
        .col_comment p{
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            word-break: break-word;
        }
        .row_company{
            width: 100%;
        }
        .col_company_provider{
            margin-bottom: 5px;
        }
        .col_company_client{
            margin-bottom: 15px;
        }
        .row_table_check{
            margin-bottom: 10px;
        }
        .text_end{
            text-align: right;
        }
        .row_count{
            width: 100%;
            height: 15px;
        }
        .col_count{
            width: 83%;
            float: left;
            margin-left: 0;
        }
        .col_count p{
            text-align: right;
        }
        .col_count_summ {
            width: 17%;
            float: left;
            margin-left: auto;
        }
        .col_count_summ p{
            padding-right: 5px;
            text-align: right;
        }
        .row_count_text{
            margin-top: 10px;
            width: 100%;
            height: 15px;
        }
        .col_count_text{
            width: 100%;
            height: 15px;
            text-align: left;
        }
        .col_count_text p{
            font-size: 8px;
        }
        .row_pod{
            width: 100%;
            height: 50px;
            position: relative;
        }
        .col_pod_dir, .col_pod_pod, .col_pod_name{
            width: 33%;
            height: 45px;
            display: block;
            float: left;
        }
        .col_pod_dir p, .col_pod_name p {
            margin-top: 30px; /* Устанавливаем отступ сверху */
        }
        .col_pod_dir{
            text-align: right;
        }

        .col_pod_pod{
            border-bottom: 1px solid #000000;
        }
        .row_pod img{
            width: 200px;
            position: absolute;
            top: 0;
            left: 35%;
            z-index: -1;
        }
        .container_pod{
            position: relative;
            width: 100%;
            height: 100px;
            margin-bottom: 20px;
        }
        .stamp{
            position: absolute;
            width: 230px;
            left: 45%;
            top: -35px;
        }
        .comment_text{
            text-transform: uppercase;
            font-weight: bold;
            font-size: 12px;
        }
        i{
            font-weight: bold;
        }
</style>
 </head>
 <body>

    <div class="container">

        <div class="row_images">
            <div class="col_images_Iso">
                <img src="' .self::image($iso).'"  alt="ISO">
            </div>
            <div class="col_images_Logo">
                <img src="'.self::image($path).'" alt="LOGO"/>
            </div>
        </div>
        <div class="row_head">
            <div class="row_text_head">
                <div class="col_text_head">
                    <p>Образец заполнения платежного поручения</p>
                </div>
            </div>
            <div class="row_table_head">
                <div class="col_table_head">
                    <table class="invoicePreview__bank-details" >
                        <tbody>
                            <tr>
                                <td rowspan="2" colspan="4"  style="height: 30px; padding-bottom: 0">
                                    Банк '.$check['bank'].'
                                    <div style=" margin-top: 15px; display: block;" >
                                        Банк получателя
                                    </div>
                                </td>
                                <td class="td_center">
                                    БИК
                                </td>
                                <td class="td_vertical">
                                '.$check['bik_bank_company'].'
                                </td>
                            </tr>
                            <tr>
                                <td class="td_center">Сч. №</td>
                                <td class="td_vertical">
                                    '.$check['ras_chet'].'
                                </td>
                            </tr>
                            <tr>
                                <td style="height: 10px;" class="td_center">
                                    ИНН
                                </td>
                                <td class="td_vertical">
                                    '.$check['inn_company'].'
                                </td>
                                <td class="td_center">
                                    КПП
                                </td>
                                <td class="td_vertical">
                                    '.$check['kpp_company'].'
                                </td>
                                <td  rowspan="2" style="text-align: center">
                                    Сч. №
                                </td>
                                <td  rowspan="2" >
                                     '.$check['kor_chet'].'
                                </td>
                            </tr>
                            <tr style="border: 1px solid black;">
                                <td class="td_vertical" colspan="4" style="height: 30px; padding-bottom: 0">
                                '.$check['company_name'].'
                                <div style=" margin-top: 10px; display: block; margin-bottom: 5px">Получатель</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row_number">
            <div class="col_number">
                <h5>Счет на оплату № '.$check['number_check'].' от '.$check['date_check'].'</h5>
            </div>
            <div class="col_comment">
              <p>'.$check['comment'].'</p>
            </div>
        </div>
        <div class="row_company">
            <div class="col_company_provider">
                <p> <i>Поставщик:</i> '.$check['company_name'].', '.$check['ur_address_company'].'</p>
            </div>
            <div class="col_company_client">
                <p><i>Покупатель:</i> '.$check['name'].' ИНН '.$check['inn'].' '.$check['address'].'</p>
            </div>
        </div>
        <div class="row_table_check">
            <div class="col_table_check" style=" margin-top: 15px;">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%">№ </th>
                            <th style="text-align: left; width: 40%;">Товар или услуга </th>
                            <th style="width: 5%;">Ед.из</th>
                            <th class="text_end" style="width: 10%;">Кол-во </th>
                            <th class="text_end" style="width: 5em;">Цена</th>
                            <th style="width: 5%;">НДС</th>
                            <th class="text_end">Сумма НДС </th>
                            <th class="text_end">Всего с НДС </th>
                        </tr>
                    </thead>
                    <tbody class="table_check_body">
                        '.$position.'


                        <tr>
                            <td  colspan="3" >Итого:</td>
                            <td class="text_end">'.number_format($total_position_sum_count, 2, '.', '') .'</td>
                            <td colspan="2"></td>
                            <td class="text_end">'.$check['totalSumNds'].' руб</td>
                            <td class="text_end">'.$check['totalResult'].' руб</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row_count">
            <div class="col_count"><p><i>Итого:</i></p></div>
            <div class="col_count_summ"><p>'.$check['totalResult'].' руб</p></div>
        </div>
        <div class="row_count">
            <div class="col_count"><p><i>Сумма НДС:</i></p></div>
            <div class="col_count_summ"><p>'.$check['totalSumNds'].' руб</p></div>
        </div>
        <div class="row_count">
            <div class="col_count"><p><i>Всего:</i></p></div>
            <div class="col_count_summ"><p>'.$check['totalResult'].' руб</p></div>
        </div>
        <div class="row_count_text">
            <div class="col_count_text">
                <p><i>Сумма прописью:</i> '.\App\Services\UtilityHelper\UtilityHelper::mb_ucfirst(\App\Services\UtilityHelper\UtilityHelper::num2str($check['totalResult'])).' в т. ч. НДС 20% - '. $check['totalSumNds'].' руб</p>
            </div>
        </div>
        <div class="container_pod">
            <img class="stamp" src="' .self::image($stamp).'"  alt="shtamp">
            <div class="row_pod">
            <img src="' .self::image($images).'"  alt="pod">
                <div class="col_pod_dir">
                    <p>Генеральный директор:</p>
                </div>
                <div class="col_pod_pod"></div>
                <div class="col_pod_name">
                    <p>'.env('DIRECTOR').'</p>
                </div>
            </div>
            <div class="row_pod">
            <img src="' .self::image($images).'"  alt="pod">
                <div class="col_pod_dir">
                    <p>Главный бухгалтер:</p>
                </div>
                <div class="col_pod_pod"></div>
                <div class="col_pod_name">
                    <p>'.env('ACCOUTANT').'</p>
                </div>
            </div>
        </div>
        <div class="row_count_text">
            <div class="col_count_text comment_text">
                <p>Примечание:</p>
            </div>
        </div>
        <div class="row_count_text">
            <div class="col_count_text">
                <p>'.$check['text'].'</p>
            </div>
        </div>
    </div>
 </body>
 </html>
';

        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->render();

        $pdfContent = $dompdf->output();
        $filePath = preg_replace('/[\/:*?"<>|]/', '_', 'Счет № ' . $check['number_check'] . ' от ' . $check['date_check'] . '.pdf');
        Storage::disk('public')->put($filePath, $pdfContent);

        $result['url'] = Storage::url($filePath);
        $result['name'] = 'Счет № ' . $check['number_check'] . ' от ' . $check['date_check'];
        return  $result;
    }

    /**
     * Обработка картинки для DOMPdf
     * @param $path
     * @return string
     */
    private static function image($path): string
    {
        $type   = pathinfo ( $path , PATHINFO_EXTENSION );
        $data   = file_get_contents ( $path );
        return 'data:image/' . $type . ';base64,' . base64_encode ( $data );
    }

    /**
     * Обновление номера счета
     * @return bool
     */
    public static function updateNumber(): bool
    {
        // Получаем id текущего пользователя
        $userId = Auth::id();

        // Получаем номер проверки пользователя
        $number = DB::table('users')
            ->select('prefix', 'numberCheck as number')
            ->where('id', '=', $userId)
            ->first();

        // Обновляем номер проверки пользователя
        if ($number) {
            DB::table('users')
                ->where('id', '=', $userId)
                ->update([
                    'numberCheck' => $number->number + 1,
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
        }

        return true;
    }

}
