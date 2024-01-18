<?php

session_start();

$_SESSION['user_login'] = 'Login';
$_SESSION['user_id'] = '123';
$_SESSION['user_password'] = 'password';
$_SESSION['user_email'] = 'email';

require '../php/User.php';

$user = User::getSessionUser();

var_dump($user);

session_destroy();