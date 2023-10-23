<?php
namespace Controllers;
use Model\User;
use Repository\UserRepository;
use Service\AuthenticationCookiesService;
use Service\AuthenticationServiceInterface;
use Service\AuthenticationSessionService;

class UserController
{
    private AuthenticationServiceInterface $authenticateService;
    private UserRepository $userRepository;
    public function __construct(AuthenticationServiceInterface $authenticateService, UserRepository $userRepository)
    {
        $this->authenticateService = $authenticateService;
        $this->userRepository = $userRepository;
    }

    public function registrate()
    {
        if (!empty($_POST)) {
            $errors = $this->validate($_POST);

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            if (empty($errors)) {

                $password = password_hash($password, PASSWORD_DEFAULT);

                $this->userRepository->addUsers($name, $email, $password);

                $this->authenticateService->authenticate($email, $password);
            }
            header('Location: /main');
        }

        require_once './Views/registrate.phtml';

    }

    private function validate(array $userData): array
    {
        $result = [];
        if (isset($userData['name'])) {
            $name = $userData['name'];
            if (empty($name)) {
                $result['name'] = 'Поле Username не может быть пустым';
            }
            if (strlen($name) < 2) {
                $result['name'] = 'Поле Username должно быть не менее двух символов';
            }

        } else {
            $result['name'] = 'Поле Username не заполнено';
        }

        if (isset($userData['email'])) {
            $email = $userData['email'];
            if (empty($email)) {
                $result['email'] = 'Поле E-mail не может быть пустым';
            }
            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                $result['email'] = 'Email некорректен';
            }

            $emailData = $this->userRepository->getByEmail($userData['email']);
            if (!empty($emailData)) {
                $result['email'] = 'Пользователь с таким email уже существует';

            }
        } else {
            $result['email'] = 'Поле E-mail не заполнено';
        }

        if (isset($userData['password'])) {
            $password = $userData["password"];
            if (empty($password)) {
                $result['password'] = 'Поле Password не может быть пустым';
            }
            if (strlen($password) < 3 or strlen($password) > 15) {
                $result['password'] = 'Пароль должен состоять не менее чем из 3 символов и не более чем из 15';
            }
        } else {
            $result['password'] = 'Поле Password не заполнено';
        }

        if ($userData['password'] !== $userData['confirm-password']) {
            $result['confirm-password'] = 'Пароли не совпадают';
        }
        return $result;
    }

    public function login()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->authenticateService->authenticate($email, $password);

            if ($user !== null) {
                header('Location: /main');
            } else {
                echo 'Неверный логин или пароль';
            }

        }

        require_once './Views/login.html';
    }

    public function logout()
    {
        $this->authenticateService->logout();
    }
}
