<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse
{
    public static function success(array $data): JsonResponse
    {
        return new JsonResponse([
            'result' => true,
            'data' => $data,
        ]);
    }

    public static function error(string $message, int $status = 400): JsonResponse
    {
        return new JsonResponse([
            'result' => false,
            'error' => $message,
        ], $status);
    }
}
