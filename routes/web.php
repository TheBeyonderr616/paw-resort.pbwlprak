<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// ── Public ────────────────────────────────────────────────────────────────────

Route::get('/', function () {
    return view('pages.welcome');
})->name('home');

Route::get('/pawckage', function () {
    return view('pages.pawckage');
})->name('pawckage');

// ── Auth ──────────────────────────────────────────────────────────────────────

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])   ->name('login');
    Route::post('/login',   [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── User (authenticated, role: user) ─────────────────────────────────────────

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard',        [UserController::class, 'dashboard'])   ->name('user.dashboard');
    Route::get('/booking',          [UserController::class, 'booking'])     ->name('user.booking');
    Route::post('/booking',         [UserController::class, 'storeBooking'])->name('user.booking.store');
    Route::get('/my-payments',      [UserController::class, 'payment'])     ->name('user.payment');
    Route::get('/register-pet',     [UserController::class, 'registerPetForm'])->name('user.register-pet');
    Route::post('/register-pet',    [UserController::class, 'registerPetStore']);

});

// ── Admin (authenticated, role: admin) ────────────────────────────────────────

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard',                    [AdminController::class, 'dashboard'])     ->name('dashboard');
    Route::get('/cage',                         [AdminController::class, 'cage'])          ->name('cage');
    Route::post('/cage',                        [AdminController::class, 'saveCage'])      ->name('cage.save');
    Route::get('/payment',                      [AdminController::class, 'payment'])       ->name('payment');
    Route::patch('/payment/{id}/confirm',       [AdminController::class, 'confirmPayment'])->name('payment.confirm');
    Route::patch('/payment/{id}/decline',       [AdminController::class, 'declinePayment'])->name('payment.decline');

});
