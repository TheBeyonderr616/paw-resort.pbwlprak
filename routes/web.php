<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('pages.welcome');
})->name('home');

Route::get('/pawckage', function () {
    return view('pages.pawckage');
})->name('pawckage');

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Rute Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    
    Route::get('/dashboard',    [UserController::class, 'dashboard'])   ->name('dashboard');
    Route::get('/booking',      [UserController::class, 'booking'])     ->name('booking');
    Route::post('/booking',     [UserController::class, 'storeBooking']) ->name('booking.store');
    Route::get('/my-payments',  [UserController::class, 'payment'])     ->name('payment');
    
    // Pet Registration
    Route::get('/register-pet',  [UserController::class, 'registerPetForm'])->name('register-pet');
    Route::post('/register-pet', [UserController::class, 'registerPetStore'])->name('register-pet.store');

});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard',              [AdminController::class, 'dashboard'])     ->name('dashboard');
    Route::get('/cage',                   [AdminController::class, 'cage'])          ->name('cage');
    Route::post('/cage',                  [AdminController::class, 'saveCage'])      ->name('cage.save');
    Route::get('/payment',                [AdminController::class, 'payment'])       ->name('payment');
    Route::patch('/payment/{id}/confirm', [AdminController::class, 'confirmPayment'])->name('payment.confirm');
    Route::patch('/payment/{id}/decline', [AdminController::class, 'declinePayment'])->name('payment.decline');

});