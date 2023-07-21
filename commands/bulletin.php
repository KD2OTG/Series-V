<?php
// Return Bulletin text to the player when the command BULLETIN is entered
// Must ensure "require_once 'commands/bulletin.php';" is added to the "loadCommands.php" file
// Mar 2017 | Matt Robb
//



function bulletin($command = 'BULLETIN') {
// Return Bulletin text to the player when the command BULLETIN is entered
// Feb 2019 | Matt Robb
//
	// If not loggged-in (Visitor)
	if (!isset($_SESSION['alias'])) {
		$var = '"' . $command . '" is an invalid command.  Please try again.';
		return $var;
	}
	else {
		$var = getLastLoginsList();
		return $var;
	}
}



function getLastLoginsList() {
// Return the "content" field from "app_help" table per the command value parameter
// String pre-sanitized on "processCommand.php" page
// Mar 2017 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT p.alias, i.proper_name, l.location, l.datetimestamp FROM player_logins l, player p, item i WHERE p.player_id = l.player_id AND p.item_id = i.item_id ORDER BY l.login_id DESC LIMIT 10";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$cnt = 1;
	$var =        "+| Last ten player logins |+---------------------------------------------------"."<br><br>";
	$var = $var . "NO  PLAYER           SHIP             STATE / COUNTRY                    DATE  "."<br>";
	$var = $var . "--  ---------------  ---------------  ---------------------------------  ------";
	while ($row = mysqli_fetch_assoc($result)) {
		$new_datetime = DateTime::createFromFormat ( "Y-m-d H:i:s", $row["datetimestamp"] );
		// $var = $var . "<br>" . str_pad($cnt,2," ",STR_PAD_LEFT) . "  " . str_pad($row["alias"],27," ") . str_pad($row["location"],25," ") . "  " . str_pad($new_datetime->format('M-d g:ia'),14," ");
		$var = $var . "<br>" . str_pad($cnt,2," ",STR_PAD_LEFT) . "  <aRENDERclass='direction'>" . str_pad($row["alias"],15," ") . "</a>  <aRENDERclass='object'>" . str_pad($row["proper_name"],15," ") . "</a>  ";
		$var = $var . substr(str_pad($row["location"],33," "),0,33) . "  " . str_pad($new_datetime->format('M d'),7," ");
		$cnt++;
	}
	dbDisconnect();
	$var = str_replace(" ","&nbsp;",$var);	// Corrects the situation where browser ignores more than one space character
	$var = str_replace("RENDER"," ",$var);	// Corrects the situation where browser ignores more than one space character
	return $var;
}



?>
