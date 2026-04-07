<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Account\AccountRole;
use App\Domain\Account\AccountStatus;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(
    name: 'accounts',
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'uniq_account_email', columns: ['email'])
    ]
)]
class AccountEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 36, unique: true)]
    private string $uuid;

    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[ORM\Column(type: 'string', length: 255)]
    private string $password;

    #[ORM\Column(name: 'full_name', type: 'string', length: 255)]
    private string $fullName;

    #[ORM\Column(type: 'string', enumType: AccountRole::class)]
    private AccountRole $role;

    #[ORM\Column(type: 'string', enumType: AccountStatus::class)]
    private AccountStatus $status;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable')]
    private DateTimeImmutable $createdAt;

    public function setUuid(string $uuid): void
    {
        $this->uuid = $uuid;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setFullName(string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function setRole(AccountRole $role): void
    {
        $this->role = $role;
    }

    public function setStatus(AccountStatus $status): void
    {
        $this->status = $status;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getRole(): AccountRole
    {
        return $this->role;
    }

    public function getStatus(): AccountStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
