<?php

namespace Entity;
use Repository\BasketRepository;
use Repository\ProductRepository;
class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
    public function basketProducts()
    {
        $basketRepository = \Container::get(BasketRepository::class);
        return $basketRepository->getAllByUser($this->getId());
    }

    public function productsInBasket()
    {
        $productRepository = \Container::get(ProductRepository::class);

        $products = $productRepository->getAllForUserId($this->getId());

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