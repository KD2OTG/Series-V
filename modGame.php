<?php
require_once 'commands/bulletin.php';
require_once 'commands/score.php';
require_once 'objects/player.php';


function getFooterText() {
// Return the footer text, being certain it accounts for logged-in vs. non logged-in players
// and is formatted for 80 characters in width
// Jun 2022 | Matt Robb
//
	$result = isGameActive();
	$gameStart = $result["gameStart"];
	$gameEnd = $result["gameEnd"];
	$isActive = $result["isActive"];

	if (!isset($_SESSION['alias'])) {
		$var =  "&nbsp;NOT CONNECTED&nbsp;|";																			// 16 chars
		$var .= str_repeat("&nbsp;",46) . "|";																		// 47 chars
		$var .= "&nbsp;" . str_repeat("&nbsp;",15) . "&nbsp;";  								  // 17 chars
	} else {
		$var =  "&nbsp;&nbsp;&nbsp;CONNECTED&nbsp;&nbsp;&nbsp;|";									// 16 chars
		// Vary footer text depending on whether game is underway or not...
		if ($isActive == true) {
			$var .="&nbsp;GAME ENDS: " . strtoupper(gmdate('D. M d H:i', $gameEnd)) . " UTC";			// 33 chars
			$var .= str_repeat("&nbsp;",13) . "|";																  // 14 chars
			$var .= "&nbsp;SCORE:&nbsp;" . str_pad(getPlayerScore($_SESSION['playerID']),8," ") . "&nbsp;"; // 17 char
		} else {
			$var .= "&nbsp;NO GAME IN PROGRESS" . str_repeat("&nbsp;",6);						// 26 chars
			$var .= str_repeat("&nbsp;",20) . "|";																	// 21 chars
			$var .= str_repeat("&nbsp;",17);																				// 17 char
		}
	}
	return $var;
}



function getStatusBar() {
// Return the status bar, building the details from session variables
// Feb 2017 | Matt Robb
//

	$_SESSION['turns'] = getPlayerDailyTurns($_SESSION['playerID']);
	$_SESSION['fuel'] = getShipFuelPercent($_SESSION['shipID']);
	$_SESSION['torp'] = getShipTorpCount($_SESSION['shipID']);
	$_SESSION['cargoPercent'] = getShipCargoPercent($_SESSION['shipID']);

         $var = '[DT: ' . $_SESSION['turns'] . ']-[FUEL: ' . round($_SESSION['fuel']) . '%]-[TORP: ' . intval($_SESSION['torp']) . ']-[CARGO: ' . intval($_SESSION['cargoPercent']) . '%]-';
	$var = $var . '[SECTOR: ' . $_SESSION['xloc'] . '.' . $_SESSION['yloc'] . '.' . $_SESSION['zloc'] . ']';
	return $var;
}



function getLoginWelcome() {
// Return the welcome message once a user logs into system
// Feb 2017 | Matt Robb
//

	$result = isGameActive();
	$description = $result["description"];
	$gameStart = $result["gameStart"];
	$gameEnd = $result["gameEnd"];
	$isActive = $result["isActive"];

	if ($isActive == 1) {
		$var =  'Now connected to the game.<br>';
		$var .= "Welcome, <a class='direction'>" . $_SESSION['alias'] . "</a>.<br><br>";
		$var .= bulletin() . "<br><br>";

		// If player performed less than 10 actions that generated points, they
		// are a new player, so show them the synopsis.
		if (getPlayerPointRows($_SESSION['playerID']) < 10) {
			$var .= getSynopsis();
		}

		$var .= "You have up to <a class='direction'>" . $_SESSION['turns'] . " </a>Daily Turns (DT) remaining to play today.<br><br>";
		$var .= "Awaiting input of your first command to begin:<br>";
		$var .= "- Enter <a class='input'>.</a> to monitor Daily Turns (DT), Fuel, Cargo, Torpedo levels, etc.<br>";
		$var .= "- Then try <a class='input'>HELP</a> to learn more gameplay commands.<br><br><br>";
	} else {

		// Not active, and current date/time is after the  game date/time, then this is a past game
		if (($isActive == 0) && (time() > $gameStart)) {
			$gameDesc .= "Thanks for playing a " . $description . "<br><br>";
			$gameDesc .= "<a class='prompt'>* The game ran " . gmdate('D. M d H:i', $gameStart) . " – " . gmdate('D. M d H:i', $gameEnd) . " UTC</a><br>";
			$gameDesc .= "<a class='prompt'>* You'll be notified by email when the next game is scheduled to run</a><br>";
			$gameDesc .= "<a class='prompt'>* Close your browser or issue any command to disconnect</a><br><br>";
			$var = $gameDesc . getGameWinnerList();
		}

		// Not active, and current date/time is before the game date/time, then this a planned future game
		if (($isActive == 0) && (time() < $gameStart)) {
			$gameDesc  = "<aRENDERclass='direction'>Upcoming game is scheduled. Come back once it begins.<br>";
			$gameDesc .= "* A " . $description . "<br>";
			$gameDesc .= "* Runs " . gmdate('D. M d H:i', $gameStart) . " – " . gmdate('D. M d H:i', $gameEnd) . " UTC<br>";
			$gameDesc .= "* Close your browser or issue any command to disconnect</a><br><br>";
			$var = $gameDesc;
		}
	}
	return $var;
}



