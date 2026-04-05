<?php

declare(strict_types=1);

namespace App\Application\Domain;

use App\Domain\Domain\DomainRepositoryInterface;
use InvalidArgumentException;

class DeleteDomainHandler
{
    private DomainRepositoryInterface $repository;

    public function __construct(DomainRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $uuid): void
    {
        $domain = $this->repository->findByUuid($uuid);

        if ($domain === null) {
            throw new InvalidArgumentException('Domain not found');
        }

        $this->repository->delete($uuid);
    }
}
