<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse
{
    public static function success(array $data, array $meta = []): JsonResponse
    {
        $response = [
            'result' => true,
            'data' => $data,
        ];

        if ($meta !== []) {
            $response['meta'] = $meta;
        }

        return new JsonResponse($response);
    }

    public static function error(string $message, int $status = 400): JsonResponse
    {
        return new JsonResponse([
            'result' => false,
            'error' => $message,
        ], $status);
    }

    public static function errors(array $errors): JsonResponse
    {
        return new JsonResponse([
            'result' => false,
            'errors' => $errors,
        ], 400);
    }
}
