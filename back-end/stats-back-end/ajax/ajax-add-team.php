<?php
session_start();
if (!isset($_POST['add-team'])) {
    header('location: ../../../statstracker.php');
    exit();
}

require_once '../../database/db-handler.php';
require_once '../../functions/statstracker-functions.php';

$teamName = ucwords(trim($_POST['team-name']));
$currentUserID = $_SESSION['userID'];
$serverRes = (object) ['errorMessage' => false, 'success' => false];
if (!isset($_SESSION['fifa'])) {
    $serverRes->errorMessage = "Choose a Fifa version!";
    echo json_encode($serverRes);
    exit();
} else {
    $currentFifaVersion = $_SESSION['fifa'];
}

if (emptyInputAddTeam($teamName) !== false) {
    $serverRes->errorMessage = "Fill in a team Name!";
}

if (invalidTeamName($teamName) !== false) {
    $serverRes->errorMessage = "Invalid team name";
}

if (teamNameInDatabase($conn, $currentUserID, $currentFifaVersion, $teamName) !== false) {
    $serverRes->errorMessage = "You already have this team!";
}

if($serverRes->errorMessage === false) {
    createTeam($conn, $currentUserID, $currentFifaVersion, $teamName);
    $serverRes->errorMessage = "<span class=\"success-text\">team created!</span>";
    $serverRes->success = "<input type=\"radio\" name=\"team\" id=\"$teamName\" value=\"$teamName\" onchange=\"this.form.submit()\">
                            <label for=\"$teamName\"> $teamName</label>
                            <button type=\"submit\" name=\"remove-team\" class=\"remove-team-btn\" value=\"$teamName\"> 
                            <i class=\"far fa-times-circle\"></i>
                            </button>";
}

// send the errormessage to javascript via json
echo json_encode($serverRes);