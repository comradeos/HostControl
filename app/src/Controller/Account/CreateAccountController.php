<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Application\Account\CreateAccountCommand;
use App\Application\Account\CreateAccountHandler;
use App\Infrastructure\Http\ApiResponse;
use App\Infrastructure\Http\AccountResponseMapper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class CreateAccountController
{
    private CreateAccountHandler $handler;

    public function __construct(CreateAccountHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/accounts', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $email = $data['email'] ?? null;
        $fullName = $data['full_name'] ?? null;

        $command = new CreateAccountCommand(
            email: $email,
            fullName: $fullName
        );

        $account = $this->handler->handle($command);

        $responseData = AccountResponseMapper::map($account);

        return ApiResponse::success($responseData);
    }
}
