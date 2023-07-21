<?php
// Display the status bar and current objects in sector to re-orient player
// Must ensure "require_once 'commands/_period.php';" is added to the "loadCommands.php" file
// Feb 2019 | Matt Robb
//



function _period() {
// Display the status bar and current objects in sector to re-orient player
// Feb 2019 | Matt Robb
//
	// If not loggged-in (Visitor)
	if (!isset($_SESSION['alias'])) {
		$var = '"." is an invalid command.  Please try again.';
		return $var;
	}
	// If logged-in (Player)
	else {
		// Get and return objects in the sector
		$objects = getSectorObjects($_SESSION['sector_id']);

		$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
		$var = '<a class="statusbar">' . $statusbar . '</a><br>';
		$var = $var . "Billions of distant stars and galaxies are observed from the ship's bridge.<br>";
		$var = $var . $objects;

		return $var;
	}
}



?>
