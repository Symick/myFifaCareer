<?php
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "myfifacareer";

$conn = mysqli_connect($servername, $dbUsername, $dbPassword, $dbName);

if(!$conn) {
    die("failed to connect to the server, sorry for the inconvenience: " . mysqli_connect_error());
}