<?php

declare(strict_types=1);

namespace App\Application\Domain\DTO;

use App\Domain\Domain\Domain;

class DomainResponse
{
    public string $uuid;

    public string $name;

    public string $accountUuid;

    public string $status;

    public string $createdAt;

    public function __construct(Domain $domain)
    {
        $this->uuid = $domain->getUuid();
        $this->name = $domain->getName();
        $this->accountUuid = $domain->getAccountUuid();
        $this->status = $domain->getStatus();
        $this->createdAt = $domain->getCreatedAt()->format('Y-m-d H:i:s');
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'account_uuid' => $this->accountUuid,
            'status' => $this->status,
            'created_at' => $this->createdAt,
        ];
    }
}
