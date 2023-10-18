<?php

use Controllers\CartController;
use Controllers\MainController;
use Controllers\ProductController;
use Controllers\UserController;
use Service\AuthenticationCookiesServiceService;

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

$controllers = [
    MainController::class => function (): Maincontroller{
    $obj = new AuthenticationCookiesServiceService();

    return new  MainController($obj);
    },

    CartController::class => function(): CartController{
        $obj = new AuthenticationCookiesServiceService();

        return new  CartController($obj);
    },

    ProductController::class => function(): ProductController{
        $obj = new AuthenticationCookiesServiceService();

        return new  ProductController($obj);
    },

    UserController::class => function(): UserController{
        $obj = new AuthenticationCookiesServiceService();

        return new  UserController($obj);
    },
];

if (isset($routes[$uri])) {
    $handler = $routes[$uri];

    $class = $handler['class'];
    $method = $handler['method'];

    if (isset($controllers[$class])) {
        $callback = $controllers[$class];
        $obj = $callback();
    } else {
        $obj = new $class();
    }

    $obj-> $method();
} else {
    require_once './Views/404.html';
}


?>

