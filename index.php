<?php
require "vendor/autoload.php";

const APPLICATION_PATH = __DIR__.'/';

$users = new \App\Controllers\Users();
$users->showFirstScreen();
die();


//$user = new \App\Models\User();
//$file = new \App\Models\File();
//$user->getData();

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

$controllerName = 'Users';
$actionName = 'showFirstScreen';

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
