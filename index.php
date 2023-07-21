<?php
// This file represents the game UI window.
//
// JQuery is used to monitor text input by the player into the 'txtInput' textarea,
// via the 'script.js' file, posts the submitted data to 'processCommand.php' which
// then updates the database and ultimately returns and appends text back to the player
// into the 'txtOutput' text area.
//
// 06-Feb-2019 | Matt Robb
//
	session_start();
	require_once 'modDatabase.php';
	require_once 'modGlobalConstants.php';
	require_once 'modGame.php';

	$server_ip = gethostbyname($_SERVER['SERVER_NAME']);

	$result = isGameActive();
	$description = $result["description"];
	$gameStart = $result["gameStart"];
	$gameEnd = $result["gameEnd"];
	$isActive = $result["isActive"];
	if ($isActive == 1) {
		$isActive = "Yes";
		$gameDesc  = "<aRENDERclass='prompt'>Game in progress. LOGIN to join.<br>";
		$gameDesc .= "* A " . $description . "<br>";
		$gameDesc .= "* Runs " . gmdate('D. M d H:i', $gameStart) . " – " . gmdate('D. M d H:i', $gameEnd) . " UTC</a><br><br>";
	} else {
		// Not active, and current date/time is after the  game date/time, then this is a past game
		if (($isActive == 0) && (time() > $gameStart)) {
			$isActive = "No";
			$gameDesc  = "<aRENDERclass='object'>Recent game complete.<br>";
			$gameDesc .= "* LOGIN to review winner ranking.<br>";
			$gameDesc .= "* ENROLL to be notified by email about next game.</a><br><br>";
			// $gameDesc .= "Time: " . time() . "<br>";
			// $gameDesc .= "gameStart: " . $gameStart . "<br>";
		}

		// Not active, and current date/time is before the game date/time, then this a planned future game
		if (($isActive == 0) && (time() < $gameStart)) {
			$isActive = "No";
			$gameDesc  = "<aRENDERclass='direction'>Upcoming game scheduled. LOGIN to join.<br>";
			$gameDesc .= "* A " . $description . "<br>";
			$gameDesc .= "* Runs " . gmdate('D. M d H:i', $gameStart) . " – " . gmdate('D. M d H:i', $gameEnd) . " UTC</a><br><br>";
			// $gameDesc .= "Time: " . time() . "<br>";
			// $gameDesc .= "gameStart: " . $gameStart . "<br>";
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo GAMENAME; ?>: A game of space exploration</title>
		<meta name="description" content"A free, multi-player strategy game of space exploration">
		<meta name="keywords" content"BBS, terminal, game, DOS, door, mystic, synchronet, wwiv, wildcat">
		<meta name="author" content"Copyright (c) 2022 Matt Robb. All rights reserved.">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="script.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type="text/css">
		<link rel="icon" type="image/x-icon" href="/favicon.ico">
</head>
<body>



  <!-- Master Bootstrap Container -->
  <div class="container-fluid">



    <!-- Master Bootstrap Grid Row #1 of #2 -->
    <div class="row">
      <div class="col-md" id="txtOutput" contenteditable="false" spellcheck="false">

        <?php if (!isset($_SESSION['alias'])) {
					$var = "";
					$var .= GAMENAME . ": A multi-player strategy game of space exploration<br>";
          $var .= COPYRIGHT . "<br><br>";
					$var .= $gameDesc;
          $var .= "Available commands for non- logged in players:<br><br>";
          $var .= "?                         	    <em>See HELP</em><br>";
          $var .= "ABOUT                          Displays instructions and synopsis of the game<br>";
          $var .= "ENROLL                         Enroll a new account to play the game<br>";
          $var .= "FORGOT                         Reset a forgotten password<br>";
          $var .= "HELP                           Displays this help screen<br>";
          $var .= "LOGIN                          Prompts for credentials to log into the game<br>";
					$var .= "TERMS                          Displays Terms, Conditions, and Policies<br><br><br>";
          $var = str_replace(" ","&nbsp;",$var);	// Corrects the situation where browser ignores more than one space character
					$var = str_replace("RENDER"," ",$var);	// Corrects the situation where browser ignores more than one space character
					echo $var;
        }
        else {
          echo getLoginWelcome();
        }
        ?>

      </div>
    </div>



    <!-- Master Bootstrap Grid Row #2 of #2 -->
    <div class="row fixed-row-bottom">
			<div class="col-md">

        <form id="message" action="">
          <textarea name="txtPrompt" id="txtPrompt" rows="1" contenteditable="false" spellcheck="false" disabled="disabled" readonly="readonly">>></textarea>
          <textarea name="txtInput" id="txtInput" autofocus rows="1" spellcheck="false" maxlength="128"></textarea>
        </form>

        <?php if (!isset($_SESSION['alias'])) {
					echo "<div id='txtFooter' spellcheck='false'>" . getFooterText() . "</div>";
       	} else {
				 	echo "<div id='txtFooter' spellcheck='false'>" . getFooterText() . "</div>";
        }
        ?>

      </div>
    </div>



  </div>



  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
