<?php

declare(strict_types=1);

namespace App\Application\Website;

use Symfony\Component\Validator\Constraints as Assert;

class CreateWebsiteCommand
{
    #[Assert\NotBlank]
    private string $domainUuid;

    #[Assert\NotBlank]
    private string $rootPath;

    #[Assert\NotBlank]
    private string $phpVersion;

    #[Assert\Positive]
    private int $diskLimitMb;

    #[Assert\Positive]
    private int $cpuLimit;

    public function __construct(
        string $domainUuid,
        string $rootPath,
        string $phpVersion,
        int $diskLimitMb,
        int $cpuLimit
    ) {
        $this->domainUuid = $domainUuid;
        $this->rootPath = $rootPath;
        $this->phpVersion = $phpVersion;
        $this->diskLimitMb = $diskLimitMb;
        $this->cpuLimit = $cpuLimit;
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
}
