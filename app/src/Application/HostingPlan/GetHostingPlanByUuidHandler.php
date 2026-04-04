<?php

declare(strict_types=1);

namespace App\Application\HostingPlan;

use App\Application\HostingPlan\DTO\HostingPlanResponse;
use App\Domain\HostingPlan\HostingPlanRepositoryInterface;
use InvalidArgumentException;

class GetHostingPlanByUuidHandler
{
    private HostingPlanRepositoryInterface $repository;

    public function __construct(HostingPlanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $uuid): HostingPlanResponse
    {
        $plan = $this->repository->findByUuid($uuid);

        if ($plan === null) {
            throw new InvalidArgumentException('Hosting plan not found');
        }

        return new HostingPlanResponse($plan);
    }
}
