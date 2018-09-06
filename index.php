<?php
require "vendor/autoload.php";
require_once 'app/Core/config.php';
require_once 'app/Core/init.php';

const APPLICATION_PATH = __DIR__.'/';

$urlPath = parse_url($_SERVER['REQUEST_URI'])['path'];
//$routes = explode('/', $_SERVER['REQUEST_URI']);
$routes = explode('/', $urlPath);

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
        $controller->$actionName();
    } else {
        throw new Exception("Method not found");
    }
} catch (Exception $e) {
    require "errors/404.php";
}
