<?php

declare(strict_types=1);

namespace App\Domain\Account;

enum AccountStatus: string
{
    case ACTIVE = 'active';

    case SUSPENDED = 'suspended';

    case DELETED = 'deleted';
}
