<?php

declare(strict_types=1);

namespace App\Domain\Website;

interface WebsiteRepositoryInterface
{
    public function save(Website $website): void;

    public function findByUuid(string $uuid): ?Website;

    /**
     * @return Website[]
     */
    public function findAll(int $limit, int $offset): array;

    public function countAll(): int;

    public function delete(Website $website): void;
}
