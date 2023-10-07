<?php

namespace Service;

use Model\User;

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
        $this->user = User::getById($_SESSION['user_id']);

        return $this->user;
    }
}