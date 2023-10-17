<?php

namespace Controllers;

use Entity\Product;
use Repository\ProductRepository;
use Service\AuthenticationCookiesService;
use Service\AuthenticationSessionService;

class MainController
{
//    private Product $productModel;
//    public function __construct()
//    {
//        $this->productModel = new Product();
//    }
    private AuthenticationCookiesService $authenticateService;
    private ProductRepository $productRepository;

    public function __construct()
    {
        $this->authenticateService = new AuthenticationCookiesService();
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