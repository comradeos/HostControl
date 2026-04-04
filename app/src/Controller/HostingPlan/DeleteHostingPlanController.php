<?php

declare(strict_types=1);

namespace App\Controller\HostingPlan;

use App\Application\HostingPlan\DeleteHostingPlanHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DeleteHostingPlanController
{
    private DeleteHostingPlanHandler $handler;

    public function __construct(DeleteHostingPlanHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/hosting-plans/{uuid}', methods: ['DELETE'])]
    public function __invoke(string $uuid): JsonResponse
    {
        $this->handler->handle($uuid);

        return ApiResponse::success([]);
    }
}
