<?php

namespace App\Models;

use App\Mail\SendEmail;
use App\Services\UtilityHelper\UtilityHelper;
use Carbon\Carbon;
use Dompdf\Dompdf;
use FontLib\TrueType\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\NoReturn;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Webklex\PHPIMAP\ClientManager;
use Swift_Message;
use Swift_Attachment;

class Check_total extends Model
{
    use HasFactory;

    /**
     * Заголовки счета
     * @param int $id
     * @return object|null
     */
    public static function headers(int $id): ?object
    {
        return DB::table('check_sale')
            ->join('companies', 'companies.id', '=', 'check_sale.id_client')
            ->join('company', 'company.id', '=', 'check_sale.id_company')
            ->join('info_companies', 'info_companies.id_company', '=', 'companies.id')
            ->select(
                'check_sale.number_check',
                'check_sale.date_check',
                'check_sale.comment',
                'companies.name',
                'companies.inn',
                'companies.address',
                'company.company_name',
                'company.inn_company',
                'company.kpp_company',
                'company.ur_address_company',
                'company.bank',
                'company.bik_bank_company',
                'company.kor_chet',
                'company.ras_chet'
            )
            ->where('check_sale.id', '=', $id)
            ->first();
    }

    /**
     * Вывод всех позиций счета
     * @param int $id
     * @return object|null
     */
    public static function position(int $id): object|null
    {
        return DB::table('check_position')
            ->where('check_position.id_check', '=', $id)
            ->Where('check_position.status', '!=', ['old', 'trash'])
            ->get();
    }

    /**
     * Вывод примечания
     * @param int $id
     * @return object|null
     */
    public static function comment(int $id): object|null
    {
        $comment = DB::table('table_comment_type')
            ->select('text')
            ->where('table_comment_type.id_check', '=', $id)
            ->where('table_comment_type.type', '=', 'comment')
            ->where('table_comment_type.status', '!=', ['old', 'trash'])
            ->get();

        // Если нет записей, вернуть запись с id = 1
        if ($comment->isEmpty()) {
            $comment = DB::table('table_comment_type')
                ->select('text')
                ->where('table_comment_type.id', '=', 1)
                ->get(); // Получаем одну запись с id = 1
        }

        return $comment;
    }

