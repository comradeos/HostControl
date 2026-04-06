<?php

declare(strict_types=1);

namespace App\Controller\Domain;

use App\Application\Domain\GetDomainByUuidHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetDomainByUuidController
{
    private GetDomainByUuidHandler $handler;

    public function __construct(GetDomainByUuidHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/domains/{uuid}', methods: ['GET'])]
    public function __invoke(string $uuid): JsonResponse
    {
        $dto = $this->handler->handle($uuid);

        return ApiResponse::success($dto->toArray());
    }
}
