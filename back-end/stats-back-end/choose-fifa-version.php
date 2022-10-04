<?php 
    session_start();
    if (!isset($_POST['fifa'])) {
        header("location: ../../index.php");
        exit();    }
    $_SESSION['fifa'] = $_POST['fifa'];
    unset($_SESSION['teamName']);
    unset($_SESSION['teamID']);
    header("location: ../../statstracker.php#show-fifa-bar");
    