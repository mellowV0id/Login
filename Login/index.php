<?php

include_once('Database/Database.php');
include_once('Authentication/User.php');
include_once('Authentication/Authentication.php');

header("Location: http://localhost/index.html");

$connect = new Database();
$authenticate = new Authentication($connect);

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    die();
}
if (empty($_POST['username']) || (empty($_POST['password']))) {
    die();
}

$user = new User($_POST['username'], $_POST['password']);

if ($authenticate->login($user)) {
    header("Location: http://localhost/welcome.html");
    die();
}

header("Location: http://localhost/loginFailed.html");

