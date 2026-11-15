<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SaffnaJsonResponse
{
    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, string>  $headers
     */
    public static function success(
        array $data = [],
        int $status = 200,
        array $headers = [],
        ?Request $request = null,
    ): JsonResponse {
        $request ??= request();

        return response()->json([
            'data' => $data,
            'request_id' => self::requestId($request),
        ], $status, $headers);
    }

    /**
     * @param  array<string, list<string>>  $errors
     * @param  array<string, string>  $headers
     */
    public static function error(
        string $code,
        string $messageKey,
        int $status,
        array $errors = [],
        array $headers = [],
        ?Request $request = null,
    ): JsonResponse {
        $request ??= request();
        self::applyLocale($request);

        return response()->json([
            'code' => $code,
            'message' => __($messageKey),
            'errors' => $errors,
            'request_id' => self::requestId($request),
        ], $status, $headers);
    }

    public static function wantsJson(Request $request): bool
    {
        return $request->is('api/*') || $request->expectsJson();
    }

    public static function applyLocale(Request $request): string
    {
        $locale = Str::startsWith(Str::lower((string) $request->header('Accept-Language')), 'en')
            ? 'en'
            : 'ar';

        app()->setLocale($locale);

        return $locale;
    }

    private static function requestId(Request $request): string
    {
        $requestId = $request->attributes->get('saffna_request_id');

        if (! is_string($requestId) || $requestId === '') {
            $requestId = (string) Str::uuid();
            $request->attributes->set('saffna_request_id', $requestId);
        }

        return $requestId;
    }
}
