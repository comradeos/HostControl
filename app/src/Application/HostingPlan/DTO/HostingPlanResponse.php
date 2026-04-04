<?php

declare(strict_types=1);

namespace App\Application\HostingPlan\DTO;

use App\Domain\HostingPlan\HostingPlan;

class HostingPlanResponse
{
    public string $uuid;

    public string $name;

    public int $diskSpaceMb;

    public int $bandwidthMb;

    public float $price;

    public string $createdAt;

    public function __construct(HostingPlan $plan)
    {
        $this->uuid = $plan->getUuid();
        $this->name = $plan->getName();
        $this->diskSpaceMb = $plan->getDiskSpaceMb();
        $this->bandwidthMb = $plan->getBandwidthMb();
        $this->price = $plan->getPrice();
        $this->createdAt = $plan->getCreatedAt()->format('Y-m-d H:i:s');
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'disk_space_mb' => $this->diskSpaceMb,
            'bandwidth_mb' => $this->bandwidthMb,
            'price' => $this->price,
            'created_at' => $this->createdAt,
        ];
    }
}
