<?php

declare(strict_types=1);

namespace App\Domain\HostingPlan;

use DateTimeImmutable;

class HostingPlan
{
    private int $id;

    private string $uuid;

    private string $name;

    private int $diskSpaceMb;

    private int $bandwidthMb;

    private float $price;

    private DateTimeImmutable $createdAt;

    public function __construct(
        string $uuid,
        string $name,
        int $diskSpaceMb,
        int $bandwidthMb,
        float $price,
        DateTimeImmutable $createdAt
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->diskSpaceMb = $diskSpaceMb;
        $this->bandwidthMb = $bandwidthMb;
        $this->price = $price;
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDiskSpaceMb(): int
    {
        return $this->diskSpaceMb;
    }

    public function getBandwidthMb(): int
    {
        return $this->bandwidthMb;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
