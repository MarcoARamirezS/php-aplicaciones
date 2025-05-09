<?php
namespace Backend\Middleware;

use Backend\Utils\JWT;

class AuthMiddleware {
    public function validateToken($headers) {
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', $headers['Authorization']);
            return JWT::validate($token);
        }
        return null;
    }
}
