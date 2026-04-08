<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Infrastructure\Http\ApiResponse;
use InvalidArgumentException;
use Predis\Client as RedisClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogoutAccountController
{
    private RedisClient $redis;

    public function __construct(RedisClient $redis)
    {
        $this->redis = $redis;
    }

    #[Route('/api/auth/logout', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $user = $request->attributes->get('user');

        if (is_array($user) === false) {
            throw new InvalidArgumentException('Unauthorized');
        }

        if (isset($user['sid']) === false) {
            throw new InvalidArgumentException('Invalid session');
        }

        $sessionId = $user['sid'];

        $this->redis->del(['session:' . $sessionId]);

        return ApiResponse::success([
            'message' => 'Logged out',
        ]);
    }
}
