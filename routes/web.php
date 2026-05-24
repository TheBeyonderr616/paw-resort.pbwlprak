<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

// ── Public ────────────────────────────────────────────────
Route::get('/', fn() => view('pages.welcome'))->name('home');
Route::get('/pawckage', fn() => view('pages.pawckage'))->name('pawckage');

// ── Auth ──────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login',   [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register',[RegisteredUserController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')->name('logout');

// ── Profile ───────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile',   [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── User Area ─────────────────────────────────────────────
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard',     [UserController::class, 'dashboard'])->name('dashboard');

    // Booking
    Route::get('/booking',       [UserController::class, 'booking'])->name('booking');
    Route::post('/booking',      [UserController::class, 'storeBooking'])->name('booking.store');
    Route::patch('/booking/{id}/cancel', [UserController::class, 'cancelBooking'])->name('booking.cancel');

    // Payment
    Route::get('/my-payments',   [UserController::class, 'payment'])->name('payment');

    // Pet CRUD
    Route::get('/register-pet',          [UserController::class, 'registerPetForm'])->name('register-pet');
    Route::post('/register-pet',         [UserController::class, 'registerPetStore'])->name('register-pet.store');
    Route::get('/pet/{id}/edit',         [UserController::class, 'editPet'])->name('pet.edit');
    Route::put('/pet/{id}',              [UserController::class, 'updatePet'])->name('pet.update');
    Route::delete('/pet/{id}',           [UserController::class, 'destroyPet'])->name('pet.destroy');
});

// ── Admin Area ────────────────────────────────────────────
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',  [AdminController::class, 'dashboard'])->name('dashboard');

    // Cage (read-only monitor)
    Route::get('/cage',       [AdminController::class, 'cage'])->name('cage');

    // Payment CRUD
    Route::get('/payment',    [AdminController::class, 'payment'])->name('payment');
    Route::patch('/payment/{id}/confirm', [AdminController::class, 'confirmPayment'])->name('payment.confirm');
    Route::patch('/payment/{id}/decline', [AdminController::class, 'declinePayment'])->name('payment.decline');
    Route::delete('/booking/{id}',        [AdminController::class, 'destroyBooking'])->name('booking.destroy');
});