<?php

declare(strict_types=1);

namespace App\Application\Website;

use App\Application\Common\PaginationResult;
use App\Application\Website\DTO\WebsiteResponse;
use App\Domain\Website\WebsiteRepositoryInterface;

class ListWebsitesHandler
{
    private WebsiteRepositoryInterface $repository;

    public function __construct(WebsiteRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ListWebsitesQuery $query): PaginationResult
    {
        $limit = $query->getLimit();
        $offset = $query->getOffset();

        $items = $this->repository->findAll($limit, $offset);
        $total = $this->repository->countAll();

        $result = [];

        foreach ($items as $item) {
            $result[] = new WebsiteResponse($item);
        }

        return new PaginationResult(
            items: $result,
            total: $total,
            limit: $limit,
            offset: $offset
        );
    }
}
