<?php
require_once '../bootstrap/bootstrap.php';

use FurnitureStore\Enums\NamespacePaths;
use FurnitureStore\Exceptions\ErrorOutput;
use FurnitureStore\Exceptions\RoutingException;
use FurnitureStore\Helpers\Request;

$routeInfo = $dispatcher->dispatch(Request::getHttpMethod(), Request::getUri());

$uriInfo = explode('/', Request::getUri());
if(isset($uriInfo[2])) {
    $itemType = $uriInfo[2];
}

if(count($routeInfo) > 1) {
    $controllerInfo = explode('@', $routeInfo[1]);
    $controller = $controllerInfo[0];
    $method = $controllerInfo[1];
}


switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        new ErrorOutput(new RoutingException('404 not found'));
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $controller;
        new ErrorOutput(new RoutingException('405 Method Not Allowed'));
        break;
    case FastRoute\Dispatcher::FOUND:

        $controller = NamespacePaths::CONTROLLERS_PATH . $controller;
        $vars = $routeInfo[2];
        $keys = array_keys($vars);

        if (isset($itemType)) {
            $obj = new $controller($itemType, $db);
        } else {
            $obj = new $controller();
        }

        if(!empty($vars)) {
            $obj->$method($vars[$keys[0]]);
        } else {
            $obj->$method();
        }

        break;
}