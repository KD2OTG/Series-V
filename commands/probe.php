<?php
// Probe / Get Info
// Must ensure "require_once 'commands/probe.php';" is added to the "loadCommands.php" file
// April 2022 | Matt Robb
//

	function PROBE($param) {
	// Return information about an item found in the current sector
	// April 2022 | Matt Robb
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

			// If parameter = "me" then probe user's ship
			if ($param == "me") {
				$var = getShipDetails($_SESSION['shipID']);
				decrementPlayerTurn();
				$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
				$var0 = '<a class="statusbar">' . $statusbar . '</a><br>';
				$var = $var0 . $var;
				return $var;
			}

			// Ensure parameter is not null
			if (is_null($param) || $param == "") {
				$var = "The ship's probing beam is not aimed at a target.";
				return $var;
			}

			// Ensure parameter is at least four characters in length to avoid all objects being returned...
			if (strlen($param) < 4) {
				$var = "The ship's probing beam failed to isolate <a class='object'>" . $param . "</a> in the sector.";
				return $var;
			}

			// Prevent probing 'ship' as the player's ship will always appear in current sector; also causes issue with ship-debris on matching...
			if (strtoupper($param) == 'SHIP') {
				$var = "The ship's probing beam failed to isolate <a class='object'>" . $param . "</a> in the sector.";
				return $var;
			}

			// Check if an item exists in the sector that matches by name
			$count = getMatchingItemCount($param, $_SESSION['sector_id']);
			if ($count == 0) {
				// If no sector objects returned that match item name...
				$var = "The ship's probing beam failed to isolate <a class='object'>" . $param . "</a> in the sector.";
				return $var;
			} elseif ($count == 1) {
				// If exactly one sector object returned that matches item name...

					// If a number is presented, it's the item_id (FGC was passed)
					if (is_numeric($param)) {
						$itemID = $param;
						$itemType = getItemTypeFromItemID($param);
					} else {
						// It's already the generic item name
						$itemID = getItemIDFromName($param, $_SESSION['sector_id']);
						$itemType = getItemTypeFromName($param);
					}
					// Convert param to upper case for comparison purposes
					$itemType = strtoupper($itemType);

					// Run case statement based on probe parameter entered
					switch ($itemType) {

						case "ASTEROID":
							// $var =  "Asteroid " . $itemID . " probed.<br>";
							$var = getAsteroidDetails($itemID);
							break;

						case "BARGE":
							// $var =  "Barge " . $itemID . " probed.<br>";
							refuelShip($_SESSION['shipID']);
							reTorpShip($_SESSION['shipID']);
							transferComposites($_SESSION['shipID']);

							$var = getBargeDetails($itemID);
							$var .= "Probing the barge initiated an unattended transfer sequence.<br>";
							$var .= "Ship's cargo offloaded to barge. Fuel and torpedoes brought onboard.";
							break;

						case "BEACON":
							// $var =  "Beacon " . $itemID . " probed.";
							$var = getBeaconDetails($itemID);
							$var = activateBeacon($itemID);
							break;

						case "COMET":
							// $var =  "Comet " . $itemID . " probed.";
							$var = getCometDetails($itemID);
							break;

						case "COMPOSITE":
							// $var =  "Composite " . $itemID . " probed.";
							$var = getCompositeDetails($itemID);
							break;

						case "COSMIC-DUST":
							// $var =  "Cosmic-dust " . $itemID . " probed.";
							$var = getCosmicDustDetails($itemID);
							break;

						case "DEBRIS":		// Beacon-debris
							// $var =  "Beacon-debris " . $itemID . " probed.";
							$var = getBeaconDebrisDetails($itemID);
							break;

						case "FUEL-ROD":
							// $var =  "Fuel-rod " . $itemID . " probed.";
							$var = getFuelRodDetails($itemID);
							break;

						case "MAGNETIC-FIELD":
							// $var =  "Magnetic-field " . $itemID . " probed.";
							$var = getMagneticFieldDetails($itemID);
							break;

						case "SHIP-DEBRIS":
							// $var =  "Ship-debris " . $itemID . " probed.";
							$var = getShipDebrisDetails($itemID);
							break;

						case "SHIP":
							// $var =  "Ship " . $itemID . " probed.<br>";
							$var .= getShipDetails($itemID);
							break;

						case "STATION":
							// $var =  "Station " . $itemID . " probed.<br>";
							refuelShip($_SESSION['shipID']);
							reTorpShip($_SESSION['shipID']);
							transferComposites($_SESSION['shipID']);

							$var .= "Probing the station initiated an unattended transfer sequence.<br>";
							$var .="Ship's cargo offloaded to station. Fuel and torpedoes brought onboard.";
							break;

						case "WORMHOLE":
							// $var =  "Wormhole " . $itemID . " probed.";
							$var = getWormholeDetails($itemID);
							break;

						default:
							$count = getMatchingItemCount($param, $_SESSION['sector_id']);
							$count .= "<br>itemType = " . $itemType;
							return $count;
					}

					// Decrement turn only when player enters a valid navigation parameter
					decrementPlayerTurn();
					$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
					$var0 = '<a class="statusbar">' . $statusbar . '</a><br>';
					$var = $var0 . $var;
					return $var;
			} else {
				// If more than one sector object is returned matching item name...
				       $var = "The ship's probing beam failed to identify single target.<br>";
				$var = $var . "Probe manually using only the sector's Fine Gamma Coordinate (FGC):<br>";
				$var = $var . getItemsBySectorID($param, $_SESSION['sector_id']);
				return $var;
			}
		}
	}



?>
