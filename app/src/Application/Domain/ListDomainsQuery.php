<?php

declare(strict_types=1);

namespace App\Application\Domain;

class ListDomainsQuery
{
    private int $limit;

    private int $offset;

    public function __construct(int $limit = 10, int $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
