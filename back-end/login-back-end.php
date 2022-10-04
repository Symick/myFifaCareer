<?php
if (!isset($_POST['login-submit'])) { 
    header("location: ../index.php#login");
    exit();
}
$username =  $_POST['username'];
$password = $_POST['password'];

session_start();

require_once 'database/db-handler.php';
require_once 'functions/functions.php';

if(emptyInputlogin($username, $password) !== false) {
    header("location: ../index.php#login");
    $_SESSION['error'] = "fill in all inputs!";
    exit();
}
if (loginUser($conn, $username, $password) === "username") {
    header("location: ../index.php#login");
    $_SESSION['error'] = "your username is incorrect!";
    exit();
}
if (loginUser($conn, $username, $password) === "password") {
    header("location: ../index.php#login");
    $_SESSION['error'] = "your password is incorrect!";
    exit();
}

if (loginUser($conn, $username, $password) === "succes") {
    header("location: ../statstracker.php");
    exit();
}


