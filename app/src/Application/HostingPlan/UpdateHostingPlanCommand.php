<?php

declare(strict_types=1);

namespace App\Application\HostingPlan;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateHostingPlanCommand
{
    #[Assert\NotBlank]
    private string $uuid;

    #[Assert\NotBlank]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\Positive]
    private int $diskSpaceMb;

    #[Assert\NotBlank]
    #[Assert\Positive]
    private int $bandwidthMb;

    #[Assert\NotBlank]
    #[Assert\Positive]
    private float $price;

    public function __construct(
        string $uuid,
        string $name,
        int $diskSpaceMb,
        int $bandwidthMb,
        float $price
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->diskSpaceMb = $diskSpaceMb;
        $this->bandwidthMb = $bandwidthMb;
        $this->price = $price;
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
}
