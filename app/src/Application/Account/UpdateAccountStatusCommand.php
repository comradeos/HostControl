<?php

declare(strict_types=1);

namespace App\Application\Account;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateAccountStatusCommand
{
    #[Assert\NotBlank]
    private string $uuid;

    #[Assert\NotBlank]
    private string $status;

    public function __construct(string $uuid, string $status)
    {
        $this->uuid = $uuid;
        $this->status = $status;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getStatus(): string
    {
        return $this->status;
    }
}
