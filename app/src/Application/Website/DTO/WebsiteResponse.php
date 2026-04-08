<?php

declare(strict_types=1);

namespace App\Application\Website\DTO;

use App\Domain\Website\Website;

class WebsiteResponse
{
    public string $uuid;

    public string $domainUuid;

    public string $rootPath;

    public string $phpVersion;

    public int $diskLimitMb;

    public int $cpuLimit;

    public string $createdAt;

    public function __construct(Website $website)
    {
        $this->uuid = $website->getUuid();
        $this->domainUuid = $website->getDomainUuid();
        $this->rootPath = $website->getRootPath();
        $this->phpVersion = $website->getPhpVersion();
        $this->diskLimitMb = $website->getDiskLimitMb();
        $this->cpuLimit = $website->getCpuLimit();
        $this->createdAt = $website->getCreatedAt()->format('Y-m-d H:i:s');
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'domain_uuid' => $this->domainUuid,
            'root_path' => $this->rootPath,
            'php_version' => $this->phpVersion,
            'disk_limit_mb' => $this->diskLimitMb,
            'cpu_limit' => $this->cpuLimit,
            'created_at' => $this->createdAt,
        ];
    }
}
