<?php

declare(strict_types=1);

namespace App\Application\Domain;

use App\Domain\Domain\DomainRepositoryInterface;
use App\Application\Domain\DTO\DomainResponse;
use InvalidArgumentException;

class GetDomainByUuidHandler
{
    private DomainRepositoryInterface $repository;

    public function __construct(DomainRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $uuid): DomainResponse
    {
        $domain = $this->repository->findByUuid($uuid);

        if ($domain === null) {
            throw new InvalidArgumentException('Domain not found');
        }

        return new DomainResponse($domain);
    }
}
