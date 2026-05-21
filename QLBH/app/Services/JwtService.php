<?php

namespace App\Services;

class JwtService
{
    public static function createToken(array $payload): string
    {
        $secret = self::secret();
        $header = self::base64UrlEncode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $payload = self::base64UrlEncode(json_encode($payload));
        $signature = self::base64UrlEncode(hash_hmac('sha256', "{$header}.{$payload}", $secret, true));

        return "{$header}.{$payload}.{$signature}";
    }

    public static function validateToken(string $token): ?array
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return null;
        }

        [$header, $payload, $signature] = $parts;
        $expected = self::base64UrlEncode(hash_hmac('sha256', "{$header}.{$payload}", self::secret(), true));

        if (!hash_equals($expected, $signature)) {
            return null;
        }

        $payloadJson = json_decode(self::base64UrlDecode($payload), true);
        if (!is_array($payloadJson)) {
            return null;
        }

        if (isset($payloadJson['exp']) && time() > $payloadJson['exp']) {
            return null;
        }

        return $payloadJson;
    }

    protected static function secret(): string
    {
        $secret = env('JWT_SECRET');
        return $secret ?: 'change-me-to-a-strong-secret';
    }

    protected static function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    protected static function base64UrlDecode(string $value): string
    {
        $remainder = strlen($value) % 4;
        if ($remainder) {
            $value .= str_repeat('=', 4 - $remainder);
        }

        return base64_decode(strtr($value, '-_', '+/'));
    }
}
