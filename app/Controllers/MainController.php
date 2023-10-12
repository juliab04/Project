<?php

namespace Controllers;

use Entity\Product;
use Repository\ProductRepository;
use Service\AuthenticateService;

class MainController
{
//    private Product $productModel;
//    public function __construct()
//    {
//        $this->productModel = new Product();
//    }
    private AuthenticateService $authenticateService;

    public function __construct()
    {
        $this->authenticateService = new AuthenticateService();
    }

    public function main()
    {
        $user = $this->authenticateService->getAuthenticateUser();

        if ($user === null) {
            header('Location: /login');
        }

        $products = ProductRepository::getAll();
        require_once './Views/main.phtml';


    }
}