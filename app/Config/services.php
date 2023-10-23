<?php

use Controllers\CartController;
use Controllers\MainController;
use Controllers\ProductController;
use Controllers\UserController;
use Repository\BasketRepository;
use Repository\ProductRepository;
use Repository\UserRepository;
use Service\AuthenticationSessionService;
use Service\AuthenticationServiceInterface;

  return  [
    MainController::class => function (): Maincontroller {
        $obj = Container::get(AuthenticationServiceInterface::class);
        $repository = Container::get(ProductRepository::class);

        return new  MainController($obj, $repository);
    },

    CartController::class => function(): CartController {
        $obj = Container::get(AuthenticationServiceInterface::class);
        $repository = Container::get(BasketRepository::class);

        return new  CartController($obj, $repository);
    },

    ProductController::class => function(): ProductController {
        $obj = Container::get(AuthenticationServiceInterface::class);
        $repository = Container::get(ProductRepository::class);

        return new  ProductController($obj, $repository);
    },

    UserController::class => function(): UserController {
        $obj = Container::get(AuthenticationServiceInterface::class);
        $repository = Container::get(UserRepository::class);

        return new  UserController($obj, $repository);
    },

    AuthenticationServiceInterface:: class => function (): AuthenticationServiceInterface {
        return new AuthenticationSessionService();
    },

    PDO::class => function (): PDO {

        return new PDO("pgsql:host = db, dbname=dbname", "dbuser", "dbpwd");
    },

    ProductRepository::class => function (): ProductRepository {
        $pdo = Container::get(PDO::class);
        return new ProductRepository($pdo);
    },

    UserRepository::class => function (): UserRepository {
        $pdo = Container::get(PDO::class);
        return new UserRepository($pdo);
    },

    BasketRepository::class => function (): BasketRepository {
        $pdo = Container::get(PDO::class);
        return new BasketRepository($pdo);
    },
];
