<?php

namespace FurnitureStore\Helpers;

/**
 * Class Request
 *
 * Prepares and returns uri and http method from HTTP requests.
 */
class Request
{
    private static $httpMethod;
    private static $uri;

    /**
     * Parses the uri from HTTP requests
     *
     * @return array  Contains http request method and parsed uri.
     */
    public static function prepare()
    {
        self::$httpMethod = $_SERVER['REQUEST_METHOD'];

        $uri = $_SERVER['REQUEST_URI'];
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        self::$uri = rawurldecode($uri);
    }

    public static function getHttpMethod()
    {
        return self::$httpMethod;
    }

    public static function getUri()
    {
        return self::$uri;
    }

}