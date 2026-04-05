<?php

declare(strict_types=1);

namespace App\Application\Domain;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateDomainStatusCommand
{
    #[Assert\NotBlank]
    private string $uuid;

    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['active', 'suspended'])]
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
