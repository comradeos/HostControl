<?php

declare(strict_types=1);

namespace App\Controller\Website;

use App\Application\Common\ValidationException;
use App\Application\Website\UpdateWebsiteCommand;
use App\Application\Website\UpdateWebsiteHandler;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UpdateWebsiteController
{
    private UpdateWebsiteHandler $handler;

    public function __construct(UpdateWebsiteHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws ValidationException
     */
    #[Route('/api/websites/{uuid}', methods: ['PATCH'])]
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $command = new UpdateWebsiteCommand(
            uuid: $uuid,
            domainUuid: $data['domain_uuid'] ?? '',
            rootPath: $data['root_path'] ?? '',
            phpVersion: $data['php_version'] ?? '',
            diskLimitMb: (int) ($data['disk_limit_mb'] ?? 0),
            cpuLimit: (int) ($data['cpu_limit'] ?? 0)
        );

        $dto = $this->handler->handle($command);

        return ApiResponse::success($dto);
    }
}
