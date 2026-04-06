<?php

declare(strict_types=1);

namespace App\Controller\Domain;

use App\Application\Domain\DeleteDomainHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DeleteDomainController
{
    private DeleteDomainHandler $handler;

    public function __construct(DeleteDomainHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/domains/{uuid}', methods: ['DELETE'])]
    public function __invoke(string $uuid): JsonResponse
    {
        $this->handler->handle($uuid);

        return ApiResponse::success([]);
    }
}
