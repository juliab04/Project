<?php
namespace Controllers;

use Repository\BasketRepository;
use Repository\UserRepository;
use Service\AuthenticationCookiesService;
use Service\AuthenticationServiceInterface;
use Service\AuthenticationSessionService;

class CartController
{
    private AuthenticationServiceInterface $authenticateService;
    private BasketRepository $basketRepository;
    public function __construct(AuthenticationServiceInterface $authenticateService, BasketRepository $basketRepository)
    {
        $this->authenticateService = $authenticateService;
        $this->basketRepository = $basketRepository;
    }

    public function addToCart()
    {
        $user = $this->authenticateService->getAuthenticateUser();
        if ($user === null) {
            header('Location: /login');
        }

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST') {

            $productId = $_POST['product-id'];
            $quantity = $_POST['quantity'];
            $userId = $_SESSION['user_id'];

            if (strlen($quantity) < 1 or strlen($quantity) > 100) {
                echo 'Количество продукта не может состоять не менее чем из 1 символа и не более чем из 15';
            }

            $this->basketRepository->add($userId, $productId, $quantity);
        }

        header("Location: /main");
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
        $user = $this->authenticateService->getAuthenticateUser();
        if ($user === null) {
            header('Location: /login');
        }

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST') {
            $productId = $_POST['product-id'];

            $this->basketRepository->deleteProduct($user->getId(), $productId);
        }
    }
}