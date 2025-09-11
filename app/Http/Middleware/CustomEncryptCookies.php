<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies;

class CustomEncryptCookies extends EncryptCookies
{
    protected $except = [
        'access_token',
        'refresh_token',
    ];
}
