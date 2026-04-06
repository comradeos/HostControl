<?php

declare(strict_types=1);

namespace App\Controller\Domain;

use App\Application\Domain\ListDomainsHandler;
use App\Application\Domain\ListDomainsQuery;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ListDomainsController
{
    private ListDomainsHandler $handler;

    public function __construct(ListDomainsHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/domains', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $limit = (int) $request->query->get('limit', 10);
        $offset = (int) $request->query->get('offset', 0);

        $query = new ListDomainsQuery($limit, $offset);

        $result = $this->handler->handle($query);

        return ApiResponse::success(
            $result->getItems(),
            [
                'total' => $result->getTotal(),
                'limit' => $result->getLimit(),
                'offset' => $result->getOffset(),
            ]
        );
    }
}
