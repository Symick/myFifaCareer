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
$errorArray = [];
if (!isset($_SESSION['fifa'])) {
    array_push($errorArray, "Choose a Fifa version!");
} else {
    $currentFifaVersion = $_SESSION['fifa'];
}

if (emptyInputAddTeam($teamName) !== false) {
    array_push($errorArray,"Fill in a team Name!");
}

if (invalidTeamName($teamName) !== false) {
    array_push($errorArray,"Invalid team name");
}

if (teamNameInDatabase($conn, $currentUserID, $currentFifaVersion, $teamName) !== false) {
    array_push($errorArray,"You already have this team!");
}
if(!empty($errorArray)) {
    $serverRes->errorMessage = $errorArray;
}
if($serverRes->errorMessage === false) {
    // createTeam($conn, $currentUserID, $currentFifaVersion, $teamName);
    $serverRes->errorMessage = "<span class=\"success-text\"> team created! </span>";
    $serverRes->success = "<input type=\"radio\" name=\"team\" id=\"$teamName\" value=\"$teamName\" onchange=\"this.form.submit()\">
                            <label for=\"$teamName\"> $teamName</label>
                            <button type=\"submit\" name=\"remove-team\" class=\"remove-team-btn\" value=\"$teamName\"> 
                            <i class=\"far fa-times-circle\"></i>
                            </button>";
}

// send the errormessage to javascript via json
echo json_encode($serverRes);