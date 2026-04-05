<?php

declare(strict_types=1);

namespace App\Domain\Domain;

interface DomainRepositoryInterface
{
    public function save(Domain $domain): void;

    public function findByUuid(string $uuid): ?Domain;

    public function findAll(int $limit, int $offset): array;

    public function count(): int;

    public function delete(string $uuid): void;
}
