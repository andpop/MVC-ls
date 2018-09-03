<?php
require_once "core/config.php";
require "vendor/autoload.php";

//$user = new \App\Models\User();
//$file = new \App\Models\File();
//$user->getData();

//const APPLICATION_PATH = __DIR__;
//echo __DIR__;

//echo "<pre>";
//print_r($_SERVER);
//echo "-----------------------------------";
//echo "GET\n";
//print_r($_GET);
//echo "-----------------------------------";
//echo "POST\n";
//print_r($_POST);
//echo "-----------------------------------";

$routes = explode('/', $_GET['route']);

$controllerName = 'Main';
$actionName = 'welcome';

if (!empty($routes[0])) {
    $controllerName = $routes[0];
}

// получаем действие
if (!empty($routes[1])) {
    $actionName = $routes[1];
}

$class = ucfirst(strtolower($controllerName));

$fileName = "app/Controllers/{$class}.php";
$className = "App\\Controllers\\{$class}";

$paramsPOST = $_POST;
$paramsGET = $_GET;
unset($paramsGET["route"]);

//echo "file: $fileName \n";
//echo "class: $className \n";
//echo "POST:";
//print_r($paramsPOST);
//echo "GET:";
//print_r($paramsGET);

$users = new \App\Controllers\Users();
die();

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
