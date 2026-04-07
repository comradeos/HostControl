<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Infrastructure\Http\ApiResponse;
use App\Infrastructure\Security\JwtService;
use InvalidArgumentException;
use Predis\Client as RedisClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogoutAccountController
{
    private JwtService $jwtService;

    private RedisClient $redis;

    public function __construct(JwtService $jwtService, RedisClient $redis)
    {
        $this->jwtService = $jwtService;
        $this->redis = $redis;
    }

    #[Route('/api/auth/logout', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $authHeader = $request->headers->get('Authorization');

        if ($authHeader === null) {
            throw new InvalidArgumentException('Missing Authorization header');
        }

        if (str_starts_with($authHeader, 'Bearer ') === false) {
            throw new InvalidArgumentException('Invalid Authorization header');
        }

        $token = substr($authHeader, 7);

        $payload = $this->jwtService->decode($token);

        if (isset($payload['sid']) === false) {
            throw new InvalidArgumentException('Invalid session');
        }

        $sessionId = $payload['sid'];

        $this->redis->del(['session:' . $sessionId]);

        return ApiResponse::success([
            'message' => 'Logged out',
        ]);
    }
}
