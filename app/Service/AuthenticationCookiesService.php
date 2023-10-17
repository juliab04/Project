<?php

namespace Service;

use Entity\User;
use Repository\UserRepository;

class AuthenticationCookiesService implements UserAuthentication
{
    private User $user;
    private UserRepository $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }
    public function getAuthenticateUser(): User|null
    {
        if (isset($this->user)) {
            return $this->user;
        }

        setcookie('user_id', time() + 7200);

        if (!isset($_COOKIE['user_id'])) {
            return null;
        }
        $this->user = $this->userRepository->getById($_COOKIE['user_id']);

        return $this->user;
    }
    public function authenticate(string $email, string $password): User|null
    {
        $user = $this->userRepository->getByEmail($email);
        if ($user === null) {
            return null;
        }

        if (password_verify($password, $user->getPassword())) {

            $_COOKIE['user_id'] = $user->getId();

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