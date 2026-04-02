<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use InvalidArgumentException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof InvalidArgumentException) {
            $this->logger->warning($exception->getMessage(), [
                'exception' => $exception,
            ]);

            $message = $exception->getMessage();
            $decoded = json_decode($message, true);

            if (is_array($decoded)) {
                $response = new JsonResponse([
                    'result' => false,
                    'errors' => $decoded,
                ], 400);

                $event->setResponse($response);

                return;
            }

            $response = ApiResponse::error($message);

            $event->setResponse($response);

            return;
        }

        $this->logger->error($exception->getMessage(), [
            'exception' => $exception,
        ]);

        $response = ApiResponse::error(
            'Internal Server Error',
            500
        );

        $event->setResponse($response);
    }
}
