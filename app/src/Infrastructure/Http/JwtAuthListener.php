<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Infrastructure\Http\Attribute\PublicRoute;
use App\Infrastructure\Security\JwtService;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class JwtAuthListener
{
    private JwtService $jwtService;

    public function __construct(JwtService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * @throws ReflectionException
     */
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($this->isPublicRoute($request) === true) {
            return;
        }

        $authHeader = $request->headers->get('Authorization');

        if ($authHeader === null) {
            throw new InvalidArgumentException('Missing Authorization header');
        }

        if (str_starts_with($authHeader, 'Bearer ') === false) {
            throw new InvalidArgumentException('Invalid Authorization header');
        }

        $token = substr($authHeader, 7);

        $payload = $this->jwtService->decode($token);

        $request->attributes->set('user', $payload);
    }

    /**
     * @throws ReflectionException
     */
    private function isPublicRoute(Request $request): bool
    {
        $controller = $request->attributes->get('_controller');

        if ($controller === null) {
            return false;
        }

        if (is_string($controller) === true) {

            if (str_contains($controller, '::') === true) {
                [$class, $method] = explode('::', $controller);

                $reflectionMethod = new ReflectionMethod($class, $method);

                if ($reflectionMethod->getAttributes(PublicRoute::class) !== []) {
                    return true;
                }

                $reflectionClass = new ReflectionClass($class);

                if ($reflectionClass->getAttributes(PublicRoute::class) !== []) {
                    return true;
                }
            } else {
                $reflectionClass = new ReflectionClass($controller);

                if ($reflectionClass->getAttributes(PublicRoute::class) !== []) {
                    return true;
                }
            }

            return false;
        }

        if (is_array($controller) === true) {
            $class = $controller[0];
            $method = $controller[1];

            $reflectionMethod = new ReflectionMethod($class, $method);

            if ($reflectionMethod->getAttributes(PublicRoute::class) !== []) {
                return true;
            }

            $reflectionClass = $reflectionMethod->getDeclaringClass();

            if ($reflectionClass->getAttributes(PublicRoute::class) !== []) {
                return true;
            }
        }

        return false;
    }
}
