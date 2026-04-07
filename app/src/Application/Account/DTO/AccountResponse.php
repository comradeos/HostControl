<?php

declare(strict_types=1);

namespace App\Application\Account\DTO;

use App\Domain\Account\Account;

class AccountResponse
{
    public string $uuid;

    public string $email;

    public string $fullName;

    public string $role;

    public string $status;

    public string $createdAt;

    public function __construct(Account $account)
    {
        $this->uuid = $account->getUuid();
        $this->email = $account->getEmail();
        $this->fullName = $account->getFullName();
        $this->role = $account->getRole()->value;
        $this->status = $account->getStatus()->value;
        $this->createdAt = $account->getCreatedAt()->format('Y-m-d H:i:s');
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'email' => $this->email,
            'full_name' => $this->fullName,
            'role' => $this->role,
            'status' => $this->status,
            'created_at' => $this->createdAt,
        ];
    }
}
