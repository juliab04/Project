<?php
namespace Model;
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

    public static function getByProduct(int $productId, int $userId): self|null
    {
        $stmt = ConnectionFactory::create()->prepare('select * from baskets where product_id = :productId and user_id =:userId');
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }

        $basketData = new self($result['product_id'], $result['user_id'], $result['quantity']);
        return $basketData;
    }

    public static function update(int $quantity, int $productId, int $userId)
    {
        $stmt = ConnectionFactory::create()->prepare('update baskets set quantity = quantity + :quantity where product_id = :productId and user_id =:userId');
        $stmt->execute(['quantity' => $quantity, 'productId' => $productId, 'userId' => $userId]);
    }

    public static function add(int $userId, int $productId, int $quantity)
    {
        $stmt = ConnectionFactory::create()->prepare("insert into baskets(user_id, product_id, quantity) values (:userId, :productId, :quantity)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'quantity' => $quantity]);
    }

    public static function getAllByUser(int $userId)
    {
        $statement = ConnectionFactory::create()->prepare('select * from baskets where user_id =:user_id');
        $statement->execute(['user_id' => $userId]);
        $result = $statement->fetchAll();
        if (empty($result)) {
            return null;
        }
        $basketData = [];
        foreach ($result as $item) {
            $basket = new self($item['product_id'], $item['user_id'], $item['quantity']);
            $basketData[] = $basket;
        }

        return $basketData;
    }
    public static function deleteProduct(int $userId, int $productId)
    {
        $stmt = ConnectionFactory::create()->prepare('delete from baskets where product_id = :productId and user_id =:userId');
        $stmt->execute(['productId' => $productId, 'userId' => $userId]);

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