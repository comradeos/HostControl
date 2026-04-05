<?php

declare(strict_types=1);

namespace App\Domain\Domain;

class Domain
{
    private string $uuid;

    private string $name;

    private string $accountUuid;

    private string $status;

    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $uuid,
        string $name,
        string $accountUuid,
        string $status,
        \DateTimeImmutable $createdAt
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->accountUuid = $accountUuid;
        $this->status = $status;
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

    public function getAccountUuid(): string
    {
        return $this->accountUuid;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
