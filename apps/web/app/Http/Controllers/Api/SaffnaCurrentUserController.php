<?php

namespace App\Http\Controllers\Api;

use App\Business\Authorization\SaffnaPermissionMatrix;
use App\Http\Controllers\Controller;
use App\Http\Responses\SaffnaJsonResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaffnaCurrentUserController extends Controller
{
    public function __invoke(Request $request, SaffnaPermissionMatrix $permissions): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->loadMissing('userGroup');

        return SaffnaJsonResponse::success([
            'user' => [
                'id' => $user->getKey(),
                'name' => $user->name,
                'email' => $user->email,
                'group' => $user->groupCode()?->value,
                'status' => $user->status->value,
                'preferred_language' => $user->preferred_language,
                'must_change_password' => $user->must_change_password,
                'permissions' => $permissions->permissionValuesFor($user),
            ],
        ], request: $request);
    }
}
