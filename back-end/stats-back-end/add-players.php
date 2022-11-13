<?php
    if(!(isset($_POST["add-keeper"]) || isset($_POST["add-defender"]) || isset($_POST["add-midfielder"]) || isset($_POST["add-attacker"]))) {
        header("location: ../../statstracker.php#player-content");
        exit();
    }
    
    require_once '../database/db-handler.php';
    require_once '../functions/statstracker-functions.php';
    session_start();
    
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
        header("location: ../../statstracker.php#player-content");
        $_SESSION[$positionGroup] = "make sure goals, assists and games are numbers!";
        exit();
    }
    
    if(emptyInputaddPlayer($playerName, $position, $playedGames, $goals, $assists) !== false) {
        header("location: ../../statstracker.php#player-content");
        $_SESSION[$positionGroup] = "fill in all inputs!";
        exit();
    }
    
    if(invalidName($playerName) !== false) {
        header("location: ../../statstracker.php#player-content");
        $_SESSION[$positionGroup] = "Invalid player name!";
        exit();
    }
    
    if(invalidName($position) !== false) {
        header("location: ../../statstracker.php#player-content");
        $_SESSION[$positionGroup] = "Invalid position name!";
        exit();
    }
    
    if(negativeNumber($playedGames, $goals, $assists) !== false) {
        header("location: ../../statstracker.php#player-content");
        $_SESSION[$positionGroup] = "stats must be postive numbers!";
        exit();
    }
    if(playerInDatabase($conn, $currentTeamID, $playerName, $position) !== false) {
        header("location: ../../statstracker.php#player-content");
        $_SESSION[$positionGroup] = "Player already exist!";
        exit();
    }
    

    addPlayer($conn, $currentTeamID, $playerName, $positionGroup, $position, $playedGames, $goals, $assists);
    $_SESSION[$positionGroup] = "player created!";
    header("location: ../../statstracker.php#player-content");