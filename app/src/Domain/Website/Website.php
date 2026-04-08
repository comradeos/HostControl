<?php

declare(strict_types=1);

namespace App\Domain\Website;

use DateTimeImmutable;

class Website
{
    private string $uuid;

    private string $domainUuid;

    private string $rootPath;

    private string $phpVersion;

    private int $diskLimitMb;

    private int $cpuLimit;

    private DateTimeImmutable $createdAt;

    public function __construct(
        string $uuid,
        string $domainUuid,
        string $rootPath,
        string $phpVersion,
        int $diskLimitMb,
        int $cpuLimit,
        DateTimeImmutable $createdAt
    ) {
        $this->uuid = $uuid;
        $this->domainUuid = $domainUuid;
        $this->rootPath = $rootPath;
        $this->phpVersion = $phpVersion;
        $this->diskLimitMb = $diskLimitMb;
        $this->cpuLimit = $cpuLimit;
        $this->createdAt = $createdAt;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getDomainUuid(): string
    {
        return $this->domainUuid;
    }

    public function getRootPath(): string
    {
        return $this->rootPath;
    }

    public function getPhpVersion(): string
    {
        return $this->phpVersion;
    }

    public function getDiskLimitMb(): int
    {
        return $this->diskLimitMb;
    }

    public function getCpuLimit(): int
    {
        return $this->cpuLimit;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
