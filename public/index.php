<?php
require_once '../bootstrap/bootstrap.php';

use FurnitureStore\Helpers\Request;
use FurnitureStore\Enums\NamespacePaths;

$routeInfo = $dispatcher->dispatch(Request::getHttpMethod(), Request::getUri());

$uriInfo = explode('/', Request::getUri());
$itemType = $uriInfo[2];

$controllerInfo = explode('@', $routeInfo[1]);
$controller = $controllerInfo[0];
$method = $controllerInfo[1];

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 not found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $controller;
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = NamespacePaths::CONTROLLERS_PATH . $controller;
        $vars = $routeInfo[2];
        $keys = array_keys($vars);

        $obj = new $controller($itemType, $db);

        if(!empty($vars)) {
            $obj->$method($vars[$keys[0]]);
        } else {
            $obj->$method();
        }

        break;
}