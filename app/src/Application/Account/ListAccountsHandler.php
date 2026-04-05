<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Application\Account\DTO\AccountResponse;
use App\Application\Common\PaginationResult;
use App\Domain\Account\AccountRepositoryInterface;

class ListAccountsHandler
{
    private AccountRepositoryInterface $repository;

    public function __construct(AccountRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ListAccountsQuery $query): PaginationResult
    {
        $limit = $query->getLimit();
        $offset = $query->getOffset();
        $status = $query->getStatus();

        if ($status !== null) {
            $accounts = $this->repository->findByStatus($status, $limit, $offset);
            $total = $this->repository->countByStatus($status);
        } else {
            $accounts = $this->repository->findAll($limit, $offset);
            $total = $this->repository->countAll();
        }

        $items = [];

        foreach ($accounts as $account) {
            $items[] = new AccountResponse($account);
        }

        return new PaginationResult(
            items: $items,
            total: $total,
            limit: $limit,
            offset: $offset
        );
    }
}
