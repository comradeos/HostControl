<?php

declare(strict_types=1);

namespace App\Application\Website;

use App\Application\Website\DTO\WebsiteResponse;
use App\Domain\Website\WebsiteRepositoryInterface;
use InvalidArgumentException;

class GetWebsiteByUuidHandler
{
    private WebsiteRepositoryInterface $repository;

    public function __construct(WebsiteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(string $uuid): WebsiteResponse
    {
        $website = $this->repository->findByUuid($uuid);

        if ($website === null) {
            throw new InvalidArgumentException('Website not found');
        }

        return new WebsiteResponse($website);
    }
}
