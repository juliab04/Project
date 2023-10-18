<?php

namespace Service;

use Entity\User;

interface AuthenticationServiceInterface
{
    public function getAuthenticateUser(): User|null;

    public function authenticate(string $email, string $password): User|null;

    public function logout();
}