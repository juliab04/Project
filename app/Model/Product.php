<?php
namespace Model;
class Product
{
    private int $id;
    private string $name;
    private string $description;
    private int $price;
    private string $image_url;

    public function __construct(string $name, string $description, int $price, string $image_url)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->image_url = $image_url;
    }

    public static function getAll()
    {
        $statement = ConnectionFactory::create()->query('select * from products');
        $result = $statement->fetchAll();
        if (empty($result)) {
            return null;
        }
        $products = [];
        foreach ($result as $item) {
            $product = new self($item['name'], $item['description'], $item['price'], $item['image_url']);
            $product->setId($item['id']);
            $products[] = $product;
        }

        return $products;
    }

    public static function getAllByProductIds($productIds)
    {
        $statement = ConnectionFactory::create()->query("select * from products where id in ($productIds)");
        $result = $statement->fetchAll();
        if (empty($result)) {
            return null;
        }

        $products = [];
        foreach ($result as $item) {
            $product = new self($item['name'], $item['description'], $item['price'], $item['image_url']);
            $product->setId($item['id']);
            $products[] = $product;
        }

        return $products;
    }
    public static function getProduct(int $productId): self|null
    {
        $stmt = ConnectionFactory::create()->prepare('select * from products where id = :productId');
        $stmt->execute(['productId' => $productId]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }

        $data = new self($result['name'], $result['description'], $result['price'], $result['image_url']);
        return $data;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getImageUrl(): string
    {
        return $this->image_url;
    }

    public function getId(): int
    {
        return $this->id;
    }
}