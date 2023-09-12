<?php
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $pdo = new PDO("pgsql:host = db, dbname=dbname", "dbuser", "dbpwd");
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->rowCount() > 0) {
        $result =$stmt->fetch();
        if (password_verify($password, $result['password'])) {
            session_start();
            $_SESSION['user_id'] = $result['id'];
        }

        header('Location: /main');
    } else {
        echo 'Неверный логин или пароль';
    }


}

require_once './html/login.html';
