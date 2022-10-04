<?php

    if(!isset($_POST['delete'])) {
        header("location: ../../../statstracker.php#player-content");
        exit();
    }    

    session_start();
    require_once "../../functions/statstracker-functions.php";
    require_once "../../database/db-handler.php";
    $deleteButtonValue = $_POST['delete'];
    $teamID = $_SESSION['teamID'];
    $playerAndPosition = explode("1", $deleteButtonValue);
    if (!isset($playerAndPosition[1])) {
        echo "player not deleted!";
        exit();
    } else{
        $playerName = trim($playerAndPosition[0]);
        $position = trim($playerAndPosition[1]);
    }
    $playerID = getPlayerId($conn, $teamID, $position, $playerName);
    if ($playerID === false ) {
        echo "player not deleted";
        exit();
    }
    deletePlayer($conn, $playerID);
    echo "player is deleted";