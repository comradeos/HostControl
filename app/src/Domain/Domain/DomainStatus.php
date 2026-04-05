<?php

declare(strict_types=1);

namespace App\Domain\Domain;

enum DomainStatus: string
{
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';
}
