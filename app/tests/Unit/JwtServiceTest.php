<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Infrastructure\Security\JwtService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class JwtServiceTest extends TestCase
{
    public function testEncodeAndDecodeRoundTrip(): void
    {
        $service = new JwtService('test-secret');
        $payload = [
            'sub' => 'user-123',
            'role' => 'user',
            'exp' => time() + 3600,
        ];

        $token = $service->encode($payload);
        $decoded = $service->decode($token);

        $this->assertSame('user-123', $decoded['sub']);
        $this->assertSame('user', $decoded['role']);
    }

    public function testDecodeThrowsOnTamperedSignature(): void
    {
        $service = new JwtService('test-secret');
        $token = $service->encode(['sub' => 'user-123']);

        [$header, , $signature] = explode('.', $token);
        $tamperedPayload = rtrim(strtr(base64_encode('{"sub":"attacker"}'), '+/', '-_'), '=');
        $tamperedToken = $header . '.' . $tamperedPayload . '.' . $signature;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid token signature');

        $service->decode($tamperedToken);
    }
}
