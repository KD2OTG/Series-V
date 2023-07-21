<?php
// Non user command. Forces a screen refresh of the current sector using jquery at interval defined in 'script.js' file
// Must ensure "require_once 'commands/_9.php';" is added to the "loadCommands.php" file
// 08-Apr-2022 | Matt Robb
//



	function _9() {
	// Non user command. Forces a screen refresh of the current sector using jquery at interval defined in 'script.js' file
	// 08-Apr-2022 | Matt Robb
	//
	// If not loggged-in (Visitor)
	if (!isset($_SESSION['alias'])) {
		$var = '';
		return $var;
	}	else {

		// If logged-in (Player), get and return objects in the sector
		$objects = getSectorObjects($_SESSION['sector_id']);
		$var = $objects;
		return $var;
		}
	}



?>
