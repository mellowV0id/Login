<?php

include_once('../Database/Database.php');
include_once('../Authentication/User.php');
include_once('../Authentication/Authentication.php');
include_once('ATM.php');

session_start();

$connection = new Database();
$operations = new ATM($connection);
$userid     = $_POST['transferMoney'];
$amount     = $_POST['amount'];
$operation  = $_POST['operation'];

if(empty($amount)) {
    die();
}
/**
 * TODO: operations need to update current_balance in session superglobal
 */
$_SESSION['current_balance'] = $operations->getBalance();

if($operation == 'withdraw') {
    $operations->withdraw($amount);
}

if($operation == 'deposit') {
    $operations->deposit($amount);
    die();
}

if(!isset($operation) || !isset($userid)) {
    die();
}

if(empty($userid)) {
    die();
}

$operations->transfer($amount, $userid);

$id = $userData['id'] ?? 0;

if ($id) {
    $_SESSION['userid'] = $id;
    header("Location: http://localhost/Login/welcome.php");
}
