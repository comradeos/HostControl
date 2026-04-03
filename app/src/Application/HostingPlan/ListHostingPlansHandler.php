<?php

declare(strict_types=1);

namespace App\Application\HostingPlan;

use App\Domain\HostingPlan\HostingPlanRepositoryInterface;

class ListHostingPlansHandler
{
    private HostingPlanRepositoryInterface $repository;

    public function __construct(HostingPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ListHostingPlansQuery $query): array
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
