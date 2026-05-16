<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserAddressController;

Route::get('/', function () {
    return view('index');
})->name('index');

// Auth routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout', [AuthController::class, 'logout']);

// Dashboard routes (with auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/{role?}', [DashboardController::class, 'dashboard'])
        ->where('role', 'admin|pembeli')
        ->name('dashboard');
});

// Admin API routes (with auth)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::post('/product/add', [AdminController::class, 'addProduct']);
    Route::post('/product-stock/{stockId}/update', [AdminController::class, 'updateStock']);
    Route::post('/product/{id}/toggle-status', [AdminController::class, 'toggleProductStatus']);
    Route::delete('/product/{id}/delete', [AdminController::class, 'deleteProduct']);
    Route::post('/order/{orderId}/status', [AdminController::class, 'updateOrderStatus']);
    Route::post('/user/{id}/toggle-status', [AdminController::class, 'toggleUserStatus']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/reviews/store', [ReviewController::class, 'store']);
    Route::get('/reviews', [ReviewController::class, 'index']);
});

Route::middleware(['auth'])->group(function () {
    Route::post('/orders/store', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);
});

Route::middleware(['auth'])->group(function () {
    // Cart routes - /cart/clear must be before /cart/{cartId}
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/add', [CartController::class, 'store']);
    Route::delete('/cart/clear', [CartController::class, 'clear']);
    Route::put('/cart/{cartId}', [CartController::class, 'update']);
    Route::delete('/cart/{cartId}', [CartController::class, 'destroy']);
});

// User Address routes
Route::middleware(['auth'])->group(function () {
    Route::get('/addresses', [UserAddressController::class, 'index']);
    Route::post('/addresses', [UserAddressController::class, 'store']);
    Route::delete('/addresses/{id}', [UserAddressController::class, 'destroy']);
    Route::post('/addresses/{id}/default', [UserAddressController::class, 'setDefault']);
});