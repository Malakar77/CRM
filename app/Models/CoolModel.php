<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class CoolModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    public static function getMassage(int $id): Collection
    {
        return DB::table('info_companies')
            ->select('info_companies.email_contact')
            ->where('id_company', $id)
            ->get();
    }


    /**
     * Поиск компаний
     * @param mixed $search
     * @return Collection
     */
    public static function getSearch(mixed $search): Collection
    {
        $search = UtilityHelper::get_variable($search); // Обработка ввода пользователя

        return DB::table('companies')
            ->leftJoin('todo_lists', function ($join) {
                $join->on('companies.id', '=', 'todo_lists.id_company')
                    ->where(function ($query) {
                        $query->where('todo_lists.status', '!=', 'deleted')
                            ->orWhereNull('todo_lists.status');
                    });
            })
            ->select('companies.id', 'companies.name', 'companies.status', DB::raw('COUNT(todo_lists.id) as todo_count'))
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('companies.name', 'ILIKE', '%' . $search . '%')
                        ->orWhere('companies.inn', 'ILIKE', '%' . $search . '%')
                        ->orWhere('companies.address', 'ILIKE', '%' . $search . '%');
                });
            })
            ->whereNotIn('companies.status', ['add', 'client', 'delete', 'trash'])
            ->where('companies.user_id', '=', Auth::id())
            ->groupBy('companies.id', 'companies.name')
            ->orderBy('todo_count', 'desc')
            ->get();
    }



    /**
     * Удаление активного задания
     * @param $id
     * @return bool
     */
    public static function deleteTodo($id): bool
    {

        DB::table('todo_lists')
            ->where('id', $id['id'])
            ->update([
                'status' => 'deleted',
                'updated_at' => \Carbon\Carbon::now()
            ]);
        self::log($id['id_company'], 'Удалено задание: '.$id['text']);
        return true;
    }

    /**
     * Метод получения всех автивных заданий
     * @param $id
     * @return Collection
     */
    public static function getTodo($id): Collection
    {
        return DB::table('todo_lists')
            ->select('id', 'id_company', 'title', 'start', 'important')
            ->where('id_company', '=', UtilityHelper::get_variable($id))
            ->whereNull('todo_lists.deleted_at')
            ->get();
    }

    /**
     * Добавление активного задания
     * @param array $list
     * @return int
     */
    public static function setTodo(array $list): int
    {
        $id =  DB::table('todo_lists')->insertGetId([
            'id_company' => UtilityHelper::get_variable($list['id']),
            'title' => UtilityHelper::get_variable($list['text']),
            'date_todo' => UtilityHelper::get_variable($list['date']),
            'status' => UtilityHelper::get_variable($list['status']),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        self::log(UtilityHelper::get_variable($list['id']), 'Добавлено задание: ' . $list['text']);
        return $id;
    }

    /**
     * Метод отправки коммерческого предложения
     * @param $email
     * @return bool|string
     *
     */
    public static function php_mailer($email): bool|string
    {
        $mail = new PHPMailer(true);
        $mail->XMailer = env('EMAIL_NAME', 'CRM');

        try {
            // Настройки сервера
            $mail->isSMTP(); // Устанавливаем использование SMTP
            $mail->Host = 'vip232.hosting.reg.ru'; // Адрес SMTP сервера
            $mail->SMTPAuth = true; // Включаем аутентификацию SMTP
            $mail->Username = $email['emailUser']; // Логин от почтового ящика
            $mail->Password = Auth::user()->pass_email; // Пароль от почтового ящика
            $mail->SMTPSecure = 'tls'; // Тип шифрования
            $mail->Port = 587; // Порт SMTP сервера

            // Настройки отправителя и получателя
            $mail->setFrom($email['emailUser'], Auth::user()->name); // Адрес и имя отправителя
            $mail->addAddress($email['email'], ''); // Адрес и имя получателя
            $mail->addBCC($email['emailUser'], 'АК Сплав');

            // Устанавливаем кодировку
            $mail->CharSet = 'UTF-8';
            // Устанавливаем тему письма и тело
            $mail->Subject = $email['subject'];

            $mail->Body = $email['body']."\n\n\n". Auth::user()->signature;

            $mail->AltBody = '';

            // Добавляем дополнительное сообщение в исходящие
            $mail->MessageDate = date('Y-m-d H:i:s'); // Добавляем дату сообщения

            if (!empty($email['file']) && file_exists($email['file'])) {
                $mail->addAttachment($email['file']);
            }

            if ($email['fileOffer'] === 'true' && file_exists(Storage::path('public/offer/Коммерческое предложение.pdf'))) {
                $mail->addAttachment(Storage::path('public/offer/Коммерческое предложение.pdf'));
            }

            if ($email['fileCard'] === 'true' && file_exists(Storage::path('public/offer/карточка предприятия.pdf'))) {
                $mail->addAttachment(Storage::path('public/offer/карточка предприятия.pdf'));
            }

            if (file_exists(Storage::path('public/icon/Logo.jpg'))) {
                $file_path = Storage::path('public/icon/Logo.jpg');
                $mail->addEmbeddedImage($file_path, 'logo_cid');
            }

            // Добавление заголовка X-Sent-Flag
            $mail->addCustomHeader('X-Sent-Flag', 'true');
            // DKIM настройки
            $mail->DKIM_domain = env('EMAIL_DKIM');
            $mail->DKIM_passphrase = '';  // Оставьте пустым, если у вашего ключа нет пароля
            $mail->DKIM_identity = $mail->From;

            if ($mail->send()) {
                self::log($email['id_company'], 'Отправлено коммерческое предложение');

                //При успешной отправке перемещаем последнее сообщение в папку sent
                $imapConnection = imap_open('{mail.hosting.reg.ru:993/imap/ssl}INBOX', $email['emailUser'], Auth::user()->pass_email);

                if ($imapConnection) {
                    $lastMessage = imap_num_msg($imapConnection);

                    imap_mail_move($imapConnection, $lastMessage, 'Sent');
                    imap_expunge($imapConnection);
                    imap_close($imapConnection);
                } else {
                    return false;
                }
            }

            return true;
        } catch (Exception $e) {
            return json_encode($mail->ErrorInfo);
        }
    }

    /**
     * Метод смены статуса компании
     * @param array $data
     * @return int
     */
    public static function editStatus(array $data): int
    {
        return DB::table("companies")
            ->where('id', UtilityHelper::get_variable($data['id']))
            ->update([
                'status' => UtilityHelper::get_variable($data['status']),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Запрос основных данных всех компаний
     * @param int $id
     * @return Collection
     */
    public static function getCompany(int $id): Collection
    {
        return DB::table('companies')
            ->select('id', 'inn', 'address', 'status')
            ->where('id', '=', UtilityHelper::get_variable($id))
            ->where('status', '!=', 'add')
            ->where('status', '!=', 'delete')
            ->where('status', '!=', 'trash')
            ->get();
    }

    /**
     * Запрос логов
     * @param int $id
     * @return Collection
     */
    public static function getLog(int $id): Collection
    {
        return DB::table('logs')
            ->select('id', 'id_company', 'info', 'date_log')
            ->where('id_company', '=', UtilityHelper::get_variable($id))
            ->where('status', '=', 'add')
            ->orderBy('date_log', 'desc')
            ->get();
    }

    /**
     * Запрос доп данных о компании
     * @param int $id
     * @return Collection
     */
    public static function getInfoCompany(int $id): Collection
    {
        return DB::table('info_companies')
            ->select('id', 'id_company', 'name_contact', 'phone_contact', 'email_contact', 'sait_company', 'info_company')
            ->where('id_company', '=', UtilityHelper::get_variable($id))
            ->get();
    }


    /**
     * Запрос данных всех компаний
     * @return Collection
     */
    public static function getCompanyAll(): Collection
    {
        return DB::table('companies')
            ->leftJoin('todo_lists', function ($join) {
                $join->on('companies.id', '=', 'todo_lists.id_company')
                    ->where(function ($query) {
                        $query->whereNull('todo_lists.deleted_at');
                    });
            })
            ->select('companies.id', 'companies.name', 'companies.status', DB::raw('COUNT(todo_lists.id) as todo_count'))
            ->whereNotIn('companies.status', ['add', 'client', 'delete', 'trash'])
            ->where('companies.user_id', '=', Auth::id())
            ->groupBy('companies.id', 'companies.name')
            ->orderBy('todo_count', 'desc')
            ->get();
    }



    /**
     * Логирование действий
     * @param int $id айди компании
     * @param string $text текст лога
     * @return bool
     */
    public static function log(int $id, string $text): bool
    {
        return DB::table('logs')->insert([
            'id_company' => UtilityHelper::get_variable($id),
            'info' => UtilityHelper::get_variable($text),
            'date_log' => \Carbon\Carbon::now(),
            'status' => 'add',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }

    /**
     * Функция записи данных о компании
     * @param array $data
     * @return int|string
     */
    public static function setInfoCompany(array $data): int|string
    {
        $idCompany = UtilityHelper::get_variable($data['id']);

        $values = [
            'name_contact' => UtilityHelper::get_variable($data['contact']),
            'phone_contact' => UtilityHelper::get_variable($data['phone']),
            'email_contact' => UtilityHelper::get_variable($data['email']),
            'sait_company' => UtilityHelper::get_variable($data['site']),
            'info_company' => UtilityHelper::get_variable($data['text']),
            'status' => 'add',
            'updated_at' => \Carbon\Carbon::now(),
        ];

        // Обновление или вставка записи
        DB::table('info_companies')->updateOrInsert(
            ['id_company' => $idCompany], // Условие поиска
            array_merge($values, ['created_at' => \Carbon\Carbon::now()]) // Значения для обновления/вставки
        );

        // Возврат ID компании
        return $idCompany;
    }
}
