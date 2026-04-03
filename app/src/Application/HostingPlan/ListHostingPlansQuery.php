<?php

declare(strict_types=1);

namespace App\Application\HostingPlan;

class ListHostingPlansQuery
{
    private int $limit;

    private int $offset;

    public function __construct(int $limit, int $offset)
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
