<?php

declare(strict_types=1);

namespace App\Controller\HostingPlan;

use App\Application\HostingPlan\CreateHostingPlanCommand;
use App\Application\HostingPlan\CreateHostingPlanHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CreateHostingPlanController
{
    private CreateHostingPlanHandler $handler;

    public function __construct(CreateHostingPlanHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/hosting-plans', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new CreateHostingPlanCommand(
            name: $data['name'] ?? '',
            diskSpaceMb: (int) ($data['diskSpaceMb'] ?? 0),
            bandwidthMb: (int) ($data['bandwidthMb'] ?? 0),
            price: (float) ($data['price'] ?? 0)
        );

        $plan = $this->handler->handle($command);

        return ApiResponse::success([
            'uuid' => $plan->getUuid(),
        ]);
    }
}
