<?php

declare(strict_types=1);

namespace App\Controller\Website;

use App\Application\Website\ListWebsitesHandler;
use App\Application\Website\ListWebsitesQuery;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ListWebsitesController
{
    private ListWebsitesHandler $handler;

    public function __construct(ListWebsitesHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/websites', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $limit = (int) $request->query->get('limit', 10);
        $offset = (int) $request->query->get('offset', 0);

        $query = new ListWebsitesQuery(
            limit: $limit,
            offset: $offset
        );

        $pagination = $this->handler->handle($query);

        $items = $pagination->getItems();

        $meta = [
            'total' => $pagination->getTotal(),
            'limit' => $pagination->getLimit(),
            'offset' => $pagination->getOffset(),
        ];

        return ApiResponse::success($items, $meta);
    }
}
