<?php

declare(strict_types=1);

namespace App\Controller\Website;

use App\Application\Website\DeleteWebsiteHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DeleteWebsiteController
{
    private DeleteWebsiteHandler $handler;

    public function __construct(DeleteWebsiteHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/websites/{uuid}', methods: ['DELETE'])]
    public function __invoke(string $uuid): JsonResponse
    {
        $this->handler->handle($uuid);

        return ApiResponse::success([]);
    }
}
