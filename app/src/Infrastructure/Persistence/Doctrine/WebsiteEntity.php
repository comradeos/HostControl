<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'websites')]
class WebsiteEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $uuid;

    #[ORM\Column(name: 'domain_uuid', type: 'string', length: 36)]
    private string $domainUuid;

    #[ORM\Column(name: 'root_path', type: 'string', length: 255)]
    private string $rootPath;

    #[ORM\Column(name: 'php_version', type: 'string', length: 10)]
    private string $phpVersion;

    #[ORM\Column(name: 'disk_limit_mb', type: 'integer')]
    private int $diskLimitMb;

    #[ORM\Column(name: 'cpu_limit', type: 'integer')]
    private int $cpuLimit;

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

    public function setDomainUuid(string $domainUuid): void
    {
        $this->domainUuid = $domainUuid;
    }

    public function setRootPath(string $rootPath): void
    {
        $this->rootPath = $rootPath;
    }

    public function setPhpVersion(string $phpVersion): void
    {
        $this->phpVersion = $phpVersion;
    }

    public function setDiskLimitMb(int $diskLimitMb): void
    {
        $this->diskLimitMb = $diskLimitMb;
    }

    public function setCpuLimit(int $cpuLimit): void
    {
        $this->cpuLimit = $cpuLimit;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
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