    /**
     * Установка Примечания
     * @param int $id
     * @param string $comment
     * @return bool
     */
    public static function setComment(int $id, string $comment): bool
    {

        // Получаем запись по id
        $existingComment = DB::table('table_comment_type')
            ->where('id_check', $id)
            ->where('type', 'comment')
            ->where('status', '!=', ['old', 'trash'])
            ->first();

        if ($existingComment) {
            DB::table('table_comment_type')
                ->where('id_check', $id)
                ->where('type', 'comment')
                ->update([
                    'status' => 'old',
                    'updated_at' => \Carbon\Carbon::now()
                ]);
        }

        DB::table('table_comment_type')
            ->insert([
                'id_check' => $id,
                'type' => 'comment',
                'text' => $comment,
                'status' => 'new',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);

        return true;
    }

    /**
     * Данные о счета
     * @param $id
     * @return array
     */
    public static function check($id)
    {
        $headers = \App\Models\Check_total::headers((int)$id);

        $headers = array_map('htmlspecialchars_decode', (array)$headers);

        $date = UtilityHelper::formatDate($headers['date_check']);
        $headers['date_check'] = $date['full'];

        $position_bd = \App\Models\Check_total::position((int)$id)->toArray();

        $position = [];

        $nds = [
            'decrease' => 20,
            'increase' => 20,
            'no' => 0,
        ];

        $totalSumNds = 0; // Сумма всех sum_nds, где nds не равен 0
        $totalResult = 0; // Сумма всех result

        for ($i = 0, $iMax = count($position_bd); $i < $iMax; $i++) {
            $position[$i] = []; // Инициализируем как массив
            $position[$i]['i'] = $i + 1; // Устанавливаем порядковый номер
            $position[$i]['name'] = $position_bd[$i]->name; // Название позиции
            $position[$i]['count'] = $position_bd[$i]->count; // Количество
            $position[$i]['unit'] = $position_bd[$i]->unit; // Единицы измерения
            $position[$i]['price'] = $position_bd[$i]->price; // Цена за единицу
            $position[$i]['sum'] = $position_bd[$i]->sum; // Общая сумма

            // Получаем значение НДС
            $position[$i]['nds'] = $nds[$position_bd[$i]->nds] ?? 0;

            // Учитываем сумму НДС только если НДС не равен 0
            if ($position[$i]['nds'] !== 0) {
                $totalSumNds += $position_bd[$i]->sum_nds * 1000000; // Добавляем к общей сумме sum_nds
            }

            // Всегда добавляем result
            $totalResult += $position_bd[$i]->result * 1000000; // Добавляем к общей сумме result

            $position[$i]['sum_nds'] = $position_bd[$i]->sum_nds; // Сумма НДС
            $position[$i]['result'] = $position_bd[$i]->result; // Итоговая сумма позиции
        }

        $headers['position'] = $position;
        $headers['totalSumNds'] = number_format($totalSumNds / 1000000, 2, '.', '');
        $headers['totalResult'] = number_format($totalResult / 1000000, 2, '.', '');
        $text = \App\Models\Check_total::comment((int)$id);

        $headers['text'] = htmlspecialchars_decode(trim($text[0]->text));
        return $headers;
    }


    /**
     * Заполнение модельного окна для сообщения
     * @param $id
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public static function dataCompany($id)
    {
        $Check = UtilityHelper::get_variable($id);

        $id_client = DB::table('check_sale')
            ->select('id_client')
            ->where('id', '=', $Check)
            ->first();

        return DB::table('check_sale')
            ->join('info_companies', 'info_companies.id_company', '=', 'check_sale.id_client')
            ->select('info_companies.email_contact', 'check_sale.number_check', 'check_sale.date_check')
            ->where('check_sale.id_client', '=', $id_client->id_client)
            ->where('info_companies.status', '=', 'add')
            ->first();
    }

    /**
     * Отправка счета
     * @param $email
     * @return bool|string
     */
    public static function sentFolder($email)
    {
        // Сохраняем детали письма в базу данных
        SentEmail::create([
            'to' => $email['emailCompany'],
            'bcc' => Auth::user()->login,
            'subject' => $email['subject'],
            'body' => $email['textEmail'],
            'attachment' => $email['file'] ? json_encode($email['check']) : null,
            'user_id' => Auth::id(),
        ]);

        // Инициализация IMAP-клиента
        $cm = new ClientManager();
        $client = $cm->make([
            'host' => env('IMAP_HOST'),
            'port' => env('IMAP_PORT'),
            'encryption' => env('IMAP_ENCRYPTION'),
            'validate_cert' => false,
            'username' => Auth::user()->login,
            'password' => Auth::user()->pass_email,
            'protocol' => 'imap'
        ]);

        // Подключение к IMAP-серверу
        $client->connect();


        if (!$client->getFolder('CRM')) {
            $client->createFolder('CRM');
            $client->disconnect();
            $client->connect();
        }

        // Получаем папку "CRM" заново (в случае, если она была только что создана)
        $sentFolder = $client->getFolder('CRM');

        // Убедимся, что папка выбрана
        $sentFolder->select();

        // Создаем новое сообщение с помощью Swift Mailer
        $swiftMessage = new Swift_Message();
        $swiftMessage->setFrom([Auth::user()->login => Auth::user()->name]);
        $swiftMessage->setTo([$email['emailCompany']]);
        $swiftMessage->setSubject($email['subject']);
        $swiftMessage->setBody(nl2br($email['textEmail']) . "<br><br>" . nl2br(Auth::user()->signature), 'text/html');

        // Прикрепляем файл, если он существует
        if ($email['file'] && isset($email['check'])) {
            $fileCheck = UtilityHelper::getFilePDF($email['check']);
            $filePath = preg_replace('/[\/:*?"<>|]/', '_', $fileCheck['name'] . '.pdf');

            if (Storage::exists($filePath)) {
                $attachment = Swift_Attachment::fromPath(Storage::path($filePath));
                $swiftMessage->attach($attachment);
            }
        }

        // Преобразуем Swift-сообщение в MIME-сообщение
        $mimeMessage = $swiftMessage->toString();

        // Добавляем сообщение в папку "CRM"
        $sentFolder->appendMessage($mimeMessage);
    }

}
