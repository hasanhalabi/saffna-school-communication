<?php

namespace App\Http\Middleware;

use App\Http\Responses\SaffnaJsonResponse;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaffnaRequirePasswordChange
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (
            $user instanceof User
            && $user->must_change_password
            && ! $request->routeIs('api.v1.me', 'api.v1.account.password.update')
        ) {
            return SaffnaJsonResponse::error(
                code: 'password_change_required',
                messageKey: 'saffna.auth.password_change_required',
                status: 409,
                request: $request,
            );
        }

        return $next($request);
    }
}
