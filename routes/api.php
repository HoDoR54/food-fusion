<?php

use Illuminate\Support\Facades\Route;

Route::get('/auth/ping', function () {
    return response()->json(['message' => 'pong']);
});

