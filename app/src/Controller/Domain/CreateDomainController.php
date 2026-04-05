<?php

declare(strict_types=1);

namespace App\Controller\Domain;

use App\Application\Domain\CreateDomainCommand;
use App\Application\Domain\CreateDomainHandler;
use App\Application\Common\ValidationException;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CreateDomainController
{
    private CreateDomainHandler $handler;

    public function __construct(CreateDomainHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws ValidationException
     */
    #[Route('/api/domains', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'] ?? null;
        $accountUuid = $data['account_uuid'] ?? null;

        $command = new CreateDomainCommand(
            name: $name,
            accountUuid: $accountUuid
        );

        $dto = $this->handler->handle($command);

        return ApiResponse::success($dto);
    }
}
