<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/dashboard/{role?}', function ($role = 'pembeli') {

    if (!in_array($role, ['admin', 'pembeli'])) {
        $role = 'pembeli';
    }
    return view('dashboard', ['role' => $role]);
})->name('dashboard');