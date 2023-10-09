<?php

namespace Controllers;
use Model\Product;
use Service\AuthenticateService;

class ProductController
{
    private AuthenticateService $authenticateService;
    public function __construct()
    {
        $this->authenticateService = new AuthenticateService();
    }
    public function getProductCart()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $user = $this->authenticateService->getAuthenticateUser();
        if ($user === null) {
            header('Location: /login');
        }

        if (isset($_POST['product-id'])) {
            $productId = $_POST['product-id'];

            $productData = Product::getProduct($productId);

        } else {
            $errors['product-id'] = 'product-id is require';
        }


        require_once './Views/product.phtml';
    }
}