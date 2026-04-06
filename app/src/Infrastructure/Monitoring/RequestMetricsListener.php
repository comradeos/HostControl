<?php

declare(strict_types=1);

namespace App\Infrastructure\Monitoring;

use Prometheus\CollectorRegistry;
use Prometheus\Counter;
use Prometheus\Exception\MetricsRegistrationException;
use Prometheus\Histogram;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestMetricsListener implements EventSubscriberInterface
{
    private CollectorRegistry $registry;

    private float $startTime = 0.0;

    private Counter $counter;

    private Histogram $histogram;

    /**
     * @throws MetricsRegistrationException
     */
    public function __construct(CollectorRegistry $registry)
    {
        $this->registry = $registry;

        $this->counter = $this->registry->getOrRegisterCounter(
            'app',
            'http_requests_total',
            'Total HTTP requests',
            ['method', 'route', 'status']
        );

        $this->histogram = $this->registry->getOrRegisterHistogram(
            'app',
            'http_request_duration_seconds',
            'Request duration',
            ['method', 'route', 'status'],
            [0.1, 0.3, 0.5, 1, 2]
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onRequest',
            KernelEvents::RESPONSE => 'onResponse',
        ];
    }

    public function onRequest(RequestEvent $event): void
    {
        $this->startTime = microtime(true);
    }

    public function onResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        $duration = microtime(true) - $this->startTime;

        $method = (string) $request->getMethod();

        $route = $request->attributes->get('_route');
        if ($route === null) {
            $route = 'unknown';
        }

        $status = (string) $response->getStatusCode();

        $labels = [$method, $route, $status];

        $this->counter->inc($labels);
        $this->histogram->observe($duration, $labels);
    }
}
