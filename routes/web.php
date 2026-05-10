<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('index');
})->name('logout');

Route::get('/dashboard/{role}', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role']);

