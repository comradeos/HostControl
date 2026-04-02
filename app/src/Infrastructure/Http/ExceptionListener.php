<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof InvalidArgumentException) {
            $response = new JsonResponse([
                'result' => false,
                'error' => $exception->getMessage(),
            ], 400);

            $event->setResponse($response);

            return;
        }

        $response = new JsonResponse([
            'result' => false,
            'error' => 'Internal Server Error',
        ], 500);

        $event->setResponse($response);
    }
}
