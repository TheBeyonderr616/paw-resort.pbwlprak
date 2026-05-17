<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.welcome');
})->name('home');

Route::get('/pawckage', function () {
    return view('pages.pawckage');
})->name('pawckage');

/*
|--------------------------------------------------------------------------
| AUTH (Laravel Breeze)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| USER AREA (FINAL FIX CAGE BOOKING)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [UserController::class, 'dashboard'])
            ->name('dashboard');

        // BOOKING SYSTEM (USER PILIH CAGE)
        Route::get('/booking', [UserController::class, 'booking'])
            ->name('booking');

        Route::post('/booking', [UserController::class, 'storeBooking'])
            ->name('booking.store');

        Route::get('/my-payments', [UserController::class, 'payment'])
            ->name('payment');

        // PET
        Route::get('/register-pet', [UserController::class, 'registerPetForm'])
            ->name('register-pet');

        Route::post('/register-pet', [UserController::class, 'registerPetStore'])
            ->name('register-pet.store');
    });

/*
|--------------------------------------------------------------------------
| ADMIN AREA (CAGE MANAGEMENT)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/cage', [AdminController::class, 'cage'])
            ->name('cage');

        Route::post('/cage', [AdminController::class, 'saveCage'])
            ->name('cage.save');

        // LOCK / UNLOCK CAGE SYSTEM
        Route::patch('/cage/{id}/toggle', [AdminController::class, 'toggleCage'])
            ->name('cage.toggle');

        Route::get('/payment', [AdminController::class, 'payment'])
            ->name('payment');

        Route::patch('/payment/{id}/confirm', [AdminController::class, 'confirmPayment'])
            ->name('payment.confirm');

        Route::patch('/payment/{id}/decline', [AdminController::class, 'declinePayment'])
            ->name('payment.decline');
    });