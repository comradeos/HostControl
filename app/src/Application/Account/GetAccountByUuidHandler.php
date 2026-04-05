<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Application\Account\DTO\AccountResponse;
use App\Domain\Account\AccountRepositoryInterface;
use InvalidArgumentException;

class GetAccountByUuidHandler
{
    private AccountRepositoryInterface $repository;

    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $uuid): AccountResponse
    {
        $account = $this->repository->findByUuid($uuid);

        if ($account === null) {
            throw new InvalidArgumentException('Account not found');
        }

        return new AccountResponse($account);
    }
}
