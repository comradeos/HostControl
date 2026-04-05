<?php

declare(strict_types=1);

namespace App\Application\Common;

class PaginationResult
{
    private array $items;

    private int $total;

    private int $limit;

    private int $offset;

    public function __construct(array $items, int $total, int $limit, int $offset)
    {
        $this->items = $items;
        $this->total = $total;
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTotal(): int
    {
        return $this->total;
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
