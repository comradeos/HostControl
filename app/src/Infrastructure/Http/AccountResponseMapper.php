<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Domain\Account\Account;

class AccountResponseMapper
{
    public static function map(Account $account): array
    {
        $uuid = $account->getUuid();
        $email = $account->getEmail();
        $fullName = $account->getFullName();
        $status = $account->getStatus()->value;
        $createdAt = $account->getCreatedAt()->format('Y-m-d H:i:s');

        return [
            'uuid' => $uuid,
            'email' => $email,
            'full_name' => $fullName,
            'status' => $status,
            'created_at' => $createdAt,
        ];
    }
}
