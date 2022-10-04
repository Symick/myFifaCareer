<?php 
    if(!(isset($_POST['delete']) || isset($_POST['update']))) {
        header("location: ../../statstracker.php#player-content");
        exit();
    }
    session_start();
    require_once "../functions/statstracker-functions.php";
    require_once "../database/db-handler.php";

    /* i used 1 as a seperator between name and position because a name can have spaces in it.
     the 1 makes sure the value is split into the name and the player, 1 could have been any number or symbol
    */
    if(isset($_POST['delete'])) {
        $deleteButtonValue = $_POST['delete'];
        $teamID = $_SESSION['teamID'];
        $playerAndPosition = explode("1", $deleteButtonValue);
        $playerName = trim($playerAndPosition[0]);
        $position = trim($playerAndPosition[1]);
        $playerID = getPlayerId($conn, $teamID, $position, $playerName);
        deletePlayer($conn, $playerID);
        header("location: ../../statstracker.php#");
    }
    if(isset($_POST['update'])) {
        $updateButtonValue = $_POST['update'];
        $teamID = $_SESSION['teamID'];
        $playerAndPosition = explode("1", $updateButtonValue);
        $playerName = trim($playerAndPosition[0]);
        $position = trim($playerAndPosition[1]);
        $playerID = getPlayerId($conn, $teamID, $position, $playerName);
        $playedGames = convertToValidInt(trim($_POST["games-played"]));
        $goals = convertToValidInt(trim($_POST['goals'])) ?? 0;
        $assists = convertToValidInt(trim($_POST['assists'])) ?? 0;
        $positionGroup = $_POST['position-group'];

        if(negativeNumber($playedGames, $goals, $assists) !== false) {
        header("location: ../../statstracker.php#player-content");
        $_SESSION[$positionGroup] = "stats must be postive numbers!";
        exit();
        }
        if($playedGames === 'NaN'|| $goals === 'NaN' || $assists === 'NaN') {
        header("location: ../../statstracker.php#player-content");
        $_SESSION[$positionGroup] = "make sure goals, assists and games are numbers!";
        exit();
        }
        updatePlayer($conn, $playerID, $playedGames, $goals, $assists);
        header("location: ../../statstracker.php#{$playerName}");
    }

     