<?php

declare(strict_types=1);

namespace App\Domain\Account;

use DateTimeImmutable;

class Account
{
    private int $id;

    private string $uuid;

    private string $email;

    private string $password;

    private string $fullName;

    private AccountRole $role;

    private AccountStatus $status;

    private DateTimeImmutable $createdAt;

    public function __construct(
        string $uuid,
        string $email,
        string $password,
        string $fullName,
        AccountRole $role,
        AccountStatus $status,
        DateTimeImmutable $createdAt
    ) {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->role = $role;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getRole(): AccountRole
    {
        return $this->role;
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
