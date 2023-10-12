<?php

namespace Service;

use Entity\User;
use Repository\UserRepository;
class AuthenticateService
{
    private User $user;

    public function getAuthenticateUser(): User|null
    {
        if (isset($this->user)) {
            return $this->user;
        }

        session_start();

        if (!isset($_SESSION['user_id'])) {
            return null;
        }
        $this->user = UserRepository::getById($_SESSION['user_id']);

        return $this->user;
    }
    public function authenticate(string $email, string $password): User|null
    {
        $user = UserRepository::getByEmail($email);
        if ($user === null) {
            return null;
        }

        if (password_verify($password, $user->getPassword())) {
            session_start();
            $_SESSION['user_id'] = $user->getId();

            $this->user = $user;

            return $this->user;
        }
        return null;
    }
    public function logout()
    {
        session_start();
        session_destroy();

        unset($this->user);
    }
}