<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Application\Account\UpdateAccountStatusCommand;
use App\Application\Account\UpdateAccountStatusHandler;
use App\Application\Common\ValidationException;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UpdateAccountStatusController
{
    private UpdateAccountStatusHandler $handler;

    public function __construct(UpdateAccountStatusHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @throws ValidationException
     */
    #[Route('/api/accounts/{uuid}/status', methods: ['PATCH'])]
    public function __invoke(string $uuid, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $status = $data['status'] ?? '';

        $command = new UpdateAccountStatusCommand(
            uuid: $uuid,
            status: $status
        );

        $this->handler->handle($command);

        return ApiResponse::success([]);
    }
}
