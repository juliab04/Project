<?php
session_start();
if (isset($_SESSION['user_id'])) {
    $pdo = new PDO("pgsql:host = db, dbname=dbname", "dbuser", "dbpwd");
    $statement = $pdo->query('select * from products');
    $products = $statement->fetchAll();


    require_once './html/main.phtml';
}

http_response_code(403);
