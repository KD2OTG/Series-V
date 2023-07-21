<?php
// Return score details to the player when the command SCORE is entered
// Must ensure "require_once 'commands/score.php';" is added to the "loadCommands.php" file
// Jun 2022 | Matt Robb
//



function score($command = 'SCORE') {
// Return score details to the player when the command SCORE is entered
// Jun 2022 | Matt Robb
//
	// If not loggged-in (Visitor)
	if (!isset($_SESSION['alias'])) {
		$var = '"' . $command . '" is an invalid command.  Please try again.';
		return $var;
	}
	else {
		$var = getScore();
		return $var;
	}
}



function getScore() {
// Return the "content" field from "app_help" table per the command value parameter
// String pre-sanitized on "processCommand.php" page
// Jun 2022 | Matt Robb
//
	global $db_server;
	$id = $_SESSION['playerID'];

	dbConnect();
	$query =  "SELECT PT.point_type, PT.activity, SUM(PP.points) AS points FROM player_points PP, app_pointtype PT ";
	$query .= "WHERE PT.app_pointtype_id = PP.app_pointtype_id AND PP.player_id = $id GROUP BY PT.activity ORDER BY PT.point_type, points DESC";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$cnt = 1;
	$var =  "+| My Detailed Score |+--------------------------------------------------------"."<br><br>";
	$var .= "POINT TYPE           ACTIVITY                                            POINTS"."<br>";
	$var .= "-------------------- ------------------------------------------------  --------";
	while ($row = mysqli_fetch_assoc($result)) {
		$var .= "<br>" . str_pad($row["point_type"],19," ") . "  " . str_pad($row["activity"],48," ") . "  ";
		$var .= str_pad($row["points"],8," ",STR_PAD_LEFT);
		$cnt++;
	}
	dbDisconnect();

	dbConnect();
	$query = "SELECT SUM(PP.points) AS points FROM player_points PP WHERE PP.player_id = $id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$cnt = 1;
	$var .= "<br>                                                                       --------";
	while ($row = mysqli_fetch_assoc($result)) {
		$var = $var . "<br>" . str_repeat("&nbsp;",57) . "TOTAL SCORE:  ". str_pad($row["points"],8," ",STR_PAD_LEFT);
		$cnt++;
	}
	dbDisconnect();

	$var = str_replace(" ","&nbsp;",$var);	// Corrects the situation where browser ignores more than one space character
	return $var;
}



function getGameWinnerList() {
// Return the "content" field from "app_help" table per the command value parameter
// String pre-sanitized on "processCommand.php" page
// Jul 2022 | Matt Robb
//
	global $db_server;
	$id = $_SESSION['playerID'];

	dbConnect();
	$query =  "SELECT P.alias, I.proper_name, SUM(PP.points) as points FROM player_points PP, player P, item I, app_pointtype APT ";
	$query .= "WHERE PP.player_id = P.player_id AND P.item_id = I.item_id AND APT.app_pointtype_id = PP.app_pointtype_id GROUP BY PP.player_id ORDER BY points DESC";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$cnt = 1;
	      $var =  "+| Game Winner List |+---------------------------------------------------------"."<br><br>";
	$var = $var . "RANK  PLAYER           SHIP                SCORE"."<br>";
	$var = $var . "----  ---------------  ---------------  --------";
	while ($row = mysqli_fetch_assoc($result)) {

		$var = $var . "<br>" . str_pad($cnt,4," ",STR_PAD_RIGHT) . "  <aRENDERclass='direction'>" . str_pad($row["alias"],15," ") . "</a>  <aRENDERclass='object'>" . str_pad($row["proper_name"],15," ") . "</a>  ";
		$var = $var . str_pad($row["points"],8," ",STR_PAD_LEFT);
		$cnt++;
	}
	dbDisconnect();

	$var = str_replace(" ","&nbsp;",$var);	// Corrects the situation where browser ignores more than one space character
	$var = str_replace("RENDER"," ",$var);	// Corrects the situation where browser ignores more than one space character
	$var .= "<br><br>";
	return $var;
}



?>
