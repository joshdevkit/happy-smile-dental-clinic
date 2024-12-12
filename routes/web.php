<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Auth\CustomLogoutController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\Client\ClientDashboardController;
use App\Http\Controllers\ClientSchedulesController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\ServicesController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});


Route::resource('appointment', GuestController::class);
Route::get('guest/verification', [GuestController::class, 'verification'])->name('verification');
Route::post('guest/verify', [GuestController::class, 'verifyOtp'])->name('guest.verifyOtp');
Route::get('guest/home', [GuestController::class, 'homepage'])->name('guest.homepage');
Route::get('guest/current-schedule', [GuestController::class, 'current_sched'])->name('guest.current');
Route::get('guest/current-users-schedules', [GuestController::class, 'current_users'])->name('guest-current-schedules');
Route::get('guest/schedule/client/{id}', [GuestController::class, 'guest_fetch'])->name('guest.fetch');
Route::get('guest/set-appointement/{id}', [GuestController::class, 'appointment'])->name('set-appointment');
Route::get('schedule', [GuestController::class, 'sched'])->name('sched-details');
Route::post('schedule', [GuestController::class, 'appointment_store'])->name('store-appointment');
Route::get('schedule/{id}', [GuestController::class, 'retrieve'])->name('retrieve');
Route::get('guest/schedule/search', [GuestController::class, 'searchAppointment'])->name('search-appointment');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/update-avatar', [ProfileController::class, 'updateAvatar'])->name('update-avatar');
    Route::post('update-password', [ProfileController::class, 'update_password'])->name('update-password');
    Route::post('/custom-logout', [CustomLogoutController::class, 'logout'])->name('custom.logout');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::controller(AdminDashboardController::class)->prefix('admin')->group(function () {

        Route::get('/dashboard', 'index')->name('admin.dashboard');
        Route::resource('admin-current-schedules', ClientSchedulesController::class);
        Route::get('admin-fetch-schedule/{id}', [ClientSchedulesController::class, 'admin_fetch'])->name('admin.fetch');
        Route::resource('schedule', SchedulesController::class);
        Route::resource('follow-ups', FollowUpController::class);
        Route::get('admin-sched-data', [SchedulesController::class, 'getScheduleData'])->name('admin-sched-data');
        Route::get('admin-fetch-user', [ClientController::class, 'user_data'])->name('fetch-user-data');
        Route::resource('services', ServicesController::class);
        Route::resource('clients', ClientController::class);
        Route::post('clients/{id}/archive', [ClientController::class, 'archive'])->name('clients.archive');
        Route::post('clients/{id}/restore', [ClientController::class, 'restore'])->name('clients.restore');
        Route::get('client/{id}/info', [ClientController::class, 'info'])->name('client-info');
        Route::get('archives', [ClientController::class, 'archive_clients'])->name('archive-client');
        Route::get('client/transaction/{id}', [ClientController::class, 'getTransaction'])->name('client.transaction');
        Route::get('schedules/fetch', [SchedulesController::class, 'fetchSchedules'])->name('admin.schedules');
        Route::get('schedules/today', [SchedulesController::class, 'today'])->name('schedule.today');
        Route::get('schedules/unattended', [SchedulesController::class, 'unattended'])->name('schedule.unattended');
        Route::get('schedules/history', [SchedulesController::class, 'history'])->name('schedule.history');
        Route::post('schedules/walkin', [ServicesController::class, 'admin_walkin'])->name('admin-walkin');
        Route::get('services', [ServicesController::class, 'fetch_service'])->name('fetch-admin-services');
        Route::get('schedule/validate/{date}', [SchedulesController::class, 'date_validation'])->name('date.validate');
        Route::get('admin-check-date', [SchedulesController::class, 'check_dates'])->name('admin.check-dates');
        Route::post('schedule/today', [SchedulesController::class, 'markNotAttended'])->name('appointments.updateStatus');

        //check start time route
        Route::get('history', [SchedulesController::class, 'check_start_time'])->name('admin.start_time_check');
        Route::post('reschedule', [SchedulesController::class, 'admin_reschedule'])->name('admin.reschedule');
        Route::post('schedule/payment', [ClientController::class, 'paid'])->name('payment');


        //chart data
        Route::get('/revenue-data', [ChartController::class, 'getRevenueData']);
        Route::get('/visitors-insight', [ChartController::class, 'getVisitorsInsightData']);
    });
});

Route::middleware(['auth', 'role:Client'])->group(function () {
    Route::controller(ClientDashboardController::class)->prefix('client')->group(function () {
        Route::get('/dashboard', 'index')->name('client.dashboard');
        Route::get('schedules/fetch', [SchedulesController::class, 'fetchSchedules'])->name('users.schedules');
        Route::get('sched-data', [SchedulesController::class, 'getScheduleData'])->name('sched-data');
        Route::get('service-data', [SchedulesController::class, 'getServiceData'])->name('service-data');
        Route::get('my-appoimtent', [ClientSchedulesController::class, 'appointments'])->name('my-appointment');
        Route::get('appoimtent-history', [ClientSchedulesController::class, 'history'])->name('appointment-history');
        Route::resource('current-schedules', ClientSchedulesController::class);

        Route::get('fetch-sched', [SchedulesController::class, 'resched'])->name('resched');
        Route::get('check-date', [SchedulesController::class, 'check_dates'])->name('check-dates');
        Route::post('reschedule', [SchedulesController::class, 'user_reschedule'])->name('reschedule');

        Route::get('follow-up', [FollowUpController::class, 'user'])->name('my-follow-ups');

        Route::post('followup/accept', [FollowUpController::class, 'accept'])->name('accept');
        Route::post('followup/reject', [FollowUpController::class, 'reject'])->name('reject');

        Route::post('schedule', [SchedulesController::class, 'status'])->name('check-status');
    });
});


require __DIR__ . '/auth.php';
