<?php

require_once '../vendor/autoload.php';

use FurnitureStore\Databases\Database;
use FurnitureStore\Helpers\HttpRequest;
use FurnitureStore\Logger\Logger;

// parse HTTP request
HttpRequest::prepare();

// parse database config file
$config = parse_ini_file('../config/config.ini');

// instantiate logger
$logger = new Logger();

// connect to a database
$db = new Database($config, $logger);
$db->connect();


// add routes
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)
{
    $r->addRoute('GET', '/store/chair', 'StoreController@getAll');
    $r->addRoute('GET', '/store/chair/{id:[0-9]+}', 'StoreController@getOne');
    $r->addRoute('POST', '/store/chair', 'StoreController@create');
    $r->addRoute('DELETE', '/store/chair/{id:[0-9]+}', 'StoreController@delete');
    $r->addRoute('PUT', '/store/chair/{id:[0-9]+}', 'StoreController@update');
});