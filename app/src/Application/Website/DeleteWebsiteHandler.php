<?php

declare(strict_types=1);

namespace App\Application\Website;

use App\Domain\Website\WebsiteRepositoryInterface;
use InvalidArgumentException;

class DeleteWebsiteHandler
{
    private WebsiteRepositoryInterface $repository;

    public function __construct(WebsiteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $uuid): void
    {
        $website = $this->repository->findByUuid($uuid);

        if ($website === null) {
            throw new InvalidArgumentException('Website not found');
        }

        $this->repository->delete($website);
    }
}
