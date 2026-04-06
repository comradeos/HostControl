<?php

declare(strict_types=1);

namespace App\Controller;

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

class MetricsController
{
    private CollectorRegistry $registry;

    public function __construct(CollectorRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @throws Throwable
     */
    #[Route('/metrics', methods: ['GET'])]
    public function __invoke(): Response
    {
        $renderer = new RenderTextFormat();

        $metrics = $this->registry->getMetricFamilySamples();

        $result = $renderer->render($metrics);

        return new Response(
            $result,
            200,
            ['Content-Type' => RenderTextFormat::MIME_TYPE]
        );
    }
}
