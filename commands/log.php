<?php
// Log / Return a ship's log
// Must ensure "require_once 'commands/log.php';" is added to the "loadCommands.php" file
// August 2022 | Matt Robb
//




	function SHIPLOG($param) {
	// Return information from the ship's log, and/or what was downloaded from probing a station or barge
	// Aug 2022 | Matt Robb
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


// AUG 12, 2022
// Need to build a ship log table
// Need to populate a ship log table; bit values to indicate local vs. uploaded
// Need to return log
// Need to apply / allo\w for search params


			dbConnect();
			$query = "SELECT i.proper_name, iba.xloc, iba.yloc, iba.zloc, iba.datetimestamp FROM item i, item_beacon_activations iba WHERE iba.ship_id = i.item_id ORDER BY iba.datetimestamp DESC LIMIT 10";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			$cnt = 1;
			$var =        "+| Last ten beacon activations |+----------------------------------------------"."<br><br>";
			$var = $var . "NO  SHIP             ACTIVATED BEACON IN SECTOR                    TIME (UTC)  "."<br>";
			$var = $var . "--  ---------------  --------------------------------------------  ------------";
			while ($row = mysqli_fetch_assoc($result)) {
				$new_datetime = $row["datetimestamp"];
				$new_datetime = gmdate( "M d H:i", strtotime($new_datetime));
				$var .= "<br>" . str_pad($cnt,2," ",STR_PAD_LEFT) . "  <aRENDERclass='object'>" . str_pad($row["proper_name"],15," ") . "</a>  <aRENDERclass='prompt'>" . str_pad("[" . $row["xloc"] . "." .$row["yloc"] . "." . $row["zloc"] . "]",44," ") . "</a>  " . $new_datetime;
				$cnt++;
			}
			dbDisconnect();
			$var = str_replace(" ","&nbsp;",$var);	// Corrects the situation where browser ignores more than one space character
			$var = str_replace("RENDER"," ",$var);	// Corrects the situation where browser ignores more than one space character










					// Decrement turn only when player enters a valid log parameter
					decrementPlayerTurn();
					$statusbar = getStatusBar();				// Assigned to variable as session variable increment/decrement will not process in a single echo() function; variable displayed would be -1 position
					$var0 = '<a class="statusbar">' . $statusbar . '</a><br>';
					$var = $var0 . $var;
					return $var;

		}
	}



?>
