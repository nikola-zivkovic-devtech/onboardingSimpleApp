<?php

require_once '../vendor/autoload.php';

use FurnitureStore\Helpers\Request;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)
{
    $r->addRoute('GET', '/[index]', 'Welcome');
    $r->addRoute('GET', '/store/chairs', 'StoreController@getAll');
    $r->addRoute('GET', '/store/chair/{id:[0-9]+}', 'StoreController@getOne');
});

Request::prepare();