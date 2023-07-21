<?php
// Drop an inventory item and add to sector
// Must ensure "require_once 'commands/drop.php';" is added to the "loadCommands.php" file
// Jun 2022 | Matt Robb
//

function DROP($param) {
// Drop an item found in the ship's inventory
// Jun 2022 | Matt Robb
//
	global $db_server;
	global $command;

	// If not loggged-in (Visitor)
	if (!isset($_SESSION['alias'])) {
		$var = '"' . $command . '" is an invalid command.  Please try again.';
		return $var;
	}	else {

		// Continue only if player has remaining Daily turns
		if ($_SESSION['turns'] < 1) {
						 $var = "You are all out of Daily Turns (DT) for today.<br>";
			$var = $var . "Please try again tomorrow.";
			return $var;
		}

		// Ensure parameter is not null
		if (is_null($param) || $param == "") {
			$var = "Ship's internal asset manager is not aimed at a target in the hull.";
			return $var;
		}

		// Ensure parameter is at least four characters in length to avoid all objects being returned...
		if (strlen($param) < 4) {
			$var = "Ship's internal asset manager failed to isolate <a class='object'>" . $param . "</a> in the hull.";
			return $var;
		}

		// Prevent getting 'ship' as the player's ship will always appear in current sector; also causes issue with ship-debris on matching...
		if (strtoupper($param) == 'SHIP') {
			$var = "Ship's internal asset manager failed to isolate <a class='object'>" . $param . "</a> in the hull.";
			return $var;
		}

		// Check if an item exists in the hull that matches by name
		$count = getMatchingInventoryCount($param, $_SESSION['shipID']);
		if ($count == 0) {
			// If no inventory objects returned that match item name...
			$var = "Ship's internal asset manager failed to isolate <a class='object'>" . $param . "</a> in the hull.";
			return $var;
		} elseif ($count == 1) {
			// If exactly one inventory object returned that matches item name...

			// If a number is presented, it's the item_id (FGC was passed)
			if (is_numeric($param)) {
				$itemID = $param;
				$itemType = getItemTypeFromItemID($param);
			} else {
				// It's already the generic item name
				$itemID = getInventoryIDFromName($param, $_SESSION['shipID']);
					$itemType = getItemTypeFromName($param);
				}
				// Convert param to upper case for comparison purposes
				$itemType = strtoupper($itemType);

				// Run case statement based on get parameter entered
				switch ($itemType) {

					case "COMPOSITE":
						// $var =  "Composite " . $itemID . " dropped.";
						$ret_text = dropComposite($itemID);
						break;

					case "FUEL-ROD":
						// $var =  "Fuel-rod " . $itemID . " dropped.";
						$ret_text = dropFuelRod($itemID);
						break;

					case "TORPEDO":
						// $var =  "Torpedo " . $itemID . " dropped.";
						$ret_text = dropTorpedo($itemID);
						break;

					default:
						// Next three lines are for debug purposes
						// $count = getMatchingItemCount($param, $_SESSION['sector_id']);
						// $count .= "<br>itemType = " . $itemType;
						// return $count;

						$var = "Ship's internal asset manager was not designed to drop objects like a <a class='object'>" . strtolower($itemType) . "</a>.";
						return $var;
					}

				// Decrement turn only when player enters a valid item parameter
				decrementPlayerTurn();
				// Get and return objects in the sector
				$objects = getSectorObjects($_SESSION['sector_id']);
				$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
				$var0 =  "<a class='statusbar'>" . $statusbar . "</a><br>";
				$var0 .= $ret_text;
				$var0 .= $objects;
				return $var0;

	} else {
		// If more than one inventory object is returned matching item name...
				       $var = "Ship's internal asset manager failed to identify single object.<br>";
		$var = $var . "Drop manually using Asset No.:<br>";
		$var = $var . getInventoryByShipID($param, $_SESSION['shipID']);
		return $var;
	}
	}
}



?>
