<?php
session_start();
include_once('Database/Database.php');
include_once('Authentication/User.php');
include_once('Authentication/Authentication.php');

$connect      = new Database();
$authenticate = new Authentication($connect);

$userName = $_POST['username'];
$password = $_POST['password'];

if (!isset($userName,$password)) {
    die();
}

if (empty($_POST['username']) || (empty($_POST['password']))) {
    die();
}

$user     = new User($userName, $password);
$userData = $authenticate->login($user);

$id = $userData['id'] ?? 0;

$_SESSION['current_balance'] = $userData['balance'];

if ($id) {
    $_SESSION['userid'] = $id;
    header("Location: http://localhost/Login/welcome.php");
} else {
    header("Location: http://localhost/Login/loginFailed.html");
}


