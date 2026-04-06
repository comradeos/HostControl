<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Application\Common\ValidationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;
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

        if ($exception instanceof ValidationException) {
            $this->logger->warning('Validation failed', [
                'errors' => $exception->getErrors(),
            ]);

            $response = ApiResponse::errors($exception->getErrors());

            $event->setResponse($response);

            return;
        }

        if ($exception instanceof UniqueConstraintViolationException) {
            $this->logger->warning('Unique constraint violation', [
                'exception' => $exception,
            ]);

            $response = ApiResponse::error('Resource already exists', 400);

            $event->setResponse($response);

            return;
        }

        if ($exception instanceof InvalidArgumentException) {
            $this->logger->warning($exception->getMessage(), [
                'exception' => $exception,
            ]);

            $response = ApiResponse::error($exception->getMessage());

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
