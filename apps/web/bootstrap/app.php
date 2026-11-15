<?php

use App\Http\Responses\SaffnaJsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            if (SaffnaJsonResponse::wantsJson($request)) {
                return SaffnaJsonResponse::error(
                    code: 'unauthenticated',
                    messageKey: 'saffna.auth.unauthenticated',
                    status: 401,
                    headers: ['X-CSRF-TOKEN' => csrf_token()],
                    request: $request,
                );
            }
        });

        $exceptions->render(function (AuthorizationException $exception, Request $request) {
            if (SaffnaJsonResponse::wantsJson($request)) {
                return SaffnaJsonResponse::error(
                    code: 'forbidden',
                    messageKey: 'saffna.auth.forbidden',
                    status: 403,
                    request: $request,
                );
            }
        });

        $exceptions->render(function (ValidationException $exception, Request $request) {
            if (SaffnaJsonResponse::wantsJson($request)) {
                return SaffnaJsonResponse::error(
                    code: 'validation_failed',
                    messageKey: 'saffna.validation.failed',
                    status: 422,
                    errors: $exception->errors(),
                    request: $request,
                );
            }
        });

        $exceptions->render(function (TokenMismatchException $exception, Request $request) {
            if (SaffnaJsonResponse::wantsJson($request)) {
                return SaffnaJsonResponse::error(
                    code: 'csrf_token_mismatch',
                    messageKey: 'saffna.auth.csrf_mismatch',
                    status: 419,
                    request: $request,
                );
            }
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            if (SaffnaJsonResponse::wantsJson($request)) {
                return SaffnaJsonResponse::error(
                    code: 'not_found',
                    messageKey: 'saffna.api.not_found',
                    status: 404,
                    request: $request,
                );
            }
        });

        $exceptions->render(function (Throwable $exception, Request $request) {
            if ($exception instanceof HttpResponseException || $exception instanceof HttpExceptionInterface) {
                return null;
            }

            if (SaffnaJsonResponse::wantsJson($request)) {
                return SaffnaJsonResponse::error(
                    code: 'server_error',
                    messageKey: 'saffna.api.server_error',
                    status: 500,
                    request: $request,
                );
            }
        });
    })->create();
