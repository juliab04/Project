<?php

namespace Repository;
use Entity\Basket;


class BasketRepository
{
    private \PDO $pdo;
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getByProduct(int $productId, int $userId): Basket|null
    {
        $stmt = $this->pdo->prepare('select * from basket_items where product_id = :productId and user_id =:userId');
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }

        $basketData = new Basket($result['product_id'], $result['user_id'], $result['quantity']);
        return $basketData;
    }

    public function update(int $quantity, int $productId, int $userId)
    {
        $stmt = $this->pdo->prepare('update basket_items set quantity = quantity + :quantity where product_id = :productId and user_id =:userId');
        $stmt->execute(['quantity' => $quantity, 'productId' => $productId, 'userId' => $userId]);
    }

    public function add(int $userId, int $productId, int $quantity)
    {
        $productData = BasketRepository::getByProduct($productId, $userId);
        if (!empty($productData)) {
            BasketRepository::update($quantity, $productId, $userId);
        } else {
            $stmt = $this->pdo->prepare("insert into basket_items(user_id, product_id, quantity) values (:userId, :productId, :quantity)");
            $stmt->execute(['userId' => $userId, 'productId' => $productId, 'quantity' => $quantity]);
        }


    }

    public function getAllByUser(int $userId)
    {
        $statement = $this->pdo->prepare('select * from basket_items where user_id =:user_id');
        $statement->execute(['user_id' => $userId]);
        $result = $statement->fetchAll();
        if (empty($result)) {
            return null;
        }
        $basketData = [];
        foreach ($result as $item) {
            $basket = new Basket($item['product_id'], $item['user_id'], $item['quantity']);
            $basketData[] = $basket;
        }

        return $basketData;
    }
    public function deleteProduct(int $userId, int $productId)
    {
        $stmt = $this->pdo->prepare('delete from basket_items where product_id = :productId and user_id =:userId');
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);

    }
}