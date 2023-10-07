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
        session_start();
        if (isset($_SESSION['user_id'])) {
            if ($method === 'POST') {

                $productId = $_POST['product-id'];
                $quantity = $_POST['quantity'];
                $userId = $_SESSION['user_id'];

                if (strlen($quantity) < 1 or strlen($quantity) > 100) {
                    echo 'Количество продукта не может состоять не менее чем из 1 символа и не более чем из 15';
                }

                $productData = Basket::getByProduct($productId, $userId);
                if (!empty($productData)) {
                   Basket::update($quantity, $productId, $userId);
                } else {
                    Basket::add($userId, $productId, $quantity);
                }

            }
        } else {
            header('Location: /login');
        }
    }

    public function cart()
    {
        $userId = $this->authenticateService->getAuthenticateUser();
        if ($userId === null) {
            header('Location: /login');
        }
        $this->authenticateService->getAuthenticateUser();

        $productsInBasket = Basket::getAllByUser($userId);
        $productsWithKeys = $this->getProducts($productsInBasket);
        $totalCart = $this->TotalCart($productsInBasket, $productsWithKeys);


            require_once './Views/cart.phtml';

    }

    private function getProducts(array $productsInBasket)
    {
        $productIds = [];
        foreach ($productsInBasket as $productInBasket) {
            $productIds[] = $productInBasket->getProductId();
        }

        $productIds = implode(', ', $productIds);
        $products = Product::getAllByProductIds($productIds);

        $productsWithKeys = [];
        foreach ($products as $product) {
            $productsWithKeys[$product->getId()] = $product;
        }
        return $productsWithKeys;
    }
    private function TotalCart(array $productsInBasket, array $productsWithKeys)
    {
            $totalCart = 0;
            foreach ($productsInBasket as $productInBasket) {
                $productId = $productInBasket->getProductId();
                $product = $productsWithKeys[$productId];
                $price = $product->getPrice();
                $quantity = $productInBasket->getQuantity();
                $totalCart = $totalCart + $price * $quantity;

            }
            return $totalCart;
    }
    private function deleteProduct()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $userId = $this->authenticateService->getAuthenticateUser();
        if ($userId === null) {
            header('Location: /login');
        }

        if ($method === 'POST') {
            $productId = $_POST['product-id'];

            Basket::deleteProduct($userId, $productId);
        }
        }
}