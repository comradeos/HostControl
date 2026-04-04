<?php

declare(strict_types=1);

namespace App\Application\HostingPlan;

use App\Domain\HostingPlan\HostingPlanRepositoryInterface;
use InvalidArgumentException;

class DeleteHostingPlanHandler
{
    private HostingPlanRepositoryInterface $repository;

    public function __construct(HostingPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $uuid): void
    {
        $plan = $this->repository->findByUuid($uuid);

        if ($plan === null) {
            throw new InvalidArgumentException('Hosting plan not found');
        }

        $this->repository->delete($plan);
    }
}
