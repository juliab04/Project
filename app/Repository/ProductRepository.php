<?php

namespace Repository;

use Entity\Product;

class ProductRepository
{
    private \PDO $pdo;
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    public function getAll()
    {
        $statement = $this->pdo->query('select * from products');
        $result = $statement->fetchAll();
        if (empty($result)) {
            return null;
        }
        $products = [];
        foreach ($result as $item) {
            $product = new Product($item['name'], $item['description'], $item['price'], $item['image_url']);
            $product->setId($item['id']);
            $products[] = $product;
        }

        return $products;
    }

    public function getAllForUserId($userId)
    {
        $statement = $this->pdo->query("select products.* from products inner join basket_items on products.id = product_id
         where basket_items.user_id=$userId");
        $result = $statement->fetchAll();
        if (empty($result)) {
            return null;
        }

        $products = [];
        foreach ($result as $item) {
            $product = new Product($item['name'], $item['description'], $item['price'], $item['image_url']);
            $product->setId($item['id']);
            $products[] = $product;
        }

        return $products;
    }
    public function getProduct(int $productId): Product|null
    {
        $stmt = $this->pdo->prepare('select * from products where id = :productId');
        $stmt->execute(['productId' => $productId]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }

        $data = new Product($result['name'], $result['description'], $result['price'], $result['image_url']);
        return $data;
    }
}