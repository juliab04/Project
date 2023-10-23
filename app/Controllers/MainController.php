<?php

namespace Controllers;

use Entity\Product;
use Repository\ProductRepository;
use Service\AuthenticationCookiesService;
use Service\AuthenticationServiceInterface;
use Service\AuthenticationSessionService;

class MainController
{
    private AuthenticationServiceInterface $authenticateService;
    private ProductRepository $productRepository;

    public function __construct(AuthenticationServiceInterface $authenticateService, ProductRepository $productRepository)
    {
        $this->authenticateService = $authenticateService;
        $this->productRepository = $productRepository;
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