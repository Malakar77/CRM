<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserMenuModal extends Model
{
    use HasFactory;

    public static function addJsonSettings(object $data)
    {

        $prefix    = Auth ::user() -> prefix ?? '';
        $directory = public_path('json/');
        $filename  = $directory . $prefix . '.json';

        if ($prefix) {
            // Проверка существования директории и создание её, если она не существует
            if (!is_dir($directory)) {
                if (!mkdir($directory, 0777, true) && !is_dir($directory)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $directory));
                }
            }

            // Чтение существующего содержимого файла, если файл существует
            if (file_exists($filename)) {
                $jsonContent = file_get_contents($filename);
                $jsonArray   = json_decode($jsonContent, true);
                if (!is_array($jsonArray)) {
                    $jsonArray = [];
                }
            } else {
                $jsonArray = [];
                Log ::channel('errors') -> error('Ошибка чтение содержимого файла ' . $filename . ' или файл не существует', [
                    'time' => now() -> toDateTimeString() // Время ошибки
                ]);
            }

            // Проверка на существование записи с таким же title и обновление, если находит
            $updated = false;
            foreach ($jsonArray as &$item) {
                // Проверка, что элемент имеет поле 'title' и оно совпадает
                if (isset($item[ 'title' ]) && $item[ 'title' ] === $data -> title) {
                    // Обновление существующего элемента
                    $item[ 'title' ] = $data -> title;
                    $item[ 'href' ]  = $data -> href;
                    $updated         = true;
                    break;
                }
            }

// Если не найдено совпадение, добавление нового элемента
            if (!$updated) {
                // Добавляем новый объект в массив
                $jsonArray[] = [
                    'title' => $data -> title ,
                    'href' => $data -> href
                ];
            }

            // Запись данных в файл
            file_put_contents($filename, json_encode($jsonArray, JSON_PRETTY_PRINT));

            Log ::channel('errors') -> info('Data saved successfully ' . json_encode($data), [
                'time' => now() -> toDateTimeString() // Время ошибки
            ]);

            // Возвращаем успешный результат
            return [
                'message' => 'Data saved successfully.' ,
                'data' => $data
            ];
        } else {
            // Возвращаем ошибку
            Log ::channel('errors') -> error('Invalid data ' . json_encode($data), [
                'time' => now() -> toDateTimeString() // Время ошибки
            ]);
            return [
                'errors' => ['message' => 'Invalid data'] ,
                'code' => 422
            ];
        }
    }


    public static function removeJsonSettings(string $field, $value): array
    {
        $prefix    = Auth ::user() -> prefix ?? '';
        $directory = public_path('json/');
        $filename  = $directory . $prefix . '.json';

        if ($prefix) {
            // Чтение существующего содержимого файла, если файл существует
            if (file_exists($filename)) {
                $jsonContent = file_get_contents($filename);
                $jsonArray   = json_decode($jsonContent, true);

                if (is_array($jsonArray)) {
                    // Поиск и удаление элемента
                    $jsonArray = array_filter($jsonArray, function ($item) use ($field, $value) {
                        return !(isset($item[ $field ]) && $item[ $field ] == $value);
                    });

                    // Переиндексация массива
                    $jsonArray = array_values($jsonArray);

                    // Запись обновленных данных в файл
                    file_put_contents($filename, json_encode($jsonArray, JSON_PRETTY_PRINT));

                    Log ::channel('errors') -> error('Data removed successfully.' . json_encode($prefix), [
                        'time' => now() -> toDateTimeString() // Время ошибки
                    ]);
                    return ['message' => 'Data removed successfully.'];
                }
            }
            Log ::channel('errors') -> error('File not found or invalid data. ' . $prefix . '.json', [
                'time' => now() -> toDateTimeString() // Время ошибки
            ]);
            return ['message' => 'File not found or invalid data.'];
        } else {
            Log ::channel('errors') -> error('Invalid prefix ' . $prefix, [
                'time' => now() -> toDateTimeString() // Время ошибки
            ]);
            return [
                'errors' => ['message' => 'Invalid prefix ' . $prefix] ,
                'code' => 422
            ];
        }
    }

    public static function readJsonSettings(string $userPrefix)
    {
        $directory = 'json/';
        $filename  = $directory . $userPrefix . '.json';

        if ($userPrefix) {
            if (file_exists($filename)) {
                $fileContent = file_get_contents($filename);
                // Декодируем JSON в массив, если требуется работа с данными
                return json_decode($fileContent);
            } else {
                // Логируем отсутствие файла
                Log ::channel('errors') -> error('Файл не найден: ' . $filename, [
                    'time' => now() -> toDateTimeString() // Время ошибки
                ]);

                return response() -> json([
                    'errors' => ['message' => 'Файл не найден: ' . $filename] ,
                    'code' => 404
                ]);
            }
        } else {
            // Логируем недопустимый префикс
            Log ::channel('errors') -> error('Неправильный префикс: ' . $userPrefix, [
                'time' => now() -> toDateTimeString() // Время ошибки
            ]);

            return response() -> json([
                'errors' => ['message' => 'Неправильный префикс: ' . $userPrefix] ,
                'code' => 422
            ]);
        }
    }
}
