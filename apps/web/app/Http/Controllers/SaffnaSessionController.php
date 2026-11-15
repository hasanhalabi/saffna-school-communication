<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaffnaLoginRequest;
use App\Http\Responses\SaffnaJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaffnaSessionController extends Controller
{
    public function login(SaffnaLoginRequest $request): JsonResponse
    {
        if ($request->user() !== null) {
            return SaffnaJsonResponse::error(
                code: 'already_authenticated',
                messageKey: 'saffna.auth.already_authenticated',
                status: 409,
                request: $request,
            );
        }

        if (! Auth::attempt($request->credentials(), $request->boolean('remember'))) {
            return SaffnaJsonResponse::error(
                code: 'invalid_credentials',
                messageKey: 'saffna.auth.invalid_credentials',
                status: 422,
                request: $request,
            );
        }

        $request->session()->regenerate();

        return SaffnaJsonResponse::success(
            data: ['authenticated' => true],
            headers: ['X-CSRF-TOKEN' => csrf_token()],
            request: $request,
        );
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return SaffnaJsonResponse::success(
            data: ['authenticated' => false],
            headers: ['X-CSRF-TOKEN' => csrf_token()],
            request: $request,
        );
    }
}
