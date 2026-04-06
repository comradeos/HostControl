<?php

declare(strict_types=1);

namespace App\Controller\Domain;

use App\Application\Common\ValidationException;
use App\Application\Domain\UpdateDomainStatusCommand;
use App\Application\Domain\UpdateDomainStatusHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UpdateDomainStatusController
{
    private UpdateDomainStatusHandler $handler;

    public function __construct(UpdateDomainStatusHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws ValidationException
     */
    #[Route('/api/domains/{uuid}/status', methods: ['PATCH'])]
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $status = $data['status'] ?? '';

        $command = new UpdateDomainStatusCommand(
            uuid: $uuid,
            status: $status
        );

        $this->handler->handle($command);

        return ApiResponse::success([]);
    }
}
