<?php

namespace App\Handlers;

use Illuminate\Support\Facades\Auth;

class CustomConfigHandler
{
    /**
     * @throws \Exception
     */
    public function userField(): string
    {
        if (!auth()->check()) {
            throw new \RuntimeException('User is not authenticated.');
        }

        // Если пользователь администратор, возвращаем общую папку
        if (Auth::user()->admin === true) {
            return  'files';
        }

        return  'files/' . Auth::user()->prefix;
    }
}
