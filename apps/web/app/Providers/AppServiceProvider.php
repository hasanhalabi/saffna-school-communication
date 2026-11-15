<?php

namespace App\Providers;

use App\Business\Audit\SaffnaAuditRecorder;
use App\Business\Authorization\SaffnaPermission;
use App\Business\Authorization\SaffnaPermissionMatrix;
use App\Http\Responses\SaffnaJsonResponse;
use App\Models\User;
use App\Policies\SaffnaUserPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('saffna-login', function (Request $request): Limit {
            $email = Str::lower(trim((string) $request->input('email')));
            $key = Str::transliterate($email).'|'.$request->ip();

            return Limit::perMinute(5)
                ->by($key)
                ->response(fn (Request $request, array $headers) => SaffnaJsonResponse::error(
                    code: 'login_throttled',
                    messageKey: 'saffna.auth.throttled',
                    status: 429,
                    headers: $headers,
                    request: $request,
                ));
        });

        Gate::policy(User::class, SaffnaUserPolicy::class);

        Gate::define(SaffnaPermission::ChangeOwnPassword->value, fn (User $user): bool => app(SaffnaPermissionMatrix::class)
            ->allows($user, SaffnaPermission::ChangeOwnPassword));
        Gate::define(SaffnaPermission::ChangeOwnLanguage->value, fn (User $user): bool => app(SaffnaPermissionMatrix::class)
            ->allows($user, SaffnaPermission::ChangeOwnLanguage));

        Gate::after(function (User $user, string $ability, ?bool $result, array $arguments): void {
            if ($result === false) {
                app(SaffnaAuditRecorder::class)->authorizationDenied($user, $ability, $arguments);
            }
        });
    }
}
