<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data, array $meta = []): JsonResponse
    {
        if (is_array($data)) {
            $normalized = [];

            foreach ($data as $item) {
                if (is_object($item) && method_exists($item, 'toArray')) {
                    $normalized[] = $item->toArray();
                } else {
                    $normalized[] = $item;
                }
            }
        } elseif (is_object($data) && method_exists($data, 'toArray')) {
            $normalized = $data->toArray();
        } else {
            $normalized = $data;
        }

        $response = [
            'result' => true,
            'data' => $normalized,
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
