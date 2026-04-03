<?php

declare(strict_types=1);

namespace App\Domain\Account;

use DateTimeImmutable;

class Account
{
    private int $id;

    private string $uuid;

    private string $email;

    private string $fullName;

    private AccountStatus $status;

    private DateTimeImmutable $createdAt;

    public function __construct(
        string $uuid,
        string $email,
        string $fullName,
        AccountStatus $status,
        DateTimeImmutable $createdAt
    ) {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->fullName = $fullName;
        $this->status = $status;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getStatus(): AccountStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function changeStatus(AccountStatus $status): void
    {
        $this->status = $status;
    }
}
