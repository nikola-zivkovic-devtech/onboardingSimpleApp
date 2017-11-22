<?php

require_once '../vendor/autoload.php';

use FurnitureStore\Helpers\HttpRequest;
use FurnitureStore\Databases\Database;


HttpRequest::prepare();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)
{
    $r->addRoute('GET', '/store/chair', 'StoreController@getAll');
    $r->addRoute('GET', '/store/chair/{id:[0-9]+}', 'StoreController@getOne');
    $r->addRoute('POST', '/store/chair', 'StoreController@create');
    $r->addRoute('DELETE', '/store/chair/{id:[0-9]+}', 'StoreController@delete');
    $r->addRoute('PUT', '/store/chair/{id:[0-9]+}', 'StoreController@update');
});

$db = new Database();
$db->connect();