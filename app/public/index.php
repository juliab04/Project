<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/registrate') {
    require_once './hanlder/registrate.php';
} elseif ($uri === '/login') {
require_once './hanlder/login.php';
} elseif ($uri === '/main') {
    require_once './hanlder/main.php';
} elseif ($uri === '/logout') {
    session_start();
    session_destroy();
} else {
    require_once './html/404.html';
}




?>

