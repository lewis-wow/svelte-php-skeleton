<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Bearer {
    public function __construct($key) {
        $this->key = $key;
    }   
    
    public function createToken($data) {
        $key = new Key($this->key);
        $token = array(
            "iss" => env("SERVER_NAME"),
            "aud" => env("SERVER_NAME"),
            "iat" => time(),
            "nbf" => time(),
            "exp" => time() + intval(env("JWT_EXPIRATION_TIME")),
            "data" => $data
        );
        return JWT::encode($token, $key, env("JWT_ALGO"));
    }

    public function getToken() {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    public function validateToken($jwt) {
        $token = JWT::decode($jwt, env("JWT_KEY"), env("JWT_ALGO"));
        $now = new DateTimeImmutable();
        $serverName = env("SERVER_NAME");

        if ($token->iss !== $serverName || $token->nbf > $now->getTimestamp() || $token->exp < $now->getTimestamp()) {
            return null;
        }

        return $token->data;
    }

    private function getAuthorizationHeader() {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
}
