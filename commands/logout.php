<?php
// Log the player out of the game
// Must ensure "require_once 'commands/logout.php';" is added to the "loadCommands.php" file
// Mar 2017 | Matt Robb
//



function logout($command = "", $parameter = "") {
// Log the user out of the game
// Mar 2017 | Matt Robb
//
	// If not loggged-in (Visitor)
	if (!isset($_SESSION['alias'])) {
		$var = '"' . $command . '" is an invalid command.  Please try again.';
		return $var;
	}
		// If logged-in (Player)
	else {
		// remove all session variables and destroy the session
		session_unset();
		session_destroy();
		$var = 'You have logged out of the game.<br><br><script>window.location.href = "index.php";</script>';
		return $var;
	}
}



?>
