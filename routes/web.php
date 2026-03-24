<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CoupleInviteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');
});


Route::middleware('auth')->prefix('couple')->name('couple.')->group(function () {

    // ── Invite ──────────────────────────────────────────────────
    Route::get('/invite',          [CoupleInviteController::class, 'index'])    ->name('invite.index');
    Route::post('/invite/generate',[CoupleInviteController::class, 'generate']) ->name('invite.generate');
    Route::post('/invite/cancel/{invite}', [CoupleInviteController::class, 'cancel'])->name('invite.cancel');

    // Input kode manual
    Route::post('/invite/code',    [CoupleInviteController::class, 'inputCode'])->name('invite.code');

    // Accept via URL atau form
    Route::get('/invite/{token}',  [CoupleInviteController::class, 'showAccept'])->name('invite.accept');
    Route::post('/invite/{token}/confirm', [CoupleInviteController::class, 'accept'])->name('invite.confirm');

    // ── Setup setelah connect ────────────────────────────────────
    Route::get('/setup',           [CoupleInviteController::class, 'showSetup']) ->name('setup');
    Route::post('/setup',          [CoupleInviteController::class, 'saveSetup']) ->name('setup.save');

    // ── Disconnect ───────────────────────────────────────────────
    Route::delete('/disconnect',   [CoupleInviteController::class, 'disconnect'])->name('disconnect');
});
