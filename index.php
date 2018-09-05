<?php
require "vendor/autoload.php";
require_once 'app/Core/config.php';

const APPLICATION_PATH = __DIR__.'/';

$routes = explode('/', $_SERVER['REQUEST_URI']);

$controllerName = 'Users';
$actionName = 'entrance';

if (!empty($routes[1])) {
    $controllerName = $routes[1];
}

if (!empty($routes[2])) {
    $actionName = $routes[2];
}

$class = ucfirst(strtolower($controllerName));

$fileName = "app/Controllers/{$class}.php";
$className = "App\\Controllers\\{$class}";

$requestParameters = $_REQUEST;
unset($requestParameters["route"]);

try {
    if (!file_exists($fileName)) {
        throw new Exception("File not found");
    }

    if (class_exists($className)) {
        $controller = new $className();
    } else {
        throw new Exception("File found but class not found");
    }

    if (method_exists($controller, $actionName)) {
        $controller->$actionName($requestParameters);
    } else {
        throw new Exception("Method not found");
    }
} catch (Exception $e) {
    require "errors/404.php";
}
