<?php

namespace App\Http\Controllers;

use App\Services\UtilityHelper\UtilityHelper;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class Check_total extends Controller
{
    public function index(Request $request)
    {
        $checkId = $request->validate([
            'check' => 'required|integer|min:1',
        ]);

        return view('check_total', ['headers' => \App\Models\Check_total::check($checkId['check'])]);
    }

    /**
     * Запись Примечания
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function setComment(Request $request)
    {
        $validData = $request->validate([
            'id' => 'required|integer|min:1',
            'text' => 'nullable|string',
        ]);

        $id = UtilityHelper::get_variable($validData['id']);
        $text = htmlspecialchars(trim($validData['text'])) ;

        $result =  \App\Models\Check_total::setComment($id, $text);

        return response()->json($result);
    }

    /**
     * Получение файла счета PDF
     * @param Request $request
     * @return string
     */
    public function getFile(Request $request)
    {
        $checkId = $request->validate([
            'id' => 'required|integer|min:1',
        ]);

        return response()->json(UtilityHelper::getFilePDF($checkId['id']), 200);
    }

    /**
     * Получение файла счета xlsx
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function exelCheck(Request $request)
    {
        $checkId = $request->validate([
            'id' => 'required|integer|min:1',
        ]);
        $check = \App\Models\Check_total::check(UtilityHelper::get_variable($checkId['id']));

        $spreadsheet = new Spreadsheet();
// Устанавливаем ширину для каждого столбца от A до AN
        for ($column = 'A'; $column !== 'AO'; $column++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column)->setWidth(16, 'px');
        }

        $logo = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo -> setPath('images/Logo.jpg');
        $logo->setHeight(64);
        $logo->setCoordinates('A1');

        $iso = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $iso->setName('iso');
        $iso->setDescription('iso');
        $iso -> setPath('images/ISO.png');
        $iso->setHeight(84);
        $iso->setCoordinates('AI1');
//Картинки логотип и исо

        $spreadsheet->getActiveSheet()->mergeCells('A1:K3');
        $spreadsheet->getActiveSheet()->mergeCells('AI1:AN4');
        $spreadsheet->getActiveSheet()->getRowDimension('1')->setRowHeight(21);
        $logo->setWorksheet($spreadsheet->getActiveSheet());
        $iso->setWorksheet($spreadsheet->getActiveSheet());

        //Надпись над таблицей реквизитов
        $spreadsheet->getActiveSheet()->mergeCells('A5:T5');
        $spreadsheet->getActiveSheet()->setCellValue("A5", 'Реквизиты для заполнения платёжного поручения');

        //Таблица реквизитов
        /* -------------- Обьединение ячеек ------------ */
        $spreadsheet->getActiveSheet()->mergeCells('A6:Y7'); //Банк
        $spreadsheet->getActiveSheet()->mergeCells('Z6:AC6'); //Бик
        $spreadsheet->getActiveSheet()->mergeCells('Z7:AC7'); //кор счет
        $spreadsheet->getActiveSheet()->mergeCells('AD6:AN6'); //Номер бик
        $spreadsheet->getActiveSheet()->mergeCells('AD7:AN7'); //Кор Счет
        $spreadsheet->getActiveSheet()->mergeCells('AD8:AN10'); //Рас счет
        $spreadsheet->getActiveSheet()->mergeCells('Z8:AC10'); //Рас счет
        $spreadsheet->getActiveSheet()->mergeCells('A8:F8'); //Инн
        $spreadsheet->getActiveSheet()->mergeCells('G8:N8'); //Номер инн
        $spreadsheet->getActiveSheet()->mergeCells('O8:Q8'); //Кпп
        $spreadsheet->getActiveSheet()->mergeCells('R8:Y8'); //Номер Кпп
        $spreadsheet->getActiveSheet()->mergeCells('A9:Y10'); //Получатель

        /* -------------- Установка высоты таблицы ------------ */
        $spreadsheet->getActiveSheet()->getRowDimension('6')->setRowHeight(23);
        $spreadsheet->getActiveSheet()->getRowDimension('7')->setRowHeight(23);
        /* -------------- Установка Обводки таблицы ------------ */
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FFFF'],
                ],
            ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A6:AN10')->applyFromArray($styleArray);
        /* -------------- Заполнение заголовков таблицы ------------ */
        $spreadsheet->getActiveSheet()->setCellValue("Z6", 'БИК');
        $spreadsheet->getActiveSheet()->setCellValue("Z7", 'Кор.счет');
        $spreadsheet->getActiveSheet()->setCellValue("A8", 'ИНН');
        $spreadsheet->getActiveSheet()->setCellValue("O8", 'КПП');
        $spreadsheet->getActiveSheet()->setCellValue("Z8", 'Рас.счет');
        /* -------------- Центровка заголовков таблицы ------------ */
        $spreadsheet->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('AD6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('AD6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('Z7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('Z7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('Z6')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('Z6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('Z8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('Z8')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('G8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('G8')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('AD8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('AD8')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('AD7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('AD7')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('R8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A9')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('A6')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        /* -------------- Заполнение самой таблицы ------------ */

        $spreadsheet->getActiveSheet()->setCellValue("A6", $check['bank']);
        $spreadsheet->getActiveSheet()->setCellValue("AD6", $check['bik_bank_company']);
        $spreadsheet->getActiveSheet()->setCellValue("AD7", $check["kor_chet"]);
        $spreadsheet->getActiveSheet()->setCellValue("AD8", $check["ras_chet"]);
        $spreadsheet->getActiveSheet()->setCellValue("G8", $check["inn_company"]);
        $spreadsheet->getActiveSheet()->setCellValue("R8", $check["kpp_company"]);
        $spreadsheet->getActiveSheet()->setCellValue("A9", htmlspecialchars_decode($check["company_name"]));
        /* -------------- Выравнивание самой таблицы ------------ */
        $spreadsheet->getActiveSheet()->getStyle('H6:H8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('H6:H8')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

//Шрифт
        $spreadsheet->getActiveSheet()->getStyle('A5')->getFont()->setSize(8);

        /* -------------- поставщик и плательщик  ------------ */
        $spreadsheet->getActiveSheet()->mergeCells('A12:E12');// Поставщик
        $spreadsheet->getActiveSheet()->mergeCells('A15:E15');// Покупатель
        $spreadsheet->getActiveSheet()->setCellValue("A12", 'Поставщик:');
        $spreadsheet->getActiveSheet()->setCellValue("A15", 'Покупатель:');


        /* -------------- Информация поставщик и плательщик  ------------ */

        $spreadsheet->getActiveSheet()->mergeCells('F12:AN13');// Поставщик
        $spreadsheet->getActiveSheet()->mergeCells('F15:AN16');// Покупатель
        $provider = htmlspecialchars_decode($check["company_name"])." ИНН: ".$check["inn_company"]." Адрес: ".$check["ur_address_company"];
        $client = htmlspecialchars_decode($check["name"])." ИНН: ".$check["inn"]." Адрес: ".$check["address"];
        $spreadsheet->getActiveSheet()->setCellValue("F12", $provider);
        $spreadsheet->getActiveSheet()->setCellValue("F15", $client);
        $spreadsheet->getActiveSheet()->getStyle('F12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('F12')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $spreadsheet->getActiveSheet()->getStyle('F15')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('F15')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $style = [
            'alignment' => [
                'wrapText' => true, // Включаем перенос текста
            ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('F12')->applyFromArray($style);
        $spreadsheet->getActiveSheet()->getStyle('F15')->applyFromArray($style);
        $spreadsheet->getActiveSheet()->getStyle('A12')->getFont()->setBold(true);
        $spreadsheet->getActiveSheet()->getStyle('A15')->getFont()->setBold(true);

        /* -------------- Номер счета  ------------ */
        $spreadsheet->getActiveSheet()->mergeCells('B18:AM18');
        $spreadsheet->getActiveSheet()->getStyle('B18')->getFont()->setBold(true);
        $check_num = "Счет № ".$check["number_check"]." от ".$check["date_check"];
        $spreadsheet->getActiveSheet()->setCellValue("B18", $check_num);
        $spreadsheet->getActiveSheet()->getStyle('B18')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
//Отступ в одну строку с высотой в 6 пунктов
        $spreadsheet->getActiveSheet()->getRowDimension('19')->setRowHeight(6);
        /* -------------- Доп комментарий  ------------ */
        $spreadsheet->getActiveSheet()->mergeCells('B20:AM20');
        $spreadsheet->getActiveSheet()->setCellValue("B20", $check["comment"]);
        $spreadsheet->getActiveSheet()->getStyle('B20')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('B20')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('B20')->getAlignment()->setShrinkToFit(true);

        // * -------------- Таблица товаров  ------------
        // -------------- Шапка таблицы ------------
        $spreadsheet->getActiveSheet()->mergeCells('A21:B22');
        $spreadsheet->getActiveSheet()->mergeCells('C21:M22');
        $spreadsheet->getActiveSheet()->mergeCells('N21:P22');
        $spreadsheet->getActiveSheet()->mergeCells('Q21:S22');
        $spreadsheet->getActiveSheet()->mergeCells('T21:W22');
        $spreadsheet->getActiveSheet()->mergeCells('X21:AB22');
        $spreadsheet->getActiveSheet()->mergeCells('AC21:AD22');
        $spreadsheet->getActiveSheet()->mergeCells('AE21:AI22');
        $spreadsheet->getActiveSheet()->mergeCells('AJ21:AN22');
        $spreadsheet->getActiveSheet()->getStyle('A21:AN22')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->setCellValue("A21", '№');
        $spreadsheet->getActiveSheet()->setCellValue("C21", 'Наименование');
        $spreadsheet->getActiveSheet()->setCellValue("N21", 'Ед.изм');
        $spreadsheet->getActiveSheet()->setCellValue("Q21", 'Кол-во');
        $spreadsheet->getActiveSheet()->setCellValue("T21", 'Цена');
        $spreadsheet->getActiveSheet()->setCellValue("X21", 'Сумма');
        $spreadsheet->getActiveSheet()->setCellValue("AC21", 'НДС %');
        $spreadsheet->getActiveSheet()->setCellValue("AE21", 'Сумма НДС');
        $spreadsheet->getActiveSheet()->setCellValue("AJ21", 'Всего с НДС');
        $spreadsheet->getActiveSheet()->getStyle('AC21')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getStyle('A21')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('A21')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('C21')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('C21')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('N21')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('N21')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('Q21')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('Q21')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('T21')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('T21')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('X21')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('X21')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('AC21')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('AC21')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('AE21')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('AE21')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->getStyle('AJ21')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('AJ21')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        function setWrapText($text, $num): float|int
        {
            return ceil(strlen($text)/$num)*12;
        }

        $index = 23;
        $sum_count_position = 0;
        foreach ($check['position'] as $key) {
            $price = (int) $key['price'] * 10000000;
            $totalPrice = ($price - ($price * 20 / 120)) / 10000000;
            $value = number_format($totalPrice, 2, '.', ' ');
            $spreadsheet->getActiveSheet()->mergeCells('A'. $index.':'.'B'. $index);
            $spreadsheet->getActiveSheet()->mergeCells('C'. $index.':'.'M'. $index);
            $spreadsheet->getActiveSheet()->mergeCells('N'. $index.':'.'P'. $index);
            $spreadsheet->getActiveSheet()->mergeCells('Q'. $index.':'.'S'. $index);
            $spreadsheet->getActiveSheet()->mergeCells('T'. $index.':'.'W'. $index);
            $spreadsheet->getActiveSheet()->mergeCells('X'. $index.':'.'AB'. $index);
            $spreadsheet->getActiveSheet()->mergeCells('AC'. $index.':'.'AD'. $index);
            $spreadsheet->getActiveSheet()->mergeCells('AE'. $index.':'.'AI'. $index);
            $spreadsheet->getActiveSheet()->mergeCells('AJ'. $index.':'.'AN'. $index);


            $spreadsheet->getActiveSheet()->setCellValue("A" . $index, $key["i"]);
            $spreadsheet->getActiveSheet()->setCellValue("C" . $index, $key["name"]);
            $spreadsheet->getActiveSheet()->getRowDimension($index)->setRowHeight(setWrapText($key["name"], 25));
            $spreadsheet->getActiveSheet()->setCellValue("N" . $index, $key["unit"]);
            $spreadsheet->getActiveSheet()->setCellValue("Q" . $index, $key["count"]);
            $spreadsheet->getActiveSheet()->setCellValue("T" . $index, $value);
            $spreadsheet->getActiveSheet()->setCellValue("X" . $index, $key["sum"]);

            $spreadsheet->getActiveSheet()->setCellValue("AC" . $index, $key["nds"]);
            $spreadsheet->getActiveSheet()->setCellValue("AE" . $index, $key["sum_nds"]);
            $spreadsheet->getActiveSheet()->setCellValue("AJ" . $index, $key["result"]);
            $spreadsheet->getActiveSheet()->getStyle('A'. $index.':'.'AN'. $index)->applyFromArray($styleArray);
            $spreadsheet->getActiveSheet()->getStyle('A'. $index.':'.'AN'. $index)->getAlignment()->setWrapText(true);
            $sum_count_position += $key["count"];
            $index++;
        }
        $index_row = count($check['position']);

        $worksheetCount = $spreadsheet->getSheetCount();
        for ($i = 0; $i < $worksheetCount; $i++) {
            if ($i !== $worksheetCount - 1) { // Если лист не последний
                $spreadsheet->getSheet($i)->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(21, 22);
            } else { // Если лист последний
                $spreadsheet->getSheet($i)->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(0, 0);
            }
        }
        $result = $index_row+23;
        $spreadsheet->getActiveSheet()->mergeCells('A'.$result.':P'.$result);
        $spreadsheet->getActiveSheet()->mergeCells('Q'.$result.':S'.$result);
        $spreadsheet->getActiveSheet()->mergeCells('T'.$result.':W'.$result);
        $spreadsheet->getActiveSheet()->mergeCells('X'.$result.':AB'.$result);
        $spreadsheet->getActiveSheet()->mergeCells('AC'.$result.':AD'.$result);
        $spreadsheet->getActiveSheet()->mergeCells('AE'.$result.':AI'.$result);
        $spreadsheet->getActiveSheet()->mergeCells('AJ'.$result.':AN'.$result);
        $spreadsheet->getActiveSheet()->getStyle('A'. $result.':'.'AN'. $result)->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->setCellValue("A" . $result, 'Итого');
        $spreadsheet->getActiveSheet()->setCellValue("Q" . $result, $sum_count_position);
//        $spreadsheet->getActiveSheet()->setCellValue("X" . $result, $sum_price);
        $spreadsheet->getActiveSheet()->setCellValue("AE" . $result, $check['totalSumNds']);
        $spreadsheet->getActiveSheet()->setCellValue("AJ" . $result, $check['totalResult']);
//        $spreadsheet->getActiveSheet()->getRowDimension($result)->setRowHeight(setWrapText($key["name"],25));
        $spreadsheet->getActiveSheet()->getStyle('A'. $result.':'.'AN'. $result)->getAlignment()->setWrapText(true);
        $result++;
        $print_text_sum = \App\Services\UtilityHelper\UtilityHelper::mb_ucfirst(\App\Services\UtilityHelper\UtilityHelper::num2str($check['totalResult']))." в т. ч. НДС 20% - ". $check['totalSumNds']."  руб";
        $spreadsheet->getActiveSheet()->mergeCells('A'.$result.':AN'.$result);
        $spreadsheet->getActiveSheet()->setCellValue("A" . $result, $print_text_sum);
        $spreadsheet->getActiveSheet()->getRowDimension($result)->setRowHeight(28);
        $spreadsheet->getActiveSheet()->getStyle('A'. $result)->getAlignment()->setWrapText(true);

        $result = $result+3;
        $spreadsheet->getActiveSheet()->mergeCells('D'.$result.':N'.$result);
        $spreadsheet->getActiveSheet()->setCellValue("D" . $result, 'Генеральный директор');
        $spreadsheet->getActiveSheet()->getStyle('D'.$result)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('D'.$result)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->mergeCells('Z'.$result.':AK'.$result);
        $spreadsheet->getActiveSheet()->setCellValue("Z" . $result, env('DIRECTOR_ABBR'));
        $spreadsheet->getActiveSheet()->getStyle('Z'.$result)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('Z'.$result)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $styleSub = [
            'borders' => [
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FFFF'],
                ],
            ],
        ];
        $spreadsheet->getActiveSheet()->getStyle('O'.$result.':Y'.$result)->applyFromArray($styleSub);

        $result = $result+3;
        $spreadsheet->getActiveSheet()->mergeCells('D'.$result.':N'.$result);
        $spreadsheet->getActiveSheet()->setCellValue("D" . $result, 'Бухгалтер');
        $spreadsheet->getActiveSheet()->getStyle('D'.$result)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('D'.$result)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->mergeCells('Z'.$result.':AK'.$result);
        $spreadsheet->getActiveSheet()->setCellValue("Z" . $result, env('ACCOUTANT_ABBR'));
        $spreadsheet->getActiveSheet()->getStyle('Z'.$result)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('Z'.$result)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $spreadsheet->getActiveSheet()->getStyle('O'.$result.':Y'.$result)->applyFromArray($styleSub);

        $result = $result+2;
        $spreadsheet->getActiveSheet()->mergeCells('A'.$result.':AN'.$result+22);


        $spreadsheet->getActiveSheet()->setCellValue("A" . $result, htmlspecialchars_decode($check['text']));
        $spreadsheet->getActiveSheet()->getStyle('A'.$result)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $spreadsheet->getActiveSheet()->getStyle('A'.$result)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
        $spreadsheet->getActiveSheet()->getStyle('A'. $result)->getAlignment()->setWrapText(true);
        $spreadsheet->getActiveSheet()->getStyle('A'. $result)->getFont()->setSize(8);

        // Устанавливаем масштабирование при печати
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(0);

        // Вызываем метод, который перестраивает содержимое так, чтобы оно влезало на страницу
        $spreadsheet->getSheet(0)->setSelectedCell('A1');

        /* -------------- Скачивание файла ------------ */
        // Форматируем имя файла
        $filePath = preg_replace('/[\/:*?"<>|]/', '_', 'Счет № ' . $check['number_check'] . ' от ' . $check['date_check'] . '.xlsx');

// Временный файл для записи
        $tempFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filePath;

// Создание объекта Xlsx для записи
        $writer = new Xlsx($spreadsheet);
// Сохранение в временный файл
        $writer->save($tempFilePath);

// Копирование временного файла в хранилище
        Storage::disk('public')->putFileAs('/fileTime', new \Illuminate\Http\File($tempFilePath), $filePath);

// Получение URL
        $url = Storage::url('fileTime/'.$filePath);

        return response()->json(['url' => $url]);
    }


    public function dataCompany(Request $request)
    {

        $validCheck = $request->validate([
            'id' => 'required|integer|min:1',
        ]);
        $email = \App\Models\Check_total::dataCompany($validCheck['id']);

        $result['email'] = $email->email_contact;
        $date = UtilityHelper::formatDate($email->date_check);
        $result['name'] = 'Счет № ' . $email->number_check . ' от ' . $date['full'] ;

        return response()->json($result);
    }

    /**
     * Отправка сообщения
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function sentEmail(Request $request)
    {
        try {
            $validEmail = $request->validate([
                'emailCompany' => 'email:rfc,dns',
                'file' => 'boolean',
                'subject' => 'required|string|min:1',
                'textEmail' => 'nullable|string|min:1|max:1000',
                'check' => 'required|integer|min:1',
            ]);

            return response()->json(\App\Models\Check_total::sentEmail($validEmail));
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 401);
        }
    }
}
