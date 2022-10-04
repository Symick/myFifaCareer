<?php
session_start();
if (!isset($_POST['add-team'])) {
    header('location: ../../statstracker.php');
    exit();
}

require_once '../database/db-handler.php';
require_once '../functions/statstracker-functions.php';

$teamName = ucwords(trim($_POST['team-name']));
$currentUserID = $_SESSION['userID'];

if (!isset($_SESSION['fifa'])) {
    header('location: ../../statstracker.php#sidebar');
    $_SESSION['error'] = "Choose a Fifa version!";
    exit();
} else {
    $currentFifaVersion = $_SESSION['fifa'];
}

if (emptyInputAddTeam($teamName) !== false) {
    header('location: ../../statstracker.php#sidebar');
    $_SESSION['error'] = "Fill in a team Name!";
    exit();
}

if (invalidTeamName($teamName) !== false) {
    header('location: ../../statstracker.php#sidebar');
    $_SESSION['error'] = "Invalid team name";
    exit();
}

if (teamNameInDatabase($conn, $currentUserID, $currentFifaVersion, $teamName) !== false) {
    header('location: ../../statstracker.php#sidebar');
    $_SESSION['error'] = "You already have this team!";
    exit();
}

createTeam($conn, $currentUserID, $currentFifaVersion, $teamName);
header('location: ../../statstracker.php#sidebar');
    $_SESSION['created'] = "$teamName is added!";
exit();
