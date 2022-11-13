<?php

    if(!isset($_POST['delete'])) {
        header("location: ../../../statstracker.php#player-content");
        exit();
    }    

    session_start();
    require_once "../../functions/statstracker-functions.php";
    require_once "../../database/db-handler.php";

     //create response object
    $serverRes = (object) ['errorMessage'=> false, 'success'=> false];


    $deleteButtonValue = $_POST['delete'];
    $teamID = $_SESSION['teamID'];
    $playerAndPosition = explode("1", $deleteButtonValue);
    if (!isset($playerAndPosition[1])) {
        $serverRes->errorMessage = "Player not deleted";
        $playerName = null;
        $position = null;
    } else{
        $playerName = trim($playerAndPosition[0]);
        $position = trim($playerAndPosition[1]);
    }
    $playerID = getPlayerId($conn, $teamID, $position, $playerName);
    if ($playerID === false ) {
        $serverRes->errorMessage = "Player not deleted";
    } else{
        deletePlayer($conn, $playerID);
        $serverRes->success = "player is deleted";
    }
    echo json_encode($serverRes);