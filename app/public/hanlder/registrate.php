<?php
if (!empty($_POST)) {
    $errors = validate($_POST);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (empty($errors)) {
        $pdo = new PDO("pgsql:host = db, dbname=dbname", "dbuser", "dbpwd");
        $password = password_hash($password, PASSWORD_DEFAULT);

        $statement = $pdo->prepare("insert into users(name, email, password) values (:name, :email, :password)");
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
}
function validate(array $userData)
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
        $pdo = new PDO("pgsql:host = db, dbname=dbname", "dbuser", "dbpwd");
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
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
require_once './html/registrate.phtml';
