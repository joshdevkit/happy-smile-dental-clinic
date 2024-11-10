<?php

use App\Http\Controllers\Auth\CustomPasswordController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomLoginController;



Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomLoginController::class, 'login']);
Route::get('/register', [CustomLoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CustomLoginController::class, 'register']);
Route::get('forgot-password', [CustomPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [CustomPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password/{token}', [CustomPasswordController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('reset-password', [CustomPasswordController::class, 'resetPassword'])->name('password.update');
