<?php

include_once('Database/Database.php');
include_once('Authentication/User.php');
include_once('Authentication/Authentication.php');


session_start();

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

$user = new User($userName, $password);
$id   = $authenticate->login($user);

if ($id) {
    $_SESSION['userid'] = $id;
    header("Location: http://localhost/Login/welcome.html");
    die();
}

header("Location: http://localhost/Login/loginFailed.html");

