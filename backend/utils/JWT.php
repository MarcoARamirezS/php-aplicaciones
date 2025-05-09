<?php
namespace Backend\Utils;

use Firebase\JWT\JWT;
use Exception;

class JWT {
    private static $key = "secret_key"; 

    public static function create($payload) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // JWT válido por 1 hora
        $payload['iat'] = $issuedAt;
        $payload['exp'] = $expirationTime;

        return JWT::encode($payload, self::$key);
    }

    public static function validate($token) {
        try {
            $decoded = JWT::decode($token, self::$key, ['HS256']);
            return (array)$decoded;
        } catch (Exception $e) {
            return null;
        }
    }
}
