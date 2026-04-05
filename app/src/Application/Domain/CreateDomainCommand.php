<?php

declare(strict_types=1);

namespace App\Application\Domain;

use Symfony\Component\Validator\Constraints as Assert;

class CreateDomainCommand
{
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private string $name;

    #[Assert\NotBlank]
    private string $accountUuid;

    public function __construct(string $name, string $accountUuid)
    {
        $this->name = $name;
        $this->accountUuid = $accountUuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAccountUuid(): string
    {
        return $this->accountUuid;
    }
}
