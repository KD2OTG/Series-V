<?php
// Torpedo an object
// Must ensure "require_once 'commands/torp.php';" is added to the "loadCommands.php" file
// May 2022 | Matt Robb
//

	function TORP($param) {
	// Torpedo an item found in the current sector
	// May 2022 | Matt Robb
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

			// Continue only if player has remaining torpedoes
			if ($_SESSION['torp'] < 1) {
							 $var = "No torpedoes are available below deck.";
				return $var;
			}

			// Continue only if there is no Station in current sector
			$count = 0;
			$count .= getMatchingItemCount("station", $_SESSION['sector_id']);
			if ($count > 0) {
				$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
				$var = "Torpedo system deactivated by the nearby station for added safety.";
				return $var;
			}

			// Continue only if there is no Barge in current sector
			$count = 0;
			$count .= getMatchingItemCount("barge", $_SESSION['sector_id']);
			if ($count > 0) {
				$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
				$var = "Torpedo system deactivated by the nearby barge for added safety.";
				return $var;
			}


			// If parameter = "me" then torp user's ship; remove 1 torpedo and drop rest into sector
			if ($param == "me") {
				// $var = getShipDetails($_SESSION['shipID']);
				decrementPlayerTurn();
				decrementPlayerTorp();
				$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
				$var0 = '<a class="statusbar">' . $statusbar . '</a><br>';
				$var = $var0 . $var;
				return $var;
			}

			// Ensure parameter is not null
			if (is_null($param) || $param == "") {
				$var = "The ship's torpedo sight is not aimed at a target.";
				return $var;
			}

			// Ensure parameter is at least four characters in length to avoid all objects being returned...
			if (strlen($param) < 4) {
				$var = "The ship's torpedo sight failed to isolate <a class='object'>" . $param . "</a> in the sector.";
				return $var;
			}

			// Prevent torpedoing 'ship' as the player's ship will always appear in current sector; also causes issue with ship-debris on matching...
			if (strtoupper($param) == 'SHIP') {
				$var = "The ship's torpedo sight failed to isolate <a class='object'>" . $param . "</a> in the sector.";
				return $var;
			}

			// Check if an item exists in the sector that matches by name
			$count = getMatchingItemCount($param, $_SESSION['sector_id']);
			if ($count == 0) {
				// If no sector objects returned that match item name...
				$var = "The ship's torpedo sight failed to isolate <a class='object'>" . $param . "</a> in the sector.";
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

					// Run case statement based on torp parameter entered
					switch ($itemType) {

						case "ASTEROID":
							// $var =  "Asteroid " . $itemID . " torpedoed.<br>";
							$var = torpAsteroid($itemID);
							break;

						case "BARGE":
							// $var =  "Barge " . $itemID . " torpedoed.<br>";
							$var = "The nearby barge has deactivated your mining torpedo system.";
							break;

						case "BEACON":
							// $var =  "Beacon " . $itemID . " torpedoed.";
							createBeaconDebris($itemID, $_SESSION['sector_id']);
							$var = torpBeacon($itemID);
							break;

						case "COMET":
							// $var =  "Comet " . $itemID . " torpedoed.";
							$var = torpComet($itemID);
							break;

						case "COMPOSITE":
							// $var =  "Composite " . $itemID . " torpedoed.";
							$var = torpComposite($itemID);
							break;

						case "COSMIC-DUST":
							// $var =  "Cosmic-dust " . $itemID . " torpedoed.";
							$var = torpCosmicDust($itemID);
							break;

						case "DEBRIS":
							// $var =  "beacon-debris " . $itemID . " torpedoed.";
							$var = torpBeaconDebris($itemID);
							break;

						case "FUEL-ROD":
							// $var =  "Fuel-rod " . $itemID . " torpedoed.";
							$var = torpFuelRod($itemID);
							break;

						case "MAGNETIC-FIELD":
							$var =  "Magnetic-field " . $itemID . " torpedoed.";
							// $var = getMagneticFieldDetails($itemID);
							break;

						case "SHIP-DEBRIS":
							// $var =  "Ship-debris " . $itemID . " torpedoed.";
							$var = torpShipDebris($itemID);
							break;

						case "SHIP":
							// $var =  "Ship " . $itemID . " torpedoed.<br>";
							$var = torpShip($itemID);
							break;

						case "STATION":
							// $var =  "Station " . $itemID . " torpedoed.<br>";
							$var = "The nearby station has deactivated your mining torpedo system.";
							break;

						case "TORPEDO":
							// $var =  "Torpedo " . $itemID . " torpedoed.<br>";
							$var = torpTorpedo($itemID);
							break;

						case "WORMHOLE":
							// $var =  "Wormhole " . $itemID . " torpedoed.";
							$var = torpWormhole($itemID);
							break;

						default:
							$count = getMatchingItemCount($param, $_SESSION['sector_id']);
							$count .= "<br>itemType = " . $itemType;
							return $count;
					}

					// Decrement turn and torpedo count only when player enters a valid parameter
					decrementPlayerTurn();
					decrementPlayerTorp();
					$objects = getSectorObjects($_SESSION['sector_id']);
					$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
					$var0 = '<a class="statusbar">' . $statusbar . '</a><br>';
					$var0 .= $var;
					return $var0;

			} else {
				// If more than one sector object is returned matching item name...
				       $var = "The ship's torpedo sight failed to identify single target.<br>";
				$var = $var . "Fire torpedo manually using only the sector's Fine Gamma Coordinate (FGC):<br>";
				$var = $var . getItemsBySectorID($param, $_SESSION['sector_id']);
				return $var;
			}
		}
	}



?>
