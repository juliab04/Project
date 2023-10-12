<?php

namespace Entity;

class Basket
{
    private int $product_id;
    private int $user_id;
    private int $quantity;
    public function __construct(int $productId, int $userId, int $quantity)
    {
        $this->product_id = $productId;
        $this->user_id = $userId;
        $this->quantity = $quantity;

    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}