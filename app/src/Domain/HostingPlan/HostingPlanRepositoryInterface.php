<?php

declare(strict_types=1);

namespace App\Domain\HostingPlan;

interface HostingPlanRepositoryInterface
{
    public function save(HostingPlan $plan): void;

    public function findByUuid(string $uuid): ?HostingPlan;

    public function findAll(int $limit, int $offset): array;

    public function countAll(): int;

    public function delete(HostingPlan $plan): void;
}
