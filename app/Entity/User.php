<?php

namespace Entity;
use Repository\BasketRepository;
use Repository\ProductRepository;
use Repository\UserRepository;
class User
{
    private ProductRepository $productRepository;
    private BasketRepository $basketRepository;
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->productRepository = new ProductRepository();
        $this->basketRepository = new BasketRepository();
    }
    public function basketProducts()
    {
        return $this->basketRepository->getAllByUser($this->getId());
    }

    public function productsInBasket()
    {
//        $productsInBasket = $this->basketProducts();
//        $productIds = [];
//        foreach ($productsInBasket as $productInBasket) {
//            $productIds[] = $productInBasket->getProductId();
//        }
//
//        $productIds = implode(', ', $productIds);
        $products = $this->productRepository->getAllForUserId($this->getId());

        $productsWithKeys = [];
        foreach ($products as $product) {
            $productsWithKeys[$product->getId()] = $product;
        }
        return $productsWithKeys;
    }
    public function getTotalCart()
    {
        $productsWithKeys = $this->productsInBasket();
        $totalCart = 0;
        foreach ($this->basketProducts() as $productInBasket) {
            $productId = $productInBasket->getProductId();
            $product = $productsWithKeys[$productId];
            $price = $product->getPrice();
            $quantity = $productInBasket->getQuantity();
            $totalCart = $totalCart + $price * $quantity;

        }
        return $totalCart;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}