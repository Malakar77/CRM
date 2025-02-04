<?php

namespace App\Models;

use App\Services\UtilityHelper\UtilityHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\table;

class Main extends Model
{
    use HasFactory;


    /**
     * Получение активных заданий
     * @return \Illuminate\Support\Collection
     */
    public static function index(): \Illuminate\Support\Collection
    {
        return DB::table('todo_lists')
            ->leftjoin('companies', 'todo_lists.id_company', '=', 'companies.id')
            ->select(
                'companies.name',
                'companies.user_id',
                'todo_lists.id',
                'todo_lists.title',
                'todo_lists.start',
                'todo_lists.end',
                'todo_lists.allDay',
                'todo_lists.important',
            )
            ->where('todo_lists.id_user', '=', Auth::user()->id)
            ->whereNull('todo_lists.deleted_at')
            ->orderBy('todo_lists.start')
            ->get();
    }

    /**
     * Обновление активного задания
     * @param $todo
     * @return int
     */
    public static function setTodo($todo): int
    {
        return DB::table('todo_lists')
            ->where('id', $todo['id'])
            ->update([
                'title' => UtilityHelper::get_variable($todo['text']),
                'end' => UtilityHelper::get_variable($todo['time']),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }

    /**
     * Удаление активного задания
     * @param int $id
     */
    public static function deletedTodo(int $id): bool
    {
        return TodoList::findOrFail($id)->delete();
    }


    public static function addTask(object $task): int
    {
        return DB::table('todo_lists')
            ->insertGetId([
                'id_company' => $task->id_company,
                'id_user' => Auth::user()->id,
                'title' => $task->title,
                'start' => $task->start,
                'important' => $task->color,
                'end' => $task->end,
                'allDay' => $task->allDay,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
    }

    public static function getTask(int $id): object
    {
        return DB::table('todo_lists')->find($id);
    }
}
