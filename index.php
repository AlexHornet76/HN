<?php
require_once "config/routes.php";
require_once "config/pdo.php"; 

session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$router = new Router();
$router->direct();

?>