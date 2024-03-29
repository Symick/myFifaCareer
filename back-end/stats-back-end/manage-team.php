<?php 
    if (!isset($_POST['remove-team']) && !isset($_POST['team'])) {
        header('location: ../../statstracker.php]');
        exit();
    }
    session_start();
    require_once '../database/db-handler.php';
    require_once '../functions/statstracker-functions.php';
 
    //delete team
    if (isset($_POST['remove-team'])) {
        //get team name off the item to remove
        $teamName = $_POST['remove-team'];
        $currentFifaVersion = $_SESSION['fifa'];
        $currentUserID = $_SESSION['userID'];
        $toRemove = getTeamID($conn, $currentUserID, $currentFifaVersion, $teamName);
        if($toRemove !== false) {
            deleteTeam($conn, $toRemove);
            
            if(isset($_SESSION['teamName']) && $teamName == $_SESSION['teamName']) {
                unset($_SESSION['teamName']);
            }
            header('location: ../../statstracker.php#sidebar');
            $_SESSION['error'] = "<span class=\"success-text\">{$teamName} has been deleted!</span>";
            exit();
        }
        $_SESSION['error'] = "team not deleted";
        header("location: ../../statstracker.php#sidebar");
        exit();
    }
    
    //change team
    if (isset($_POST['team'])) {
        $currentFifaVersion = $_SESSION['fifa'];
        $currentUserID = $_SESSION['userID'];
        $teamName = $_POST['team'];
        $teamID = getTeamID($conn, $currentUserID, $currentFifaVersion, $teamName);
        if($teamID !== false){
            $_SESSION['teamName'] = $teamName;
            $_SESSION['teamID'] = $teamID;
        }
        else {
            $_SESSION['error'] = "Team does not exist";
        }
        header('location: ../../statstracker.php#sidebar');
        exit();
    }