function getPlayerPointRows($player_id) {
// Return the player point rows. This determines
// whether the synopsis/getting started is shown upon login
// Jun 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT COUNT(player_points_id) AS rowCount FROM player_points WHERE player_id = $player_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var = $row["rowCount"];
		}
	}
	dbDisconnect();
	return $var;
}



function getPlayerScore($player_id) {
// Return the player score
// Jun 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT SUM(points) AS pts FROM player_points WHERE player_id = $player_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var = $row["pts"];
		}
	}
	dbDisconnect();
	return $var;
}



function getSynopsis() {
// Return the game synopsis
// Jul 2022 | Matt Robb
//

	$var  = "+| You're new ... getting started |+-------------------------------------------<br><br>";
	$var .= "<a class='prompt'>&nbsp;&nbsp;&nbsp;\"Welcome to Brunnelian outpost </a><a class='object'>Station-14</a><a class='prompt'>,\"";
	$var .= " said Saharg.</a><br>";
	$var .= "<a class='prompt'>\"I'm sorry to hear what's currently happening on your home planet Earth.  But I trust you'll make a new life for yourself somewhere out here.\"</a><br><br>";

	$var .= "<a class='prompt'>&nbsp;&nbsp;&nbsp;The large, black eyes of the thin grey alien's face blinked slowly.</a><br><br>";

	$var .= "<a class='prompt'>&nbsp;&nbsp;&nbsp;\"Let's see...\" Saharg continued. \"I've assigned you with a Series-V mining vessel named </a><a class='object'>" . getPlayerShipName($_SESSION['shipID'])  . "</a>";
	$var .= "<a class='prompt'>. And let me stop you right now. No, you can't rename it. It's between 600-800 years old. It has history, but I assure you it's sturdy. You Earthlings and your traditions...\"</a><br><br>";

	$var .= "<a class='prompt'>&nbsp;&nbsp;&nbsp;Saharg outstretched his spindly fingers and tapped on the counter.</a><br><br>";

  $var .= "<a class='prompt'>&nbsp;&nbsp;&nbsp;\"</a><a class='object'>" . getPlayerShipName($_SESSION['shipID'])  . "</a><a class='prompt'> is easy to pilot. It was designed for operation by low-intelligence beings like you. </a>";
	$var .= "<a class='prompt'>All you need to do is </a>GO [LEFT, RIGHT, etc.]<a class='prompt'> between sectors, </a>TORP <a class='object'>asteroid</a><a class='prompt'>,</a> GET <a class='object'>composite</a><a class='prompt'>, and then come back here and </a>";
	$var .= "PROBE <a class='object'>Station-14</a><a class='prompt'> or </a>PROBE <a class='object'>barge</a><a class='prompt'> to automatically resupply and unload composite.\"</a><br><br>";

	$var .= "<a class='prompt'>&nbsp;&nbsp;&nbsp;\"One more thing.  Be careful. Many years have passed since my species' last attempt at clearing the asteroids from this sector. Make your own map. This is uncharted territory.\"</a><br><br>";
	$var .= "# # #<br><br>";

	return $var;
}



function formatUIOutput($output) {
// Return the output formatted for the UI
// Mar 2017 | Matt Robb
	global $input;
	// This commented out on 11-Apr-22; it is likely no longer needed
	// $input = obscurePassword($input);
	$var = '<a class="prompt">' . PROMPT . $input . '</a><br>' . $output . '<br><br>';
	return $var;
}



function isGameActive() {
// Determine whether there is an active game in progress
// Jun 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM app_game ORDER BY app_game_id DESC LIMIT 1";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$description = $row["description"];
			$gameStart = $row["gameStart"];
			$gameEnd = $row["gameEnd"];
		}
	}
	dbDisconnect();

	if ((time() > strtotime($gameStart)) && (time()) < strtotime($gameEnd)) {
		return array(
			'description' => $description,
			'gameStart' => strtotime($gameStart),
			'gameEnd' => strtotime($gameEnd),
			'isActive' => true
		);
		// return "yes";
	} else {
		return array(
			'description' => $description,
			'gameStart' => strtotime($gameStart),
			'gameEnd' => strtotime($gameEnd),
			'isActive' => false
		);
	}
}



?>
