<?php

use App\Http\Controllers\Auth\CustomLogoutController;
use App\Http\Controllers\Auth\CustomPasswordController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomLoginController;



Route::get('/login', [CustomLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomLoginController::class, 'login']);
Route::get('/register', [CustomLoginController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CustomLoginController::class, 'register']);
Route::post('/logout', [CustomLogoutController::class, 'logout'])->name('logout');
Route::get('forgot-password', [CustomPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('forgot-password', [CustomPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('reset-password', [CustomPasswordController::class, 'showResetPasswordForm'])->name('verifyOtpForm');
Route::get('verify-otp', [CustomPasswordController::class, 'showOtpForm'])->name('verifyOtpForm');
Route::post('verify-otp', [CustomPasswordController::class, 'verifyOtp'])->name('verifyOtp');

Route::get('reset-password', [CustomPasswordController::class, 'showResetPasswordForm'])->name('resetPasswordForm');
Route::post('reset-password', [CustomPasswordController::class, 'resetPassword'])->name('resetPassword');
