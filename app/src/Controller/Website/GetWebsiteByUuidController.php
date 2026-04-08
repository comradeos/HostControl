<?php

declare(strict_types=1);

namespace App\Controller\Website;

use App\Application\Website\GetWebsiteByUuidHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetWebsiteByUuidController
{
    private GetWebsiteByUuidHandler $handler;

    public function __construct(GetWebsiteByUuidHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/websites/{uuid}', methods: ['GET'])]
    public function __invoke(string $uuid): JsonResponse
    {
        $dto = $this->handler->handle($uuid);

        return ApiResponse::success($dto);
    }
}
