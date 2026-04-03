<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'hosting_plans')]
class HostingPlanEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $uuid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(name: 'disk_space_mb', type: 'integer')]
    private int $diskSpaceMb;

    #[ORM\Column(name: 'bandwidth_mb', type: 'integer')]
    private int $bandwidthMb;

    #[ORM\Column(type: 'float')]
    private float $price;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDiskSpaceMb(int $diskSpaceMb): void
    {
        $this->diskSpaceMb = $diskSpaceMb;
    }

    public function setBandwidthMb(int $bandwidthMb): void
    {
        $this->bandwidthMb = $bandwidthMb;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
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
