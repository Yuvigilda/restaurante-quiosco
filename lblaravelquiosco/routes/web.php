<?php

use Illuminate\Support\Facades\Route;

$spa = function () {
    $index = public_path('index.html');

    if (is_file($index)) {
        return response()->file($index);
    }

    return view('welcome');
};

Route::get('/', $spa);

// React Router maneja /auth y /admin. /api, /sanctum y /up siguen en Laravel.
Route::get('/{any}', $spa)->where('any', '^(?!api(?:/|$)|sanctum(?:/|$)|up(?:/|$)).*$');
