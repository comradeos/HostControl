<?php

declare(strict_types=1);

namespace App\Infrastructure\Security;

use InvalidArgumentException;

class JwtService
{
    private string $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function encode(array $payload): string
    {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];

        $base64Header = $this->base64UrlEncode(json_encode($header));
        $base64Payload = $this->base64UrlEncode(json_encode($payload));

        $signature = hash_hmac(
            'sha256',
            $base64Header . '.' . $base64Payload,
            $this->secret,
            true
        );

        $base64Signature = $this->base64UrlEncode($signature);

        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }

    public function decode(string $token): array
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            throw new InvalidArgumentException('Invalid token');
        }

        [$base64Header, $base64Payload, $base64Signature] = $parts;

        $signature = $this->base64UrlEncode(
            hash_hmac(
                'sha256',
                $base64Header . '.' . $base64Payload,
                $this->secret,
                true
            )
        );

        if ($signature !== $base64Signature) {
            throw new InvalidArgumentException('Invalid token signature');
        }

        $payload = json_decode($this->base64UrlDecode($base64Payload), true);

        if (!is_array($payload)) {
            throw new InvalidArgumentException('Invalid token payload');
        }

        if (isset($payload['exp']) === true) {
            if (time() > $payload['exp']) {
                throw new InvalidArgumentException('Token expired');
            }
        }

        return $payload;
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $data): string
    {
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
