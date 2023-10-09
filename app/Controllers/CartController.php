<?php
namespace Controllers;
use Model\Basket;
use Model\Product;
use Service\AuthenticateService;

class CartController
{
//    private Basket $basketModel;
//    private Product $productModel;
//    public function __construct()
//    {
//        $this->basketModel = new Basket();
//        $this->productModel = new Product();
//    }
    private AuthenticateService $authenticateService;
    public function __construct()
    {
        $this->authenticateService = new AuthenticateService();
    }

    public function addToCart()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $user = $this->authenticateService->getAuthenticateUser();
        if ($user === null) {
            header('Location: /login');
        }
        if ($method === 'POST') {

            $productId = $_POST['product-id'];
            $quantity = $_POST['quantity'];
            $userId = $_SESSION['user_id'];

            if (strlen($quantity) < 1 or strlen($quantity) > 100) {
                echo 'Количество продукта не может состоять не менее чем из 1 символа и не более чем из 15';
            }

            Basket::add($userId, $productId, $quantity);
        }
    }

    public function cart()
    {
        $user = $this->authenticateService->getAuthenticateUser();
        if ($user === null) {
            header('Location: /login');
        }

        $productsInBasket = $user->basketProducts();
        $productsWithKeys = $user->productsInBasket();
        $totalCart = $user->getTotalCart();


        require_once './Views/cart.phtml';

    }

    private function deleteProduct()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $user = $this->authenticateService->getAuthenticateUser();
        if ($user === null) {
            header('Location: /login');
        }

        if ($method === 'POST') {
            $productId = $_POST['product-id'];

            Basket::deleteProduct($user->getId(), $productId);
        }
    }
}