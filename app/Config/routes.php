<?php
use Controllers\CartController;
use Controllers\MainController;
use Controllers\UserController;
use Controllers\ProductController;

return [
    '/registrate' => [
        'class' => UserController::class,
        'method' => 'registrate',
    ],
    '/login' => [
        'class' => UserController::class,
        'method' => 'login',
    ],
    '/main' => [
        'class' => MainController::class,
        'method' => 'main',
    ],
    '/logout' => [
        'class' => UserController::class,
        'method' => 'logout',
    ],
    '/add-to-cart' => [
        'class' => CartController::class,
        'method' => 'addToCart',
    ],
    '/cart' => [
        'class' => CartController::class,
        'method' => 'cart',
    ],
    '/product' => [
        'class' => ProductController::class,
        'method' => 'getProductCart',
    ],
];
