<?php

namespace App\Models;

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
    public static function createNew(array $data)
    {
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
        return self::where('login', $data['login']) ->exists();
    }

    /**
     * Метод проверки компании на существование
     * @param object $data
     * @return bool
     */
    public static function checkCompanyExists(object $data): bool
    {
        return DB::table('companyCrm')
            ->where('innCompany', $data->innCompany)
            ->exists();
    }

    /**
     * Метод отправки сообщения об успешной регистрации
     * @param object $data
     * @return void
     */
    public static function sendEmail(object $data): void
    {

// Создаем новый экземпляр PHPMailer
        $mail = new PHPMailer(true);
        $mail->XMailer = env('APP_NAME');

        try {
            // Настройки сервера
            $mail->isSMTP(); // Устанавливаем использование SMTP
            $mail->Host = env('MAIL_HOST'); // Адрес SMTP сервера
            $mail->SMTPAuth = true; // Включаем аутентификацию SMTP
            $mail->Username = env('MAIL_USERNAME'); // Ваш логин от почтового ящика
            $mail->Password = env('MAIL_PASSWORD'); // Ваш пароль от почтового ящика
            $mail->SMTPSecure = 'tls'; // Устанавливаем тип шифрования
            $mail->Port = 587; // Порт SMTP сервера
            // $mail-> SMTPAutoTLS = false;
            // Настройки отправителя и получателя
            $mail->setFrom(env('MAIL_USERNAME'), env('APP_NAME')); // Адрес и имя отправителя
            $mail->addAddress($data->login, ''); // Адрес и имя получателя

            // Устанавливаем кодировку
            $mail->CharSet = 'UTF-8';
            // Устанавливаем тему письма и тело
            $mail->Subject = 'Регистрация в CRM';
            $mail->Body = '
            <h5>Здравствуйте!</h5>
            <p>Спасибо за регистрацию на нашем сайте. Ваша регистрация прошла успешно!</p>
            <p>Теперь вы можете войти в свой аккаунт, используя свои учетные данные.</p>
            <p>Ваш логин: '.$data->login.'</p>
            <p>Ваш пароль: '.$data->password.'</p>
            <br>
            <p>С уважением,<br>Команда CRM</p>
        ';

            $mail->AltBody = 'Здравствуйте! Спасибо за регистрацию';

            // Добавляем дополнительное сообщение в исходящие
            $mail->MessageDate = date('Y-m-d H:i:s'); // Добавляем дату сообщения

            // Добавление заголовка X-Sent-Flag
            $mail->addCustomHeader('X-Sent-Flag', 'true');
            // DKIM настройки
            $mail->DKIM_domain = env('APP_URL');
            $mail->DKIM_passphrase = '';  // Оставьте пустым, если у вашего ключа нет пароля
            $mail->DKIM_identity = $mail->From;

            $mail->send();


        } catch (Exception $e) {

            echo json_encode($mail->ErrorInfo);
        }
    }


}


