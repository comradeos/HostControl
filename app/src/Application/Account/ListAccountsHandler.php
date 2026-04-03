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
     * @return array{
     *     items: Account[],
     *     total: int,
     *     limit: int,
     *     offset: int
     * }
     */
    public function handle(ListAccountsQuery $query): array
    {
        $limit = $query->getLimit();
        $offset = $query->getOffset();

        $items = $this->repository->findAll($limit, $offset);
        $total = $this->repository->countAll();

        return [
            'items' => $items,
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset,
        ];
    }
}
