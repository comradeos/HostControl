<?php

declare(strict_types=1);

namespace App\Domain\Account;

enum AccountRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
}
