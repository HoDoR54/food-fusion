<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Cookie\Middleware\EncryptCookies;

class CustomEncryptCookies extends EncryptCookies
{
    protected $except = [
        'access_token',
        'refresh_token',
    ];
}
