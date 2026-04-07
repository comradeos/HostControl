<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Application\Account\LoginAccountCommand;
use App\Application\Account\LoginAccountHandler;
use App\Infrastructure\Http\ApiResponse;
use App\Infrastructure\Http\Attribute\PublicRoute;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[PublicRoute]
class LoginAccountController
{
    private LoginAccountHandler $handler;

    public function __construct(LoginAccountHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/auth/login', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $command = new LoginAccountCommand(
            $data['email'] ?? null,
            $data['password'] ?? null
        );

        $token = $this->handler->handle($command);

        return ApiResponse::success([
            'token' => $token,
        ]);
    }
}
