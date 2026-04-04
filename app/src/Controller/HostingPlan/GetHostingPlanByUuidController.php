<?php

declare(strict_types=1);

namespace App\Controller\HostingPlan;

use App\Application\HostingPlan\GetHostingPlanByUuidHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetHostingPlanByUuidController
{
    private GetHostingPlanByUuidHandler $handler;

    public function __construct(GetHostingPlanByUuidHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/hosting-plans/{uuid}', methods: ['GET'])]
    public function __invoke(string $uuid): JsonResponse
    {
        $plan = $this->handler->handle($uuid);

        return ApiResponse::success([
            'uuid' => $plan->getUuid(),
            'name' => $plan->getName(),
            'disk_space_mb' => $plan->getDiskSpaceMb(),
            'bandwidth_mb' => $plan->getBandwidthMb(),
            'price' => $plan->getPrice(),
            'created_at' => $plan->getCreatedAt()->format('Y-m-d H:i:s'),
        ]);
    }
}
