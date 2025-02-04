<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetByUser extends Controller
{
    /**
     * Метод получения данных о пользователе
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getUserData(): \Illuminate\Http\JsonResponse
    {
        return response()->json(Auth::user());
    }
}
