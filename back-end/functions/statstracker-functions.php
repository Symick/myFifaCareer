<?php
function emptyInputAddTeam($teamName)
{
    if (empty($teamName)) {
        $error = true;
    } else {
        $error = false;
    }
    return $error;
}
function invalidTeamname($teamName)
{
    if (!preg_match('/^[\p{L}0-9. ]*$/u', $teamName)) {
        $error = true;
    } else {
        $error = false;
    }
    return $error;
}
function teamNameInDatabase($conn, $userID, $fifaVersion, $teamname) {
   $sql = 'SELECT * FROM teams WHERE usersID = ? AND fifaVersion = ? AND teamName = ?;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../sign-up.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'iss', $userID, $fifaVersion, $teamname);
    mysqli_stmt_execute($stmt);

    $resultQuery = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultQuery)) {
       return $row;
    } else {
        $error = false;
        return $error;
     }
    mysqli_stmt_close($stmt);
}
function createTeam($conn, $userId, $fifaVersion, $teamName) {
    $sql = 'INSERT INTO teams (usersID, fifaVersion, teamName) VALUES (?, ?, ?);'; 
    $stmt =  mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../statstracker.php?error=stmtfailed2');
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'iss', $userId, $fifaVersion, $teamName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function getTeamNames($conn, $usersID, $fifaVersion) {
    $sql = 'SELECT teamName FROM teams WHERE usersID = ? AND fifaVersion= ? ORDER BY teamName ASC ;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../statstracker.php?error=stmtfailed2');
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'is', $usersID, $fifaVersion);
    mysqli_stmt_execute($stmt);
    
    $resultQuery = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($resultQuery)) {
        $rows[] = $row['teamName'];
    }
    if (empty($rows)) {
        return false;
    } else {
        return $rows;
    }
  
    mysqli_stmt_close($stmt);
}

function getTeamID($conn, $userID, $fifaVersion, $teamname) {
    $team = teamNameInDatabase($conn, $userID, $fifaVersion, $teamname);
    return $team['teamID'];
}
function deleteTeam($conn, $teamID) {
    $sql = 'DELETE FROM teams WHERE teamID = ?;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../statstracker.php?error=stmtfailed');
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'i', $teamID);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt);  
}
function convertToValidInt($integer) {
    if(is_numeric($integer)) {
        $integer = (int)$integer;
    }
    else {
        return 'NaN';
    }
    return $integer;
}
function negativeNumber($playedGames, $goals, $assists) {
    if($goals < 0 || $playedGames < 0 || $assists < 0) {
        $error = true;
    }
    else {
        $error = false;
    }
    return $error;
}


function invalidName($name)
{
    if (!preg_match('/^[\p{L}\' ]*$/u', $name)) {
        $error = true;
    } else {
        $error = false;
    }
    return $error;
}

function emptyInputAddPlayer($playerName, $position, $playedGames, $goals, $assists) {
    if (empty($playerName) || empty($position) || !is_numeric($playedGames) || !is_numeric($goals) || !is_numeric($assists)) {
        $error = true;
    } else {
        $error = false;
    }
    return $error;
}

function addPlayer($conn, $teamID, $playerName, $positionGroup, $position, $gamesPlayed, $goals, $assists) {
    $sql = "INSERT INTO players (teamID, playerName, positionGroup, position, gamesPlayed, goals, assists) 
    VALUES(?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../statstracker.php?error=stmtfailed2');
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'isssiii', $teamID, $playerName, $positionGroup, 
                           $position, $gamesPlayed, $goals, $assists);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

}
function playerInDatabase($conn, $teamID, $playerName, $position) {
    $sql = 'SELECT * FROM players WHERE teamID = ? AND playerName = ? AND position = ?;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../sign-up.php?error=stmtfailed');
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'iss', $teamID, $playerName, $position);
    mysqli_stmt_execute($stmt);

    $resultQuery = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultQuery)) {
       return $row;
    } else {
        $error = false;
        return $error;
     }
    mysqli_stmt_close($stmt);

}

function getPlayerData($conn, $teamID, $positionGroup) {
    $sql = 'SELECT * FROM players WHERE teamID = ? AND positionGroup = ? ORDER BY position ASC;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../statstracker.php?error=stmtfailed2');
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'is', $teamID, $positionGroup);
    mysqli_stmt_execute($stmt);
    
    $resultQuery = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($resultQuery)) {
        $rows[] = $row;
    }
    if (empty($rows)) {
        return false;
    } else {
        return $rows;
    }
  
    mysqli_stmt_close($stmt);
}
function getPlayerId($conn, $teamID, $position, $playerName) {
    $player = playerInDatabase($conn, $teamID, $playerName, $position);
    if ($player === false) {
        return false;
    }
    return $player['playerID'];
}
function updatePlayer($conn, $playerID, $gamesPlayed, $goals, $assists) {
    $sql = 'UPDATE players SET gamesPlayed = ?, goals = ?, assists = ?  WHERE playerID = ?;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../statstracker.php?error=stmtfailed');
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'iiii',$gamesPlayed, $goals, $assists, $playerID);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt); 
}

function deletePlayer($conn, $playerID) { 
    $sql = 'DELETE FROM players WHERE playerID = ?;';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header('location: ../../statstracker.php?error=stmtfailed');
        exit();
    }
    mysqli_stmt_bind_param($stmt, 'i', $playerID);
    mysqli_stmt_execute($stmt); 
    mysqli_stmt_close($stmt); 
}
