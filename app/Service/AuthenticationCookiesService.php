<?php

namespace Service;

use Entity\User;
use Repository\UserRepository;

class AuthenticationCookiesService implements AuthenticationServiceInterface
{
    private User $user;

    public function getAuthenticateUser(): User|null
    {
        if (isset($this->user)) {
            return $this->user;
        }

        if (!isset($_COOKIE['user_id'])) {
            return null;
        }
        $userRepository = \Container::get(UserRepository::class);
        $this->user = $userRepository->getById($_COOKIE['user_id']);

        return $this->user;
    }

    public function authenticate(string $email, string $password): User|null
    {
        $userRepository = \Container::get(UserRepository::class);
        $user = $userRepository->getByEmail($email);
        if ($user === null) {
            return null;
        }

        if (password_verify($password, $user->getPassword())) {

            setcookie('user_id', $user->getId());

            $this->user = $user;

            return $this->user;
        }
        return null;
    }

    public function logout()
    {
        setcookie('user_id', time() - 7200);

        unset($this->user);
    }
}