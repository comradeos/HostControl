<?php

declare(strict_types=1);

namespace App\Domain\Account;

interface AccountRepositoryInterface
{
    public function save(Account $account): void;

    public function findById(int $id): ?Account;

    public function findByUuid(string $uuid): ?Account;

    public function findByEmail(string $email): ?Account;

    public function findAll(int $limit, int $offset): array;

    public function countAll(): int;

    public function findByStatus(string $status, int $limit, int $offset): array;

    public function countByStatus(string $status): int;

    public function existsByEmail(string $email): bool;
}
