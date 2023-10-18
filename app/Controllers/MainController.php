<?php

namespace Controllers;

use Entity\Product;
use Repository\ProductRepository;
use Service\AuthenticationCookiesServiceService;
use Service\AuthenticationServiceInterface;
use Service\AuthenticationSessionServiceService;

class MainController
{
//    private Product $productModel;
//    public function __construct()
//    {
//        $this->productModel = new Product();
//    }
    private AuthenticationServiceInterface $authenticateService;
    private ProductRepository $productRepository;

    public function __construct(AuthenticationServiceInterface $authenticateService)
    {
        $this->authenticateService = $authenticateService;
        $this->productRepository = new ProductRepository();
    }

    public function main()
    {
        $user = $this->authenticateService->getAuthenticateUser();

        if ($user === null) {
            header('Location: /login');
        }

        $products = $this->productRepository->getAll();
        require_once './Views/main.phtml';


    }
}