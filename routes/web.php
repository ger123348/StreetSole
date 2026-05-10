<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/dashboard/{role?}', function ($role = 'pembeli') {
    // Validasi role hanya admin atau pembeli
    if (!in_array($role, ['admin', 'pembeli'])) {
        $role = 'pembeli';
    }
    
    // Tampilkan view yang berbeda berdasarkan role
    if ($role === 'admin') {
        return view('dashboard_admin', ['role' => $role]);
    }
    
    return view('dashboard', ['role' => $role]);
})->name('dashboard');

// Tambahkan route logout
Route::get('/logout', function () {
    return redirect()->route('index');
})->name('logout');