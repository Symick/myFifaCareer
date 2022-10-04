<?php
require_once '../../database/db-handler.php';
require_once '../../functions/statstracker-functions.php';
session_start();
    if(!(isset($_POST["add-keeper"]) || isset($_POST["add-defender"]) || isset($_POST["add-midfielder"]) || isset($_POST["add-attacker"]))) {
        // header("location: ../../../statstracker.php#player-content");
        // exit();
    }
    $serverRes = (object) ['errorMessage'=> false, 'success'=> false];
    $errorArray = [];
    $currentTeamID = $_SESSION['teamID'];
    $playerName = ucwords(trim($_POST["player-name"]));
    $playedGames = convertToValidInt(trim($_POST["played-games"]));
    
    if(!isset($_POST["add-keeper"])) {
        $position = ucwords(trim($_POST["position"]));
        $goals = convertToValidInt(trim($_POST["goals"]));
        $assists = convertToValidInt(trim($_POST["assists"]));
    }
    else { 
        $positionGroup = "keeper";
        $position = "keeper";
        $goals = 0;
        $assists =  0;
    }
        //set the position-group
    if(isset($_POST["add-defender"])) {
        $positionGroup = "defender";
    }
    if(isset($_POST["add-midfielder"])) {
        $positionGroup = "midfielder";
    }
    if(isset($_POST["add-attacker"])) {
        $positionGroup = "attacker";
    }
   
    //give error when number inputs are not numbers, i.e strings
    if($playedGames === 'NaN'|| $goals === 'NaN' || $assists === 'NaN') {
        array_push($errorArray, "make sure goals. assists and games are numbers!");
    }
    
    if(emptyInputAddPlayer($playerName, $position, $playedGames, $goals, $assists) !== false) {
       array_push($errorArray, "make sure all inputs are filled in!");
    }
    
    if(invalidName($playerName) !== false) {
     array_push($errorArray, "invalid player name!");
    }
    
    if(invalidName($position) !== false) {
      array_push($errorArray, "Invalid position name!");
    }
    
    if(negativeNumber($playedGames, $goals, $assists) !== false) {
       array_push($errorArray, "Stats must be positive numbers!");
    }
    if(playerInDatabase($conn, $currentTeamID, $playerName, $position) !== false) {
        array_push($errorArray, "Player already exists!");
    }
    if(!empty($errorArray)) {
        $serverRes->errorMessage = $errorArray;
    }
    
    if($serverRes->errorMessage === false) {
        addPlayer($conn, $currentTeamID, $playerName, $positionGroup, $position, $playedGames, $goals, $assists);
        $serverRes->errorMessage = "player created!";
        if($positionGroup === "keeper") {
            $serverRes->success = " <h3 class=\"player-name\">{$playerName}:</h3>
                                    <h4 class=\"position-title\">{$position}</h4>
                                    <div class=\"input-container\">
                                        <Label for=\"games-played\"> Games played </label>
                                        <input type=\"number\" name=\"games-played\" value=\"{$playedGames}\" data-player=\"{$playerName}\" required disabled>
                                    </div>
                                    <input type=\"hidden\" name=\"position-group\" value=\"keeper\">
                                    <button type=\"submit\" name=\"update\" value=\"{$playerName} 1 {$position}\" class=\"btn save-btn \"> 
                                        Update!
                                    </button>   
                                    <button type=\"button\" class=\"btn update-btn\" data-player=\"{$playerName}\"> 
                                        Update player
                                    </button>
                                    <button type=\"submit\" name=\"delete\" value=\"{$playerName} 1 {$position}\" class=\"btn delete-btn\"> 
                                        Delete player
                                    </button>";
        }
        else {
            $serverRes->success = " <h3 class=\"player-name\">{$playerName}:</h3>
                                    <h4 class=\"position-title\">{$position}</h4>
                                    <div class=\"input-container\">
                                        <Label for=\"games-played\"> Games played </label>
                                        <input type=\"number\" name=\"games-played\" value=\"{$playedGames}\" data-player=\"{$playerName}\" required disabled>
                                    </div>
                                    <div class=\"input-container\">
                                        <Label for=\"goals\">Goals</label>
                                        <input type=\"number\" name=\"goals\" value=\"{$goals}\" data-player=\"{$playerName}\" required disabled>
                                    </div>
                                    <div class=\"input-container\">
                                        <Label for=\"assists\">Assists</label>
                                        <input type=\"number\" name=\"assists\" value=\"{$assists}\" data-player=\"{$playerName}\" required disabled>
                                    </div>
                                    <input type=\"hidden\" name=\"position-group\" value=\"defender\">
                                    <button type=\"submit\" name=\"update\" value=\"{$playerName} 1 {$position}\" class=\"btn save-btn \"> 
                                        Update!
                                    </button>   
                                    <button type=\"button\" class=\"btn update-btn\" data-player=\"{$playerName}\"> 
                                        Update player
                                    </button>
                                    <button type=\"submit\" name=\"delete\" value=\"{$playerName} 1 {$position}\" class=\"btn delete-btn\"> 
                                        Delete player
                                    </button>";
        }
    }
    echo json_encode($serverRes);