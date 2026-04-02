<?php

declare(strict_types=1);

namespace App\Application\Account;

use Symfony\Component\Validator\Constraints as Assert;

class CreateAccountCommand
{
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $fullName;

    public function __construct(?string $email, ?string $fullName)
    {
        $this->email = $email;
        $this->fullName = $fullName;
    }

    public function getEmail(): string
    {
        return $this->email ?? '';
    }

    public function getFullName(): string
    {
        return $this->fullName ?? '';
    }
}
