<?php

class Route
{

    private static array $routes = [];


    public static function get(string $url,arrray $action)
    {
        self::$routes["GET"][$url] = $action;    
    }


    public static function dispach()
    {


    $method = $_SERVER["REQUEST_METHOD"];
    $url = parse_url($_SERVER["REQUEST_URI"],PHP_URL_PATH);


    }




} 