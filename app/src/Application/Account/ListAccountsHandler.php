<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Domain\Account\Account;
use App\Domain\Account\AccountRepositoryInterface;

class ListAccountsHandler
{
    private AccountRepositoryInterface $repository;

    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Account[]
     */
    public function handle(ListAccountsQuery $query): array
    {
        $limit = $query->getLimit();
        $offset = $query->getOffset();

        $accounts = $this->repository->findAll($limit, $offset);

        return $accounts;
    }
}
