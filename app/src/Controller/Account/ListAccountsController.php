<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Application\Account\ListAccountsHandler;
use App\Application\Account\ListAccountsQuery;
use App\Infrastructure\Http\AccountResponseMapper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class ListAccountsController
{
    private ListAccountsHandler $handler;

    public function __construct(ListAccountsHandler $handler)
    {
        $this->handler = $handler;
    }

    #[Route('/api/accounts', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $limit = (int) $request->query->get('limit', 10);
        $offset = (int) $request->query->get('offset', 0);

        $query = new ListAccountsQuery(
            limit: $limit,
            offset: $offset
        );

        $data = $this->handler->handle($query);

        $items = [];

        foreach ($data['items'] as $account) {
            $items[] = AccountResponseMapper::map($account);
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
