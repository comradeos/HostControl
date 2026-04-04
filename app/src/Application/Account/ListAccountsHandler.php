<?php

declare(strict_types=1);

namespace App\Application\Account;

use App\Application\Account\DTO\AccountResponse;
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
     *     items: array[],
     *     total: int,
     *     limit: int,
     *     offset: int
     * }
     */
    public function handle(ListAccountsQuery $query): array
    {
        $limit = $query->getLimit();
        $offset = $query->getOffset();

        $accounts = $this->repository->findAll($limit, $offset);
        $total = $this->repository->countAll();

        $items = [];

        foreach ($accounts as $account) {
            $items[] = (new AccountResponse($account))->toArray();
        }

        return [
            'items' => $items,
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset,
        ];
    }
}
