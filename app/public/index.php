<?php
spl_autoload_register(function (string $className) {
    $className = str_replace("\\", "/", $className);
    if (file_exists("./../$className.php")) {
        require_once "./../$className.php";
        return true;
    }
    return false;
});

$uri = $_SERVER['REQUEST_URI'];

$routes = require_once './../Config/routes.php';

if (isset($routes[$uri])) {
    $handler = $routes[$uri];

    $class = $handler['class'];
    $method = $handler['method'];
    $obj = new $class();
    $obj-> $method();
} else {
    require_once './Views/404.html';
}


?>

