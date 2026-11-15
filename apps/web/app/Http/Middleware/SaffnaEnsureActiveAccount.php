<?php

namespace App\Http\Middleware;

use App\Http\Responses\SaffnaJsonResponse;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SaffnaEnsureActiveAccount
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user instanceof User && ! $user->isActive()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return SaffnaJsonResponse::error(
                code: 'unauthenticated',
                messageKey: 'saffna.auth.unauthenticated',
                status: 401,
                headers: ['X-CSRF-TOKEN' => csrf_token()],
                request: $request,
            );
        }

        return $next($request);
    }
}
