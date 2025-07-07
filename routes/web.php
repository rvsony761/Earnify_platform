<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Middleware\CheckAuthenticated;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegister')->name('user.register');
    Route::post('/register_store', 'register')->name('user.register_store');
    Route::get('/login', 'showlogin')->name('user.login');
    Route::post('/login', 'login')->name('user.logincheck');
    Route::post('/logout','logout')->name('user.logout');
    Route::post('/check-referral','checkReferral')->name('check.referral');
});

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard')->middleware([CheckAuthenticated::class,AdminMiddleware::class]);
Route::get('/user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard')->middleware(CheckAuthenticated::class);



