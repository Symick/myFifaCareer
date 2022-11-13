<?php
function emptyInputSignup($name, $username, $email, $password, $repeatPassword)
{
    if (
        empty($name) ||
        empty($username) ||
        empty($email) ||
        empty($password) ||
        empty($repeatPassword)
    ) {
        $error = true;
    } else {
        $error = false;
    }
    return $error;
}

function invalidUsername($username)
{
    if (!preg_match('/^[\p{L}0-9_]*$/u', $username)) {
        $error = true;
    } else {
        $error = false;
    }
    return $error;
}

function invalidName($name)
{
    if (!preg_match('/^[\p{L}\' ]*$/u', $name)) {
        $error = true;
    } else {
        $error = false;
    }
    return $error;
}
function invalidEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
    } else {
        $error = false;
    }
    return $error;
}
function invalidPassword($password)
{
    if (!preg_match('/^[a-zA-Z0-9!@#$%^&*?.,+_-]*$/', $password)) {
        $error = 'wrong symbol';
    } elseif (strlen($password) < 8) {
        $error = 'short';
    } elseif (!preg_match('/[a-z]+/', $password)) {
        $error = 'lower';
    } elseif (!preg_match('/[A-Z]+/', $password)) {
        $error = 'upper';
    } elseif (!preg_match('/[0-9]+/', $password)) {
        $error = 'number';
    } elseif (!preg_match('/[!@#$%^&*?.,+_-]+/', $password)) {
        $error = 'symbol';
    } else {
        $error = false;
    }
    return $error;
}

function passwordMatch($password, $repeatPassword)
{
    if (!($password === $repeatPassword)) {
        $error = true;
    } else {
        $error = false;
    }
    return $error;
}

function usernameInDatabase($conn, $username)
{
    $sql = 'SELECT * FROM users WHERE username = ?;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../sign-up.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);

    $resultQuery = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultQuery)) {
        return $row;
    } else {
        return false;
    }
    mysqli_stmt_close($stmt);
}

function emailInDatabase($conn, $email)
{
    $sql = 'SELECT * FROM users Where email = ?;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../sign-up.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $resultQuery = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultQuery)) {
        return $row;
    } else {
        $error = false;
        return $error;
    }
    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $username, $email, $password)
{
    $sql = 'INSERT INTO users (fullname, username, email, usersPassword) VALUES(?, ?, ?, ?);';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../sign-up.php?error=stmtfailed');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, 'ssss', $name, $username,$email, $hashedPassword);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return 'success';
}

function emptyInputLogin($username, $password)
{
    if (empty($username) || empty($password)) {
        $error = true;
    } else {
        $error = false;
    }
    return $error;
}

function loginUser($conn, $username, $password)
{
    $usernameInDatabase = usernameInDatabase($conn, $username);
    $emailInDatabase = emailInDatabase($conn, $username);

    if ($usernameInDatabase === false && $emailInDatabase === false) {
        unset($_SESSION['userID']);
        unset($_SESSION['username']);
        return 'username';
    }
    if ($usernameInDatabase !== false) {
        $_SESSION['userID'] = $usernameInDatabase['usersID'];
        $_SESSION['username'] = $usernameInDatabase['username'];
        $hashedPassword = $usernameInDatabase['usersPassword'];
    }
    if ($emailInDatabase !== false) {
        $_SESSION['userID'] = $emailInDatabase['usersID'];
        $_SESSION['username'] = $emailInDatabase['username'];
        $hashedPassword = $emailInDatabase['usersPassword'];
    }

    $passwordCheck = password_verify($password, $hashedPassword);
    if ($passwordCheck === false) {
        unset($_SESSION['userID']);
        unset($_SESSION['username']);
        $error = 'password';
        return $error;
    } else {
        return 'success';
    }
}
