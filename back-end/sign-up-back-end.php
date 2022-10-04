<?php 
    if(!isset($_POST["sign-up-submit"])) { 
        header("location: ../sign-up.php");
        exit();
    }
    
    session_start();

    $name = ucwords(trim($_POST["name"]));
    $username =trim($_POST["username"]);
    $email = trim($_POST["email"]);    
    $password = trim($_POST["password"]);
    $repeatPassword = trim($_POST["repeat-password"]);
    
    require_once 'database/db-handler.php';
    require_once 'functions/functions.php';
    
    if (emptyInputSignup($name, $username, $email, $password, $repeatPassword) !== false) {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "Fill in all inputs!";
        exit();
    }

    if (invalidName($name) !== false) {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "Your name is invalid!";
        exit();          
    }

    if (invalidUsername($username) !== false) {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "Your username is invalid!";
        exit();          
    }

    if (invalidEmail($email) !== false) {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "your email is invalid!";
        exit();  
    }
    
    if (invalidPassword($password) === 'wrong symbol') {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "You have used the wrong symbol! <br>
        Please use on of these Symbols: <br> ! @ # $ % ^ & * ? . , + _ -";
        exit();  
    }
    if (invalidPassword($password) === 'short') {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "Your password should be at least 8 characters long!";
        exit();
    }
    if (invalidPassword($password) === 'lower') {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "Your password should contain atleast one lowercase letter!";
        exit();  
    }
    if (invalidPassword($password) === 'upper') {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "Your password should contain atleast one uppercase letter!";
        exit();  
    }
    if (invalidPassword($password) === 'number') {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "Your password should contain atleast one number!";
        exit();  
    }
    if (invalidPassword($password) === 'symbol') {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "Your password should contain atleast one symbol!";
        exit();  
    }

    if (invalidPassword($password) !== false) {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "there was an unexpected error!";
        exit();  
    }

    if (passwordMatch($password, $repeatPassword) !== false) {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "Passwords don't match!";
        exit();  
    }
    
    if (usernameInDatabase($conn, $username) !== false) {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "Username is already taken!";
        exit();  
    }
    
    if (emailInDatabase($conn, $email) !== false) {
        header("location: ../sign-up.php");
        $_SESSION['error'] = "You have already created an account on this email address!";
        exit();  
    }

   if (createUser($conn, $name, $username, $email, $password) === 'succes'){
        $_SESSION['created'] = "Succes! <br> Your account is created!";
        header("location: ../sign-up.php");
        exit();
   }




   