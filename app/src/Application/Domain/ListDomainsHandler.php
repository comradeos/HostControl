<?php

declare(strict_types=1);

namespace App\Application\Domain;

use App\Application\Common\PaginationResult;
use App\Domain\Domain\DomainRepositoryInterface;
use App\Application\Domain\DTO\DomainResponse;

class ListDomainsHandler
{
    private DomainRepositoryInterface $repository;

    public function __construct(DomainRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ListDomainsQuery $query): PaginationResult
    {
        $domains = $this->repository->findAll(
            $query->getLimit(),
            $query->getOffset()
        );

        $total = $this->repository->count();

        $items = [];

        foreach ($domains as $domain) {
            $items[] = (new DomainResponse($domain))->toArray();
        }

        return new PaginationResult(
            items: $items,
            total: $total,
            limit: $query->getLimit(),
            offset: $query->getOffset()
        );
    }
}
