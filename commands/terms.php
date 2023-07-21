<?php
// Return Terms and Conditions text to the player when the command TERMS is entered
// Must ensure "require_once 'commands/terms.php';" is added to the "loadCommands.php" file
// Jul 2022 | Matt Robb
//



function terms($param = 'TERMS') {
// Return Terms and Conditions text to the player when the command TERMS is entered
// Jul 2022 | Matt Robb
//
	$var = getTermsContent($param);
	return $var;
}



function getTermsContent($command) {
// Return the "content" field from "help" table per the command value parameter
// String pre-sanitized on "processCommand.php" page
// Jul 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	if ($command == "") {
		$query = "SELECT * FROM app_help WHERE command = 'TERMS'";
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
