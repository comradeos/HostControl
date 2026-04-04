<?php

declare(strict_types=1);

namespace App\Controller\HostingPlan;

use App\Application\Common\ValidationException;
use App\Application\HostingPlan\UpdateHostingPlanCommand;
use App\Application\HostingPlan\UpdateHostingPlanHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UpdateHostingPlanController
{
    private UpdateHostingPlanHandler $handler;

    public function __construct(UpdateHostingPlanHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws ValidationException
     */
    #[Route('/api/hosting-plans/{uuid}', methods: ['PATCH'])]
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new UpdateHostingPlanCommand(
            uuid: $uuid,
            name: $data['name'] ?? '',
            diskSpaceMb: (int) ($data['diskSpaceMb'] ?? 0),
            bandwidthMb: (int) ($data['bandwidthMb'] ?? 0),
            price: (float) ($data['price'] ?? 0)
        );

        $dto = $this->handler->handle($command);

        return ApiResponse::success($dto->toArray());
    }
}
