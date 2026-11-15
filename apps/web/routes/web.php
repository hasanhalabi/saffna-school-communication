<?php

use App\Http\Controllers\SaffnaSessionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'saffna-auth')->name('home');
Route::view('/login', 'saffna-auth')->name('login');

Route::post('/login', [SaffnaSessionController::class, 'login'])
    ->middleware('throttle:saffna-login')
    ->name('session.login');
Route::post('/logout', [SaffnaSessionController::class, 'logout'])
    ->middleware('auth')
    ->name('session.logout');
