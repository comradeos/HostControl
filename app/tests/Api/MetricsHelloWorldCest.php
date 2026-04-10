<?php

declare(strict_types=1);

namespace App\Tests\Api;

use Tests\Support\ApiTester;

final class MetricsHelloWorldCest
{
    public function metricsEndpointIsReachable(ApiTester $I): void
    {
        $I->sendGet('/metrics');
        $I->seeResponseCodeIs(200);
        $I->seeHttpHeader('Content-Type');
    }
}
