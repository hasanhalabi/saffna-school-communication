<?php

namespace App\Http\Controllers\Api;

use App\Business\Authorization\SaffnaPermission;
use App\Business\Identity\SaffnaOwnPasswordChanger;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaffnaChangeOwnPasswordRequest;
use App\Http\Responses\SaffnaJsonResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class SaffnaOwnPasswordController extends Controller
{
    public function __invoke(
        SaffnaChangeOwnPasswordRequest $request,
        SaffnaOwnPasswordChanger $passwordChanger,
    ): JsonResponse {
        Gate::authorize(SaffnaPermission::ChangeOwnPassword->value);

        /** @var User $user */
        $user = $request->user();
        $passwordChanger->change($user, $request->newPassword());

        $request->session()->regenerate();
        $request->session()->regenerateToken();

        return SaffnaJsonResponse::success(
            data: [
                'password_changed' => true,
                'must_change_password' => false,
            ],
            headers: ['X-CSRF-TOKEN' => csrf_token()],
            request: $request,
        );
    }
}
