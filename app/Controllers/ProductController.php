<?php

namespace Controllers;
use Model\Product;

class ProductController
{

    public function getProductCart()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        session_start();
        if (isset($_SESSION['user_id'])) {

                $userId = $_SESSION['user_id'];

                if (isset($_POST['product-id'])) {
                    $productId = $_POST['product-id'];

                    $productData = Product::getProduct($productId);

                } else {
                    $errors['product-id'] = 'product-id is require';
                }


                require_once './Views/product.phtml';

        } else {
            header('Location: /login');
        }
    }
}