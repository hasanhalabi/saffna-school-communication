<?php

use App\Http\Controllers\Api\SaffnaCurrentUserController;
use App\Http\Middleware\SaffnaEnsureActiveAccount;
use App\Http\Responses\SaffnaJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', SaffnaEnsureActiveAccount::class])->group(function (): void {
    Route::get('/v1/me', SaffnaCurrentUserController::class)->name('api.v1.me');

    Route::any('{fallback}', fn (Request $request) => SaffnaJsonResponse::error(
        code: 'not_found',
        messageKey: 'saffna.api.not_found',
        status: 404,
        request: $request,
    ))->where('fallback', '.*');
});
