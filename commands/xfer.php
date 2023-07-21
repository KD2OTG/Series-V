<?php
// Transfer fuel or torpedoes to another player
// Must ensure "require_once 'commands/xfer.php';" is added to the "loadCommands.php" file
// Jun 2022 | Matt Robb
//



function XFER($param) {
// Transfer fuel or torpedoes to another player
// Jun 2022 | Matt Robb
//
	global $db_server;
	global $command;

	// Split the parameter string into an array
	$strArray = explode(" ",$param);
	$shipName = $strArray[0];
	$objectType = $strArray[1];
	$objectCount = $strArray[2];
	$isSuccess = false;

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
			$var = "The ship's tractor beam is not aimed at a target.";
			return $var;
		}

		// Ensure ship name is at least four characters in length to avoid all objects being returned...
		if (strlen($shipName) < 4) {
			$var = "The ship's tractor beam failed to isolate <a class='object'>" . $param . "</a> in the sector.";
			return $var;
		}

		// Prevent probing 'ship' as the player's ship will always appear in current sector; also causes issue with ship-debris on matching...
		if (strtoupper($shipName) == 'SHIP') {
			$var = "The ship's tractor beam failed to isolate <a class='object'>" . $param . "</a> in the sector.";
			return $var;
		}

		// Check if a ship exists in the sector that matches by name
		$count = getMatchingItemCount($shipName, $_SESSION['sector_id']);
		if ($count == 0) {
			// If no sector objects returned that match item name...
			$var = "The ship's tractor beam failed to isolate <a class='object'>" . $param . "</a> in the sector.";
			return $var;
		} elseif ($count == 1) {
			// If exactly one sector object returned that matches item name...

			// Target ship details...
			$itemID = getItemIDFromName($shipName, $_SESSION['sector_id']);
			$itemType = getItemTypeFromName($shipName);

			// Source object details... (torpedo, fuel-rod)
			$sourceShipTorpCount = getShipTorpCount($_SESSION['shipID']);
			$sourceShipFuelPercent = getShipFuelPercent($_SESSION['shipID']);

			// Target object details... (torpedo, fuel-rod)
			$targetShipTorpCount = getShipTorpCount($itemID);
			$targetShipFuelPercent = getShipFuelPercent($itemID);

			// Convert param to upper case for comparison purposes
			$itemType = strtoupper($itemType);

			// Run case statement based on xfer parameter entered
			switch ($itemType) {

				case "SHIP":

					// Ensure the object type parameter is only a fuel-rod or torpedo
					if ($objectType == "" && $objectType == NULL) {
						$var = "The ship's tractor beam wasn't instructed to transfer fuel or torpedoes. Transfer canceled.";
						break;
					}

					// Ensure the object type parameter is only a fuel-rod or torpedo
					if ($objectType != "torp" && $objectType != "torpedo" && $objectType != "torps" && $objectType != "torpedos" && $objectType != "torpedoes" && $objectType != "fuel" && $objectType != "fuel-rod" && $objectType != "fuel-rods") {
						$var = "The ship's tractor beam was only designed to transfer fuel and torpedoes. Transfer canceled.";
						break;
					}

					// Ensure the object count is an integer
					if (ctype_digit($objectCount) == false) {
						$var = "Torpedo count or fuel percentage is not an integer. Transfer canceled.";
						break;
					} else {
						$objectCount = (int) $objectCount;
					}

					// Ensure the object count is greater than zero
					if ($objectCount < 1) {
						$var = "Torpedo count or fuel percentage is invalid. Transfer canceled.";
						break;
					}

					// Transfer torpedoes
					if ($objectType == "torp" || $objectType == "torpedo") {
						if (($sourceShipTorpCount < 1) || ($sourceShipTorpCount < $objectCount)) {
							$var = "Your ship holds fewer torpedoes than you wish to transfer.";
							break;
						}

						if ($targetShipTorpCount > 39) {
							$var = "<a class='object'>" . ucfirst($shipName) . "</a>'s torpedo tray is already full. Transfer canceled.";
							break;
						}

						if (($targetShipTorpCount + $objectCount) > 40) {
							$var = "<a class='object'>" . ucfirst($shipName) . "</a>'s torpedo tray does not have the capacity to accept the quantity. Transfer canceled.";
							break;
						}

						// Transfer torpedo(es) and return success message
						$var = xferTorpedo($itemID, $objectCount);
						$isSuccess = true;

				  // Transfer fuel-rods
					} else {
						if (($sourceShipFuelPercent < 1) || ($sourceShipFuelPercent < $objectCount)) {
							$var = "Your ship holds less fuel than you wish to transfer.";
							break;
						}

						if ($targetShipFuelPercent > 99) {
							$var = "<a class='object'>" . ucfirst($shipName) . "'s</a> fuel rod chamber is already full. Transfer canceled.";
							break;
						}

						// Transfer fuel and return success message
						$var = xferFuel($itemID, $objectCount);
						$isSuccess = true;
						if ($var == null) {
							$isSuccess = false;
							$var = "Fuel chamber does not contain a fuel-rod less than or equal to your desired transfer. Transfer canceled.";
							break;
						}
					}
					// $var =  "Ship " . $itemID . " transferred.<br>";
					break;

				default:
					$count = getMatchingItemCount($param, $_SESSION['sector_id']);
					$count .= "<br>itemType = " . $itemType;
					return $count;
			}

			// Decrement turn only when player enters a valid ship
			if ($isSuccess == false) {
				return $var;
			} else {
				decrementPlayerTurn();
				$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
				$var0 = '<a class="statusbar">' . $statusbar . '</a><br>';
				$var = $var0 . $var;
				return $var;
			}

		} else {
			// If more than one sector object is returned matching item name...
		       	$var = "The ship's tractor beam failed to identify single target.<br>";
			$var = $var . "Probe manually using only the sector's Fine Gamma Coordinate (FGC):<br>";
			$var = $var . getItemsBySectorID($param, $_SESSION['sector_id']);
			return $var;
		}
	}
}



?>
