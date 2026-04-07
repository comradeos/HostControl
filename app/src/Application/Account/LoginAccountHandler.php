<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Application\Common\ValidationException;
use App\Application\Common\ValidationHelper;
use App\Domain\Account\AccountRepositoryInterface;
use App\Infrastructure\Security\JwtService;
use InvalidArgumentException;
use Predis\Client as RedisClient;
use Random\RandomException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoginAccountHandler
{
    private AccountRepositoryInterface $repository;

    private ValidatorInterface $validator;

    private JwtService $jwtService;

    private RedisClient $redis;

    public function __construct(
        AccountRepositoryInterface $repository,
        ValidatorInterface $validator,
        JwtService $jwtService,
        RedisClient $redis
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->jwtService = $jwtService;
        $this->redis = $redis;
    }

    /**
     * @throws ValidationException
     * @throws RandomException
     */
    public function handle(LoginAccountCommand $command): string
    {
        ValidationHelper::validate($command, $this->validator);

        $email = $command->getEmail();
        $password = $command->getPassword();

        $account = $this->repository->findByEmail($email);

        if ($account === null) {
            throw new InvalidArgumentException('Invalid credentials');
        }

        $isValid = password_verify($password, $account->getPassword());

        if ($isValid === false) {
            throw new InvalidArgumentException('Invalid credentials');
        }

        $sessionId = bin2hex(random_bytes(16));

        $this->redis->setex(
            'session:' . $sessionId,
            3600,
            $account->getUuid()
        );

        $payload = [
            'sub' => $account->getUuid(),
            'email' => $account->getEmail(),
            'role' => $account->getRole()->value,
            'sid' => $sessionId,
            'iat' => time(),
            'exp' => time() + 3600,
        ];

        $token = $this->jwtService->encode($payload);

        return $token;
    }
}
