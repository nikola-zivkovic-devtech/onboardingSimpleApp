<?php

require_once '../vendor/autoload.php';

use FurnitureStore\Helpers\Request;
use FurnitureStore\Databases\Database;


Request::prepare();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)
{
    $r->addRoute('GET', '/[index]', 'Welcome');
    $r->addRoute('GET', '/store/chair', 'StoreController@getAll');
    $r->addRoute('GET', '/store/chair/{id:[0-9]+}', 'StoreController@getOne');
    $r->addRoute('GET', '/store/sofa', 'StoreController@getAll');
    $r->addRoute('GET', '/store/sofa/{id:[0-9]+}', 'StoreController@getOne');
});

$db = new Database();
$db->connect();