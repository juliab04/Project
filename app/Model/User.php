<?php
namespace Model;
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

    public static function getById(int $userId)
    {
        $stmt =ConnectionFactory::create()->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetch();
    }
    public static function getByEmail(string $email): self|null
    {
        $stmt =ConnectionFactory::create()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }
        $user = new self($result['name'], $result['email'], $result['password']);
        $user->setId($result['id']);

        return $user;
    }

    public static function addUsers(string $name, string $email, string $password)
    {
        $statement = ConnectionFactory::create()->prepare("insert into users(name, email, password) values (:name, :email, :password)");
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    }
    public function basketProducts()
    {
        return Basket::getAllByUser($this->getId());
    }

    public function productsInBasket()
    {
        $productsInBasket = $this->basketProducts();
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