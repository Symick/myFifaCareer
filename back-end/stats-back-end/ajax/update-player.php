 <?php  
    if(!isset($_POST['update'])) {
        header("location: ../../../statstracker.php");
        exit();
    }
    session_start();
    require_once "../../functions/statstracker-functions.php";
    require_once "../../database/db-handler.php";
    
    //create response object
    $assocArray = ['errorMessage' => false, 'success' => false];
    $serverRes = (object) $assocArray;

    //get values
    $updateButtonValue = $_POST['update'];
    $teamID = $_SESSION['teamID'];
    $playerAndPosition = explode("1", $updateButtonValue);
    if (!isset($playerAndPosition[1])) {
        $serverRes->errorMessage = "player not Updated, something went wrong!";
        $playerName = null;
        $position = null;
    } else{
        $playerName = trim($playerAndPosition[0]);
        $position = trim($playerAndPosition[1]);
    }
    $playerID = getPlayerId($conn, $teamID, $position, $playerName);
    if($playerID === false) {
        $serverRes->errorMessage = "player not Updated, player not in database";
    }
    $playedGames = convertToValidInt(trim($_POST["games-played"]));
    $positionGroup = $_POST['position-group'];
    if($positionGroup !== "keeper") {
        $goals = convertToValidInt(trim($_POST['goals']));
        $assists = convertToValidInt(trim($_POST['assists']));
    }
    else {
        $goals = 0;
        $assists = 0;
    }
    
   

    if(negativeNumber($playedGames, $goals, $assists) !== false) {
        $serverRes->errorMessage = "stats must be a positive numbers!";
    }
    if($playedGames === 'NaN'|| $goals === 'NaN' || $assists === 'NaN') {
        $serverRes->errorMessage = "make sure goals, assists and games are numbers!";
    }
    if($serverRes->errorMessage === false) {
        updatePlayer($conn, $playerID, $playedGames, $goals, $assists);
        $serverRes->success = (object)['positionGroup' => $positionGroup, 'playedGames' => $playedGames, 'goals' => $goals, 'assists' => $assists];
    }
    echo json_encode($serverRes);
