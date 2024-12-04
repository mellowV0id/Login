<?php

include_once('Database/Database.php');
include_once('Authentication/User.php');
include_once('Authentication/Authentication.php');

header("Location: http://localhost/index.html");

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

$user = new User($username, $password);

if ($authenticate->login($user)) {
    header("Location: http://localhost/welcome.html");
    die();
}

header("Location: http://localhost/loginFailed.html");

