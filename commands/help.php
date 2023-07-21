<?php
// Return help text to the player when the command HELP is entered
// Must ensure "require_once 'commands/help.php';" is added to the "loadCommands.php" file
// Mar 2017 | Matt Robb
//



function help($param = 'HELP') {
// Return help text to the player when the command HELP is entered
// Mar 2017 | Matt Robb
//
	// If not loggged-in (Visitor)
	if (!isset($_SESSION['alias'])) {
		$var = getHelpContent("HELP_0");
	}
	// If logged-in (Player)
	else {
		$var = getHelpContent($param);
	}
	return $var;
}



function getHelpContent($command) {
// Return the "content" field from "help" table per the command value parameter
// String pre-sanitized on "processCommand.php" page
// Mar 2017 | Matt Robb
//
	global $db_server;

	dbConnect();
	if ($command == "") {
		$query = "SELECT * FROM app_help WHERE command = 'HELP'";
	}	else {
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
		$var = "No help file exists for this command.";
	}
	dbDisconnect();
	return $var;
}



?>
