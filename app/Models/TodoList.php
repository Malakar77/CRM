<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TodoList extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'todo_lists';

    protected $fillable = ['updated_at'];

    const DELETED_AT = 'deleted_at';
}
