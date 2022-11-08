<?php
include 'back-end/database/db-handler.php';
include 'back-end/functions/statstracker-functions.php';
session_start();
if (!isset($_SESSION['userID'])) {
    header('location: ./index.php');
    exit();
}
$currentUserID = $_SESSION['userID'];
if (isset($_SESSION['fifa'])) {
    $currentFifaVersion = $_SESSION['fifa'];
}
if(isset($_SESSION['teamName'])) {
    $currentTeamName = $_SESSION['teamName'];
    $currentTeamID = $_SESSION['teamID'];
}
?>

<!DOCTYPE html>
<html lang="en" id="top-window">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/reset.css" />
    
    <!-- Download font-families, montserrat and comfortaa -->
    <link
      href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,400;0,700;1,400&display=swap"
      rel="stylesheet"
    />
    <!-- get Font-awesome -->
    <script src="https://kit.fontawesome.com/045f11e82e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles/style.css" />
    <noscript>
        <link rel="stylesheet" href="styles/noscript.css">
    </noscript>
    <link rel="icon" href="img/logo.png" />

    <!-- scripts -->
    <script src="scripts/logo-spinner.js" defer></script>
    <script src="scripts/show-menus.js" defer></script>
    <script src="scripts/show-player-form.js " defer></script>
    <script src="scripts/ajax-calls.js" defer></script>

    <title>My Fifa Career</title>
  </head>
  <body>
    <header class="header">
      <!-- div left is made to make sure logo stays in the middle with flexbox -->
      <div class="left" data-always-visible="true">
          <div class="hamburger-menu">
            <span class="hamburger-menu--icon"></span>
          </div>
      </div>
      <div class="logo">
        <a href="#top-window">
            <img src="img/logo.png" alt="Logo MyFIFAcareer" data-always-visible="false"/>
        </a>
      </div>
      <nav class="nav-menu" data-nav-page="statstracker">
        <ul>
          <li>
            <a href="#" id="chooseYourFifa">
                <span class="nav-link-text">
                    <?php
                        if(!isset($currentFifaVersion)) {
                            echo "choose your fifa";
                        } else {
                            echo $currentFifaVersion;
                        }
                        
                    ?>
                </span>
                <i class="fa-solid fa-caret-down"></i>
            </a>
          </li>
          <li> 
            <a href="back-end/logout.php"> 
                <i class="fas fa-sign-out-alt"></i> 
                <span class="logout-text">Logout!</span>
            </a>
          </li>
        </ul>
      </nav>
    </header>
    <div class="fifa-bar">
        <form action="back-end/stats-back-end/choose-fifa-version.php" method="post" class="fifa-version-form">
            <input type="radio" name="fifa" id="fifa17" value="fifa 17" onchange="this.form.submit();"
            <?php if (isset($currentFifaVersion)) {
                if ($currentFifaVersion == 'fifa 17') {
                    echo 'checked="checked"';
                }
            } ?>>
            <label for="fifa17"> fifa 17</label>               
            
            <input type="radio" name="fifa" id="fifa18" value="fifa 18" onchange="this.form.submit();"
            <?php if (isset($currentFifaVersion)) {
                if ($currentFifaVersion == 'fifa 18') {
                    echo 'checked="checked"';
                }
            } ?>> 
            <label for="fifa18"> fifa 18</label>
            
            <input type="radio" name="fifa" id="fifa19" value="fifa 19" onchange="this.form.submit();"
            <?php if (isset($currentFifaVersion)) {
                if ($currentFifaVersion == 'fifa 19') {
                    echo 'checked="checked"';
                }
            } ?>> 
            <label for="fifa19"> fifa 19</label>

            <input type="radio" name="fifa" id="fifa20" value="fifa 20" onchange="this.form.submit();"
            <?php if (isset($currentFifaVersion)) {
                if ($currentFifaVersion == 'fifa 20') {
                    echo 'checked="checked"';
                }
            } ?>> 
            <label for="fifa20"> fifa 20</label>

            <input type="radio" name="fifa" id="fifa21" value="fifa 21" onchange="this.form.submit();"
            <?php if (isset($currentFifaVersion)) {
                if ($currentFifaVersion == 'fifa 21') {
                    echo 'checked="checked"';
                }
            } ?>> 
            <label for="fifa21"> fifa 21</label>

            <input type="radio" name="fifa" id="fifa22" value="fifa 22" onchange="this.form.submit();"
            <?php if (isset($currentFifaVersion)) {
                if ($currentFifaVersion == 'fifa 22') {
                    echo 'checked="checked"';
                }
            } ?>> 
            <label for="fifa22"> fifa 22</label>
            <input type="radio" name="fifa" id="fifa23" value="fifa 23" onchange="this.form.submit();"
            <?php if (isset($currentFifaVersion)) {
                if ($currentFifaVersion == 'fifa 23') {
                    echo 'checked="checked"';
                }
            } ?>> 
            <label for="fifa23"> fifa 23</label>
        </form>
    </div>
    <aside class="sidebar">
        <form action="back-end/stats-back-end/manage-team.php" method="post" class="select-team-form" >
            <h2 class="sidebar--title">Choose your team:</h2>
            <div class="teams-container">
                <?Php
                if (isset($currentFifaVersion)){
                    if (getTeamNames($conn, $currentUserID, $currentFifaVersion) === false) {
                        echo '<p>create your team below</p>';
                    }
                    else {
                        $teamNames = getTeamNames($conn, $currentUserID, $currentFifaVersion);
                        foreach($teamNames as $teamName) {
                            echo "<input type=\"radio\" name=\"team\" id=\"$teamName\" value=\"$teamName\" onchange=\"this.form.submit()\"";
                            if (isset($_SESSION['teamName']) && $teamName == $_SESSION['teamName']) {
                                echo "checked=\"checked\"";
                            }
                            echo ">";
                            echo "<label for=\"$teamName\"> $teamName</label>";
                            echo "<button type=\"submit\" name=\"remove-team\" class=\"remove-team-btn\" value=\"$teamName\"> 
                            <i class=\"far fa-times-circle\"></i>
                            </button>";
                        }
                    }
                }
                ?>
            </div>
     
        </form>
        <form action="back-end/stats-back-end/add-team.php" method="post">
            <label for="team-name">team name</label>
            <input type="text" name="team-name" id="team-name" required>
            <button type="submit" name="add-team" class="btn add-team-btn">Add your team</button>
            <div class="error-display"> 
              <?php
              if (isset($_SESSION['error'])) {
                  echo $_SESSION['error'];
                  unset($_SESSION['error']);
              }
              if (isset($_SESSION['created'])) {
                  echo $_SESSION['created'];
                  unset($_SESSION['created']);
              }
              ?>
        </div>
        </form>
    </aside>
    <main>
        <section class="hero">
            <h1 class="title tacker-title">Track your FIFA stats!</h1>
        </section>
        
        <div class="wrapper" id="player-content">
            <?php
                if(!isset($currentFifaVersion) || !isset($currentTeamName)) {
                    echo "<section class=\"no-player-add\">
                            <h2 class=\"title alt-title\"> choose a fifaversion and team</h2>
                            </section>  
                    ";
                }
            ?>
            <section class="main-player-display">
                <h2 class="title main-player-display--title">
                    <?php
                        echo $currentTeamName; 
                    ?>
                </h2>
                <div class="player-display">
                    <h2 class="position-group">Keepers</h2>
                    <div class="players-container">
                        <?php
                            $playersinfo = getPlayerData($conn, $currentTeamID, "keeper");
                            if (!empty($playersinfo)) {
                                foreach ($playersinfo as $playerinfo) {
                                    //get individual sets of data
                                    $playerName = $playerinfo['playerName'];
                                    $position = $playerinfo['position'];
                                    $playedGames = $playerinfo['gamesPlayed'];

                            
                                    //display data
                                    echo "<form action=\"back-end/stats-back-end/manage-players.php\" method=\"post\" class=\"manage-players-form\">
                                            <h3 class=\"player-name\">{$playerName}:</h3>
                                            <h4 class=\"position-title\">{$position}</h4>
                                            <div class=\"input-container\">
                                                <Label for=\"games-played\"> Games played </label>
                                                <input type=\"number\" name=\"games-played\" value=\"{$playedGames}\" data-player=\"{$playerName}\" required disabled>
                                            </div>
                                            <input type=\"hidden\" name=\"position-group\" data-player=\"{$playerName}\" value=\"keeper\">
                                            <button type=\"submit\" name=\"update\" value=\"{$playerName} 1 {$position}\" class=\"btn save-btn \"> 
                                                Update!
                                            </button>   
                                            <button type=\"button\" class=\"btn update-btn\" data-player=\"{$playerName}\"> 
                                                Update player
                                            </button>
                                            <button type=\"submit\" name=\"delete\" value=\"{$playerName} 1 {$position}\" class=\"btn delete-btn\"> 
                                                Delete player
                                            </button>                                        
                                        </form>";
                                }
                            }   
                        ?>
                        <form action="back-end/stats-back-end/add-players.php" method="post" class="create-form keeper-form">
                            <h3>Name</h3>
                            <h3>Games played</h3>
                            <input type="text" name="player-name" required autocomplete="off">
                            <input type="number" name="played-games" required>
                            <button type="submit" name="add-keeper" class="btn add-player-btn">Create keeper</button>
                        </form>
                        <button type="button" class="btn show-form-btn">Add keeper</button>
                    </div>
                    <div class="error-display"> 
                            <?php
                            if (isset($_SESSION['keeper'])) { 
                                echo $_SESSION['keeper'];
                                unset($_SESSION['keeper']);
                            }

                            ?>
                    </div>
                </div>
                <div class="player-display">
                    <h2 class="position-group">Defenders</h2>
                    <div class="players-container">
                        <?php
                            $playersinfo = getPlayerData($conn, $currentTeamID, "defender");
                            if (!empty($playersinfo)) {
                                foreach ($playersinfo as $playerinfo) {
                                    //get individual sets of data
                                    $playerName = $playerinfo['playerName'];
                                    $position = $playerinfo['position'];
                                    $playedGames = $playerinfo['gamesPlayed'];
                                    $goals = $playerinfo['goals'];
                                    $assists = $playerinfo['assists'];
                            
                                    //display data
                                    echo "<form action=\"back-end/stats-back-end/manage-players.php\" method=\"post\" class=\"manage-players-form\">
                                            <h3 class=\"player-name\">{$playerName}:</h3>
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
                                            <input type=\"hidden\" name=\"position-group\" data-player=\"{$playerName}\" value=\"defender\">
                                            <button type=\"submit\" name=\"update\" value=\"{$playerName} 1 {$position}\" class=\"btn save-btn \"> 
                                                Update!
                                            </button>   
                                            <button type=\"button\" class=\"btn update-btn\" data-player=\"{$playerName}\"> 
                                                Update player
                                            </button>
                                            <button type=\"submit\" name=\"delete\" value=\"{$playerName} 1 {$position}\" class=\"btn delete-btn\"> 
                                                Delete player
                                            </button>                                        
                                        </form>";
                                }
                            }   
                        ?>
                        <form action="back-end/stats-back-end/add-players.php" method="post" class="create-form">
                            <h3>Position</h3>
                            <h3>Name</h3>
                            <h3>Games played</h3>
                            <h3>Goals</h3>
                            <h3>Assists</h3>
                            <input type="text" list="defenders" name="position" required autocomplete="off">
                            <input type="text" name="player-name" required autocomplete="off">
                            <input type="number" name="played-games" required>
                            <input type="number" name="goals" required>
                            <input  type="number" name="assists" required>
                            <button type="submit" name="add-defender" class="btn add-player-btn">Create defender</button>
                        </form>
                        <button type="button" class="btn show-form-btn">Add defender</button>
                    </div>
                    <div class="error-display"> 
                        <?php
                        if (isset($_SESSION['defender'])) { 
                            echo $_SESSION['defender'];
                            unset($_SESSION['defender']);
                        }

                        ?>
                    </div>
                </div>
                <div class="player-display">
                    <h2 class="position-group">Midfielders</h2>
                    <div class="players-container">
                        <?php
                            $playersinfo = getPlayerData($conn, $currentTeamID, "midfielder");
                            if (!empty($playersinfo)) {
                                foreach ($playersinfo as $playerinfo) {
                                    //get individual sets of data
                                    $playerName = $playerinfo['playerName'];
                                    $position = $playerinfo['position'];
                                    $playedGames = $playerinfo['gamesPlayed'];
                                    $goals = $playerinfo['goals'];
                                    $assists = $playerinfo['assists'];
                            
                                    //display data
                                    echo "<form action=\"back-end/stats-back-end/manage-players.php\" method=\"post\" class=\"manage-players-form\">
                                            <h3 class=\"player-name\">{$playerName}:</h3>
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
                                            <input type=\"hidden\" name=\"position-group\" data-player=\"{$playerName}\" value=\"midfielder\">
                                            <button type=\"submit\" name=\"update\" value=\"{$playerName} 1 {$position}\" class=\"btn save-btn \"> 
                                                Update!
                                            </button>   
                                            <button type=\"button\" class=\"btn update-btn\" data-player=\"{$playerName}\"> 
                                                Update player
                                            </button>
                                            <button type=\"submit\" name=\"delete\" value=\"{$playerName} 1 {$position}\" class=\"btn delete-btn\"> 
                                                Delete player
                                            </button>                                        
                                        </form>";
                                }
                            }   
                        ?>                        
                        <form action="back-end/stats-back-end/add-players.php" method="post" class="create-form">
                            <h3>Position</h3>
                            <h3>Name</h3>
                            <h3>Games played</h3>
                            <h3>Goals</h3>
                            <h3>Assists</h3>
                            <input type="text" list="midfielders" name="position" required autocomplete="off">
                            <input type="text" name="player-name" required autocomplete="off">
                            <input type="number" name="played-games" required>
                            <input type="number" name="goals" required>
                            <input type="number" name="assists" required>
                            <button type="submit" name="add-midfielder" class="btn add-player-btn">Create midfielder</button>
                        </form>
                        <button type="button" class="btn show-form-btn">Add midfielder</button>
                    </div>
                    <div class="error-display"> 
                        <?php
                        if (isset($_SESSION['midfielder'])) { 
                            echo $_SESSION['midfielder'];
                            unset($_SESSION['midfielder']);
                        }

                        ?>
                    </div>
                </div>
                <div class="player-display">
                    <h2 class="position-group">Attackers</h2>
                    <div class="players-container">
                        <?php
                            $playersinfo = getPlayerData($conn, $currentTeamID, "attacker");
                            if (!empty($playersinfo)) {
                                foreach ($playersinfo as $playerinfo) {
                                    //get individual sets of data
                                    $playerName = $playerinfo['playerName'];
                                    $position = $playerinfo['position'];
                                    $playedGames = $playerinfo['gamesPlayed'];
                                    $goals = $playerinfo['goals'];
                                    $assists = $playerinfo['assists'];
                            
                                    //display data
                                    echo "<form action=\"back-end/stats-back-end/manage-players.php\" method=\"post\" class=\"manage-players-form\">
                                            <h3 class=\"player-name\">{$playerName}:</h3>
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
                                            <input type=\"hidden\" name=\"position-group\" data-player=\"{$playerName}\" value=\"attacker\">
                                            <button type=\"submit\" name=\"update\" value=\"{$playerName} 1 {$position}\" class=\"btn save-btn \"> 
                                                Update!
                                            </button>   
                                            <button type=\"button\" class=\"btn update-btn\" data-player=\"{$playerName}\"> 
                                                Update player
                                            </button>
                                            <button type=\"submit\" name=\"delete\" value=\"{$playerName} 1 {$position}\" class=\"btn delete-btn\"> 
                                                Delete player
                                            </button>                                        
                                        </form>";
                                }
                            }   
                        ?>
                        <form action="back-end/stats-back-end/add-players.php" method="post" class="create-form">
                            <h3>Position</h3>
                            <h3>Name</h3>
                            <h3>Games played</h3>
                            <h3>Goals</h3>
                            <h3>Assists</h3>
                            <input type="text" list="attackers" name="position" required autocomplete="off">
                            <input type="text" name="player-name" required autocomplete="off">
                            <input type="number" name="played-games" required>
                            <input type="number" name="goals" required>
                            <input type="number" name="assists" required>
                            <button type="submit" name="add-attacker" class="btn add-player-btn">Create attacker</button>
                        </form>
                        <button type="button" class="btn show-form-btn">Add attacker</button>
                    </div>
                    <div class="error-display"> 
                        <?php
                        if (isset($_SESSION['attacker'])) { 
                            echo $_SESSION['attacker'];
                            unset($_SESSION['attacker']);
                        }
        
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- datalist for positions -->
    <datalist id="defenders">
        <option value="Left Back"></option>
        <option value="Center Back"></option>
        <option value="Right Back"></option>
        <option value="Left Wing Back"></option>
        <option value="Right Wing Back"></option>
    </datalist>
    <datalist id="midfielders">
        <option value="Center Defensive Midfielder"></option>
        <option value="Center Midfielder"></option>
        <option value="Center Attacking Midfielder"></option>
        <option value="Left Midfielder"></option>
        <option value="Right Midfielder"></option>
    </datalist>
    <datalist id="attackers">
        <option value="Striker"></option>
        <option value="Left Winger"></option>
        <option value="Right Winger"></option>
        <option value="Center Forward"></option>
        <option value="Left Forward"></option>
        <option value="Right Forward"></option>
    </datalist>
  </body>
</html>  