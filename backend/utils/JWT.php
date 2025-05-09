<?php
namespace Backend\Utils;

use Firebase\JWT\JWT as FirebaseJWT;
use Firebase\JWT\Key;
use Exception;

class JWTHandler {
    private static $key = "secret_key"; 

    public static function create($payload) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600; // 1 hora
        $payload['iat'] = $issuedAt;
        $payload['exp'] = $expirationTime;

        return FirebaseJWT::encode($payload, self::$key, 'HS256');
    }

    public static function validate($token) {
        try {
            $decoded = FirebaseJWT::decode($token, new Key(self::$key, 'HS256'));
            return (array)$decoded;
        } catch (Exception $e) {
            return null;
        }
    }
}

