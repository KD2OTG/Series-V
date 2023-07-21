<?php
// Functions that are scheduled to run in the Ionos -> Hosting -> Cron jobs
// feature.  At present, these functions are run once daily at midnight.
// May 2022 | Matt Robb
//
require_once 'modDatabase.php';



// If the current time is greater than 24-hours...
if ((time() - getDailyTurnsLastUpdatedDate()) > 86400) {
	resetDailyTurns();
} else {
	echo "Current server time: " . time();
}



function getDailyTurns() {
// Get the daily turns for the latest, active game
// Jun 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT dailyTurns FROM app_game ORDER BY app_game_id DESC LIMIT 1";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$dailyTurns = $row["dailyTurns"];
		}
	} else {
			// Assume the default of 500 if no active game is returned
			$dailyTurns = 500;
	}
	dbDisconnect();
	return $dailyTurns;
}



function getDailyTurnsLastUpdatedDate() {
// Get the daily turns value [dailyTurnsLastUpdated] for the latest, active game
// Jul 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT dailyTurnsLastUpdated FROM app_game ORDER BY app_game_id DESC LIMIT 1";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$dailyTurnsLastUpdated = $row["dailyTurnsLastUpdated"];
		}
	} else {
			// Assume a date in the past if no value returned
			$dailyTurnsLastUpdated = "2022-01-01 00:00:00";
	}
	dbDisconnect();
	return $dailyTurnsLastUpdated;
}



function resetDailyTurns() {
// Reset daily turns for all players
// May 2022 | Matt Robb
//
	global $db_server;

	$dailyTurns = getDailyTurns();

	// Update player turns...
	dbConnect();
	$query = "UPDATE player SET turns = $dailyTurns";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();

	// Update game daily turns last updated time stamp; curdate() will set date with zeroes for minutes...
	dbConnect();
	$query = "UPDATE app_game SET dailyTurnsLastUpdated = curdate()";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();

}



?>
