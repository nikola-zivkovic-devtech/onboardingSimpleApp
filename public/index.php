<?php

require_once '../bootstrap/bootstrap.php';

use Devtech\Helpers\Request;
use Devtech\Enums\NamespacePaths;


$routeInfo = $dispatcher->dispatch(Request::getHttpMethod(), Request::getUri());

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 not found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $controller = NamespacePaths::CONTROLLERS_PATH . $routeInfo[1];
        $vars = $routeInfo[2];
        $keys = array_keys($vars);

        if(!empty($vars)) {
            $obj = new $controller($vars[$keys[0]], $twig);
            $obj->renderView();
        } else {
            $obj = new $controller($twig);
            $obj->renderView();
        }

        break;
}