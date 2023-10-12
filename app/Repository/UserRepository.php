<?php

namespace Repository;
use Entity\User;
use Repository\BasketRepository;


class UserRepository
{
    public static function getById(int $userId): User|null
    {
        $stmt =ConnectionFactory::create()->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }
        $user = new User($result['name'], $result['email'], $result['password']);
        $user->setId($result['id']);

        return $user;
    }
    public static function getByEmail(string $email): User|null
    {
        $stmt =ConnectionFactory::create()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $result = $stmt->fetch();
        if (empty($result)) {
            return null;
        }
        $user = new User($result['name'], $result['email'], $result['password']);
        $user->setId($result['id']);

        return $user;
    }

    public static function addUsers(string $name, string $email, string $password)
    {
        $statement = ConnectionFactory::create()->prepare("insert into users(name, email, password) values (:name, :email, :password)");
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    }


}