<?php

include_once('../Database/Database.php');
include_once('../Authentication/User.php');
include_once('../Authentication/Authentication.php');
include_once('ATM.php');

session_start();

$connection = new Database();
$operations = new ATM($connection);
$operations->updateGlobalBalance();
$userid     = $_POST['transferMoney'];
$amount     = $_POST['amount'];
$operation  = $_POST['operation'];

if(empty($amount)) {
    die();
}

if($operation == 'withdraw') {
    $operations->withdraw($amount);
}

if($operation == 'deposit') {
    $operations->deposit($amount);
}

if(!empty($userid) && $operation == 'transfer') {
    $operations->transfer($amount, $userid);
}

$id = $userData['id'] ?? 0;

header("Location: http://localhost/Login/welcome.php");

