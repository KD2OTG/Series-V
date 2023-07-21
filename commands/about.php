<?php
// Return About Game text to the player when the command ABOUT is entered
// Must ensure "require_once 'commands/about.php';" is added to the "loadCommands.php" file
// Mar 2017 | Matt Robb
//



function about($param = 'ABOUT') {
// Return About Game text to the player when the command ABOUT is entered
// Mar 2017 | Matt Robb
//
	$var = getAboutContent($param);
	return $var;
}



function getAboutContent($command) {
// Return the "content" field from "help" table per the command value parameter
// String pre-sanitized on "processCommand.php" page
// Mar 2017 | Matt Robb
//
	global $db_server;

	dbConnect();
	if ($command == "") {
		$query = "SELECT * FROM app_help WHERE command = 'ABOUT'";
	} else {
		$query = "SELECT * FROM app_help WHERE command = '" . $command . "'";
	}
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var = $row["content"];
		}
	} else {
		$var = null;
	}
	dbDisconnect();
	return $var;
}



?>
