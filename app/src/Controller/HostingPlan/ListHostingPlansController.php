<?php

declare(strict_types=1);

namespace App\Controller\HostingPlan;

use App\Application\HostingPlan\ListHostingPlansHandler;
use App\Application\HostingPlan\ListHostingPlansQuery;
use App\Infrastructure\Http\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ListHostingPlansController
{
    private ListHostingPlansHandler $handler;

    public function __construct(ListHostingPlansHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/hosting-plans', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $limit = (int) $request->query->get('limit', 10);
        $offset = (int) $request->query->get('offset', 0);

        $query = new ListHostingPlansQuery(
            limit: $limit,
            offset: $offset
        );

        $data = $this->handler->handle($query);

        $items = [];

        foreach ($data['items'] as $dto) {
            $items[] = $dto->toArray();
        }

        return ApiResponse::success($items, [
            'total' => $data['total'],
            'limit' => $data['limit'],
            'offset' => $data['offset'],
        ]);
    }
}
