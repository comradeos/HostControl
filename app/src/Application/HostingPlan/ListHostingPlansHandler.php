<?php

declare(strict_types=1);

namespace App\Application\HostingPlan;

use App\Application\Common\PaginationResult;
use App\Application\HostingPlan\DTO\HostingPlanResponse;
use App\Domain\HostingPlan\HostingPlanRepositoryInterface;

class ListHostingPlansHandler
{
    private HostingPlanRepositoryInterface $repository;

    public function __construct(HostingPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ListHostingPlansQuery $query): PaginationResult
    {
        $limit = $query->getLimit();
        $offset = $query->getOffset();

        $items = $this->repository->findAll($limit, $offset);
        $total = $this->repository->countAll();

        $result = [];

        foreach ($items as $item) {
            $result[] = new HostingPlanResponse($item);
        }

        return new PaginationResult(
            items: $result,
            total: $total,
            limit: $limit,
            offset: $offset
        );
    }
}
