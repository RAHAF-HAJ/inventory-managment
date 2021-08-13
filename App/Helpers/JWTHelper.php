<?php
namespace App\Helpers;

use Core\Firebase\JWT\JWT;

Class JWTHelper {
    /**
     * Get header Authorization
     * */
    public static function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
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

    /**
     * get access token from header
     * */
    public static function getBearerToken()
    {
        $headers = self::getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    public static function generateJWT($user) {
        $JWT_CONST =  \App::getJWTConfig();
        $JWT_CONST['data'] = $user->id;
        $jwt = JWT::encode($JWT_CONST, $JWT_CONST['key']);
        return $jwt;
    }

    public static function decodeAndValidateJWT($jwt) {
        $JWT_CONST =  \App::getJWTConfig();
        try {
            $decoded = JWT::decode($jwt, $JWT_CONST['key'], array('HS256'));
            return [
                'object' => ['id' => $decoded],
                'error' =>'',
                'code' => ''
            ];
        }
        catch (\Exception $e){
            return [
                'object' => [],
                'error' => $e->getMessage(),
                'code'=> $e->getCode()
            ];
        }
    }
}