<?php

declare(strict_types=1);

namespace App\Application\Account;

use Symfony\Component\Validator\Constraints as Assert;

class LoginAccountCommand
{
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email;

    #[Assert\NotBlank]
    private ?string $password;

    public function __construct(?string $email, ?string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email ?? '';
    }

    public function getPassword(): string
    {
        return $this->password ?? '';
    }
}
