<?php

declare(strict_types=1);

namespace App\Controller\HostingPlan;

use App\Application\HostingPlan\ListHostingPlansHandler;
use App\Application\HostingPlan\ListHostingPlansQuery;
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

        foreach ($data['items'] as $plan) {
            $items[] = [
                'uuid' => $plan->getUuid(),
                'name' => $plan->getName(),
                'disk_space_mb' => $plan->getDiskSpaceMb(),
                'bandwidth_mb' => $plan->getBandwidthMb(),
                'price' => $plan->getPrice(),
                'created_at' => $plan->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return new JsonResponse([
            'result' => true,
            'data' => $items,
            'meta' => [
                'total' => $data['total'],
                'limit' => $data['limit'],
                'offset' => $data['offset'],
            ],
        ]);
    }
}
