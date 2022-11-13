<?php
    if (!isset($_POST['remove-team'])) {
        header('location: ../../../statstracker.php]');
        exit();
    }
    session_start();
    require_once '../../database/db-handler.php';
    require_once '../../functions/statstracker-functions.php';
    $serverRes = (object) ['errorMessage' => false, 'success' => false];
    if (isset($_POST['remove-team'])) {
        //get team name off the item to remove
        $teamName = $_POST['remove-team'];
        $currentFifaVersion = $_SESSION['fifa'];
        $currentUserID = $_SESSION['userID'];
        $toRemove = getTeamID($conn, $currentUserID, $currentFifaVersion, $teamName);
        if($toRemove !== false) {
            // deleteTeam($conn, $toRemove);
            
            //make sure that if the team was selected when it was deleted, the session of the team is terminated
            if(isset($_SESSION['teamName']) && $teamName == $_SESSION['teamName']) {
                unset($_SESSION['teamName']);
            }
            header('location: ../../statstracker.php#sidebar');
            $serverRes->success = "{$teamName} has been deleted!";
        }
        else {
            $serverRes->errorMessage = "Team not deleted!";
        }
    }
    echo json_encode($serverRes);