<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Application\Account\GetAccountByUuidHandler;
use App\Infrastructure\Http\AccountResponseMapper;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetAccountByUuidController
{
    private GetAccountByUuidHandler $handler;

    public function __construct(GetAccountByUuidHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/accounts/{uuid}', methods: ['GET'])]
    public function __invoke(string $uuid): JsonResponse
    {
        $account = $this->handler->handle($uuid);

        $data = AccountResponseMapper::map($account);

        return ApiResponse::success($data);
    }
}
