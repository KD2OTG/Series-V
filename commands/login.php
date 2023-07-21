<?php
// Log the player into the game
// Must ensure "require_once 'commands/login.php';" is added to the "loadCommands.php" file
// March 2017 | Matt Robb
//


	function login($param) {
	// Log the player into the game
	// March 2022 | Matt Robb

		// If not loggged-in (Visitor)
		if (!isset($_SESSION['alias'])) {
			// Track that user is attempting to log in...

			// Step #1 of #3 : prompt for user's email address
			if ($_SESSION['loginProcedure'] == "1") {
				$_SESSION['loginProcedure'] = "2";
				// Show the command the user input before prompting for email address
				$var = '<a class="prompt">' . PROMPT . $param . '</a><br>';
				$var = $var . 'Enter your email address (or first name/handle/alias):<br>';
				return $var;
			}

			// Step #2 of #3 : capture email address entered, then prompt for user's password
			if ($_SESSION['loginProcedure'] == "2") {
				$_SESSION['loginProcedure'] = "3";
				$_SESSION['email'] = $param;
				$var = 'Enter your password:';
				$var = $var . '<script>document.getElementById("txtInput").style.color = "#380C2A";</script>';
				return $var;
			}

			// Step #3 of #3 : capture password entered, then attempt authentication procedure
			if ($_SESSION['loginProcedure'] == "3") {
				$_SESSION['loginProcedure'] = "";
				$_SESSION['password'] = $param;
				// Set a session variable to hide the password displayed on screen before presenting welcome message
				$_SESSION['suppressPrompt'] = "true";

				$email = $_SESSION['email'];
				$password = $_SESSION['password'];

				if (!authenticate($email, $password)) {
					// Reset the session variable to restart the loop
					$_SESSION['loginProcedure'] = "";
					$var = 'Login unsuccessful. Account login process cancelled.<br>';
					$var = $var . '<script>document.getElementById("txtInput").style.color = "#4E980A";</script>';
					return $var;
				}
				else {
					// Set a session variable to hide the password displayed on screen before presenting welcome message
					$_SESSION['suppressPrompt'] = "true";
					// Clear two session variables no longer needed
					$_SESSION['email'] = "";
					$_SESSION['password'] = "";
					// Reload the page now that session variables are set; code to handle this is in index.php
					$var = '<script>window.location.href = "index.php";</script>';
					$var = $var . '<script>document.getElementById("txtInput").style.color = "#4E980A";</script>';
					return $var;
				}

			}
		}
		// If logged-in (Player), display message in output that won't reveal password
		else {
			$_SESSION['loginProcedure'] = "";
			$var = 'You are already logged into the game.<br><br>';
		}
		return $var;
	}


	function authenticate($email, $password) {
	// Log the user into the game
	// March 2022 | Matt Robb

		global $db_server;
		$salt1 = "tt&b";							// Careful, must match value in both login() and createAccount()
		$salt2 = "vc!*";							// Careful, must match value in both login() and createAccount()
		$token = md5("$salt1$password$salt2");

		dbConnect();
		$query = "SELECT * FROM player WHERE (password = '$token') AND (email = '$email' OR alias = '$email')";	// Allow email address or alias
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
	 		// Output data of each row
	 		while ($row = mysqli_fetch_assoc($result)) {
				if ($token == $row["password"]) {
					$_SESSION['playerID'] = $row["player_id"];
					$_SESSION['alias'] = $row["alias"];
					$_SESSION['turns'] = $row["turns"];
					// $_SESSION['fuel'] = $row["fuel"];
					$_SESSION['shipID'] = $row["item_id"];
				} else {
		 			// Do nothing
				}
			}

			$query = "SELECT sector_id FROM item WHERE item_id ='" . $_SESSION['shipID'] ."'";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			if (mysqli_num_rows($result) > 0) {
				// Output data of each row
				while ($row = mysqli_fetch_assoc($result)) {
					$_SESSION['sector_id'] = $row["sector_id"];
				}
			} else {
				// Do nothing
			}

			$query = "SELECT xloc, yloc, zloc FROM sector WHERE sector_id ='" . $_SESSION['sector_id'] ."'";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			if (mysqli_num_rows($result) > 0) {
				// Output data of each row
				while ($row = mysqli_fetch_assoc($result)) {
					$_SESSION['xloc'] = $row["xloc"];
					$_SESSION['yloc'] = $row["yloc"];
					$_SESSION['zloc'] = $row["zloc"];
				}
			} else {
				// Do nothing
			}
			dbDisconnect();

			$_SESSION['cargoPercent'] = getShipCargoPercent($_SESSION['shipID']);
			$_SESSION['torp'] = getShipTorpCount($_SESSION['shipID']);
			$_SESSION['fuel'] = getShipFuelPercent($_SESSION['shipID']);
			makePlayerShipVisible($_SESSION['shipID']);
			// Allow for fake location to be recorded for NPC characters (Admin folder)
			if (strpos($email,"series-v.com") == false) {
				recordLoginTimestamp($_SESSION['playerID']);
			} else {
				// then allow admin/npc.php to log timestamp in order to force state/country
			}
			return true;
		}	else {
			dbDisconnect();
			return false;
		}
	}



	function makePlayerShipVisible($item_id) {
	// Make player's ship visible since they've logged in to a new game;
	// They were marked hidden at end of last game and shouldn't appear sitting in sector 0.0.0
	// Jul 2022 | Matt Robb
	//
		global $db_server;

		$item_type_id = get_item_type_id_by_name("ship");

		dbConnect();
		$query = "UPDATE item SET is_visible = true WHERE item_id = $item_id";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}



	function recordLoginTimestamp($playerID) {
	// Create login timestamp after user successfully logs in
	// February 2019 | Matt Robb
		global $db_server;
		dbConnect();
		$query = "INSERT INTO player_logins (player_id, location) VALUES ('$playerID','" . ip_info("Visitor", "State") . " / " . ip_info("Visitor", "Countrycode") . "')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}


	function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
	// Get the visitor's location
	// 03-Feb-2019 | Matt Robb (via online code)
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}


?>
