<?php

namespace Controllers;
use Model\Product;
use Repository\ProductRepository;
use Service\AuthenticationCookiesService;
use Service\AuthenticationSessionService;

class ProductController
{
    private AuthenticationCookiesService $authenticateService;
    private ProductRepository $productRepository;
    public function __construct()
    {
        $this->authenticateService = new AuthenticationCookiesService();
        $this->productRepository = new ProductRepository();
    }
    public function getProductCart()
    {
        $user = $this->authenticateService->getAuthenticateUser();
        if ($user === null) {
            header('Location: /login');
        }

        $method = $_SERVER['REQUEST_METHOD'];
        if (isset($_POST['product-id'])) {
            $productId = $_POST['product-id'];

            $productData = $this->productRepository->getProduct($productId);

        } else {
            $errors['product-id'] = 'product-id is require';
        }


        require_once './Views/product.phtml';
    }
}