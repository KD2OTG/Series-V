<?php
// Move/navigate
// Must ensure "require_once 'commands/go.php';" is added to the "loadCommands.php" file
// March 2017 | Matt Robb
//



	function GO($param) {
	// Move the player by incrementing coordinates
	// February 2017 | Matt Robb

		global $db_server;
		global $command;
		$direction = "";
		$validparam = 1;

		// If not loggged-in (Visitor)
		if (!isset($_SESSION['alias'])) {
			$var = '"' . $command . '" is an invalid command.  Please try again.';
			return $var;
		}
		else {

			// Continue only if player has remaining Daily turns
			if ($_SESSION['turns'] < 1) {
							 $var = "You are all out of Daily Turns (DT) for today.<br>";
				$var = $var . "Please try again tomorrow.";
				return $var;
			}

			// Continue only if player has remaining fuel
			if ($_SESSION['fuel'] < 1) {
				$shipname = getPlayerShipName($_SESSION['shipID']);
							 $var = "A hearty thud was felt beneath your feet from the mechanical room below.<br>";
				$var = $var . "It seems your ship <a class='object'>$shipname</a> is out of fuel.<br>";
				$var = $var . "Perhaps a distress call is in order?";
				return $var;
			}

			// Convert param to upper case for comparison purposes
			$param = strtoupper($param);

			//
			if (substr($param,0,4) == "MAGN") {
				$param = "MAGNETIC-FIELD";
			}

			// Run case statement based on navigation parameter entered
			switch ($param) {
				case "L":
					$_SESSION['xloc'] = ($_SESSION['xloc'] - 1);
					$direction = 'LEFT';
					break;

				case "LEFT":
					$_SESSION['xloc'] = ($_SESSION['xloc'] - 1);
					$direction = 'LEFT';
					break;

				case "R":
					$direction = 'RIGHT';
					$_SESSION['xloc'] = ($_SESSION['xloc'] + 1);
					break;

				case "RIGHT":
					$direction = 'RIGHT';
					$_SESSION['xloc'] = ($_SESSION['xloc'] + 1);
					break;

				case "U":
					$direction = 'UP';
					$_SESSION['yloc'] = ($_SESSION['yloc'] + 1);
					break;

				case "UP":
					$direction = 'UP';
					$_SESSION['yloc'] = ($_SESSION['yloc'] + 1);
					break;

				case "D":
					$direction = 'DOWN';
					$_SESSION['yloc'] = ($_SESSION['yloc'] - 1);
					break;

				case "DOWN":
					$direction = 'DOWN';
					$_SESSION['yloc'] = ($_SESSION['yloc'] - 1);
					break;

				case "F":
					$direction = 'FORWARD';
					$_SESSION['zloc'] = ($_SESSION['zloc'] + 1);
					break;

				case "FORWARD":
					$direction = 'FORWARD';
					$_SESSION['zloc'] = ($_SESSION['zloc'] + 1);
					break;

				case "B":
					$direction = 'BACKWARD';
					$_SESSION['zloc'] = ($_SESSION['zloc'] - 1);
					break;

				case "BACK":
					$direction = 'BACKWARD';
					$_SESSION['zloc'] = ($_SESSION['zloc'] - 1);
					break;

				case "BACKWARD":
					$direction = 'BACKWARD';
					$_SESSION['zloc'] = ($_SESSION['zloc'] - 1);
					break;

				case "MAGNETIC-FIELD":
					$sector_id =	get_sector_id_by_coord($_SESSION['xloc'], $_SESSION['yloc'], $_SESSION['zloc']);
					$item_id = getItemIDFromName("magnetic-field", $sector_id);

					if (is_null($item_id) || $item_id == "") {
						$validparam = 0;
						$var = '"' . $param . '" is an invalid navigation parameter. Please try again.';
						return $var;
					} else {
						$polarity = getMagneticFieldPolarity($item_id);

						if ($polarity == "P") {
							// Positive polarity, decrease player fuel by a significant amount to break free
						} else {
							// Negative polarity, push ship 25 spaces in some direction...
							$coor = rand(1,3);
							$distance = rand(22,32);
							if ($coor == 1) {
								// X-axis move
								$_SESSION['xloc'] = ($_SESSION['xloc'] + $distance);
							} elseif ($coor == 2) {
								// Y-axis move
								$_SESSION['yloc'] = ($_SESSION['yloc'] + $distance);
							} else {
								// Z-axix move
								$_SESSION['zloc'] = ($_SESSION['zloc'] + $distance);
							}
						}
					}
					break;

					case "WORMHOLE":
						$sector_id =	get_sector_id_by_coord($_SESSION['xloc'], $_SESSION['yloc'], $_SESSION['zloc']);
						$item_id = getItemIDFromName("wormhole", $sector_id);

						if (is_null($item_id) || $item_id == "") {
							$validparam = 0;
							$var = '"' . $param . '" is an invalid navigation parameter. Please try again.';
							return $var;
						} else {
							$result = getWormholeDestination($item_id);
							$_SESSION['xloc'] = $result['xloc'];
							$_SESSION['yloc'] = $result['yloc'];
						  $_SESSION['zloc'] = $result['zloc'];
						}
						break;

					default:
						$validparam = 0;
						$var = '"' . $param . '" is an invalid navigation parameter. Please try again.';
			}

			// Get sector ID
			$_SESSION['sector_id'] = get_sector_id_by_coord($_SESSION['xloc'], $_SESSION['yloc'], $_SESSION['zloc']);

			if (is_null($_SESSION['sector_id'])) {
				// If the sector was never visited by a player, build it now with random object generation
				insertSector($_SESSION['xloc'], $_SESSION['yloc'], $_SESSION['zloc']);
			}

			setPlayerShipLocation($_SESSION['sector_id'], $_SESSION['shipID']);

			// Get and return objects in the sector
			$objects = getSectorObjects($_SESSION['sector_id']);

			// Decrement turn only when player enters a valid navigation parameter
			if ($param != "") {
				decrementPlayerTurn();
			}

			// Display message only if navigational parameter is valid
			if ($validparam !== 0) {
				if ($param == "MAGNETIC-FIELD") {
						if ($polarity == "P") {
							// Positive-charged magnetic field action
							decrementPlayerFuel($_SESSION['shipID'], true);
							$var2 =  "Collision with the positive-charged magnetic field resulted in significant fuel use to break free.<br>";
						} else {
							// Negative-charged magnetic field action
							decrementPlayerFuel($_SESSION['shipID'], false);
							$var2 =  "Collision with the negative-charged magnetic field had swiftly repeled the ship several sectors over.<br>";
						}
				} elseif ($param == "WORMHOLE") {
						decrementPlayerFuel($_SESSION['shipID'], false);
						$var2 = "Entering the wormhole has led to a different sector of the universe.<br>";
				} else {
						// Display default message when Player chooses to navigate to new sector
						decrementPlayerFuel($_SESSION['shipID'], false);
						$var2 = "Navigated <a class='direction'>$direction</a> to new sector. Pod thrusters holding current position.<br>";
				}
				$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
				$var = '<a class="statusbar">' . $statusbar . '</a><br>';
				$var .= $var2;
				$var .= $objects;

			}
			return $var;
		}
	}



?>
