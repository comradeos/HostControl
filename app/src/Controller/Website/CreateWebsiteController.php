<?php

declare(strict_types=1);

namespace App\Controller\Website;

use App\Application\Common\ValidationException;
use App\Application\Website\CreateWebsiteCommand;
use App\Application\Website\CreateWebsiteHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CreateWebsiteController
{
    private CreateWebsiteHandler $handler;

    public function __construct(CreateWebsiteHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws ValidationException
     */
    #[Route('/api/websites', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new CreateWebsiteCommand(
            domainUuid: $data['domain_uuid'] ?? '',
            rootPath: $data['root_path'] ?? '',
            phpVersion: $data['php_version'] ?? '',
            diskLimitMb: (int) ($data['disk_limit_mb'] ?? 0),
            cpuLimit: (int) ($data['cpu_limit'] ?? 0)
        );

        $dto = $this->handler->handle($command);

        return ApiResponse::success($dto->toArray());
    }
}
