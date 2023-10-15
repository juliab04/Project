<?php

namespace Repository;
use Entity\User;


class UserRepository
{
    private ConnectionFactory $pdo;
    public function __construct()
    {
        $this->pdo = new ConnectionFactory();
    }
    public function getById(int $userId): User|null
    {
        $stmt =$this->pdo->create()->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }
        $user = new User($result['name'], $result['email'], $result['password']);
        $user->setId($result['id']);

        return $user;
    }
    public function getByEmail(string $email): User|null
    {
        $stmt =$this->pdo->create()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }
        $user = new User($result['name'], $result['email'], $result['password']);
        $user->setId($result['id']);

        return $user;
    }

    public function addUsers(string $name, string $email, string $password)
    {
        $statement = $this->pdo->create()->prepare("insert into users(name, email, password) values (:name, :email, :password)");
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    }


}