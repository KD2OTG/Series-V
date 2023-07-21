<?php
// Beacon
// Must ensure "require_once 'objects/beacon.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function activateBeacon($item_id) {
// Record an activation of a beacon in the beacon network
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Create beacon details if they don't yet exist...
	getBeaconDetails($item_id);

	// Set beacon activation coordinates to the current sector_id
	$xloc = $_SESSION['xloc'];
	$yloc = $_SESSION['yloc'];
	$zloc = $_SESSION['zloc'];
	$ship_id = $_SESSION['shipID'];
	$new_datetime = date("M.d H:i");

	// Get the timestamp the beacon was last activated
	dbConnect();
	$query = "SELECT * FROM item_beacons WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$last_activated = $row["last_activated"];
		}
	dbDisconnect();

	$var = getBeaconDetails($item_id);

	if ((time() - strtotime($last_activated)) < 3601) {
		$var .= "Beacon transmitted less than 60 minutes ago. Recharge in progress.";
	} else {

		// Set beacon activations
		dbConnect();
		$details = $new_datetime . " : Ship " . $ship_id . " activated beacon at [SECTOR: " . $xloc . "." .$yloc . "." . $zloc . "]";
		$query = "INSERT INTO item_beacon_activations (details, xloc, yloc, zloc, ship_id) VALUES ('$details', '$xloc', '$yloc', '$zloc', '$ship_id')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();

		// Set specific beacon last_activated date
		dbConnect();
		$new_datetime = date("Y-m-d H:i:s");
		$query = "UPDATE item_beacons SET last_activated = '$new_datetime' WHERE item_id = $item_id";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();

		$var .= "Probe activated a re-transmission on the beacon network:<br><br>";
		$var .= getNearbyShips() . "<br><br>";
		$var .= getBeaconActivations();

		}
	return $var;
	}
}



function createBeacon($sector_id) {
// Randomly create beacon in the given sector
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Get the item_type_id from table item_types where name = 'beacon'
	$item_type_id = get_item_type_id_by_name('beacon');

	$int = rand(0, 100);
	// 3% chance
	if ($int < 1) {
		dbConnect();
		$query = "INSERT INTO item (item_type_id, sector_id) VALUES ('$item_type_id', '$sector_id')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		$beacon_id = mysqli_insert_id($db_server);	// $col[0] = id = item_id
		dbDisconnect();
		createBeaconDetails($beacon_id);
	}
}



function createBeaconDetails($item_id) {
// Randomly create beacon details for the selected beacon
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Series T (200-400 yrs old), U (401-600), or V (601-800)
	$series = rand(1,3);
	if ($series == 1) {
		$series = "T";	// T-series (200-400 yrs old)
		$age_years = rand(200, 400);
	}	elseif ($series == 2) {
		$series = "U";	// U-series (401-600 yrs old)
		$age_years = rand(401, 600);
	}	else {
		$series = "V";	// V-series (601-800 yrs old)
		$age_years = rand(601, 800);
	}

	dbConnect();
	$query = "INSERT INTO item_beacons (item_id, series, age_years) VALUES ('$item_id', '$series', '$age_years')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function getBeaconActivations() {
// Return the beacon activations from the last three days
// May 2022 | Matt Robb
//
	global $db_server;

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
	return $var;
}



function getBeaconDetails($item_id) {
// Return details of a beacon when passed an item_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_beacons WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$series = $row["series"];
			$age_years = $row["age_years"];
		}
	dbDisconnect();
	} else {
		createBeaconDetails($item_id);
		dbConnect();
		$query = "SELECT * FROM item_beacons WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$series = $row["series"];
				$age_years = $row["age_years"];
			}
		dbDisconnect();
		} else {
			$var = null;
		}
	}
	$var = "Probe detects a ";
	// Get barge series
	if ($series == "T") {
		$var .= "series-" . $series;	// T-series (200-400 yrs old)
	}	elseif ($series == "U") {
		$var .= "series-" . $series;	  // U-series (401-600 yrs old)
	}	else {
		$var .= "series-" . $series;	// V-series (601-800 yrs old)
	}

	$var .= " transmitting beacon placed " . number_format($age_years) . " years ago.<br>";
	return $var;
}



function getNearbyShips() {
// Return the nearby ship locations
// May 2022 | Matt Robb
//
	global $db_server;

	$item_type_id = get_item_type_id_by_name("ship");
	$shipID = $_SESSION['shipID'];
	$int = rand(1, 10);

	dbConnect();
	$query =  "SELECT i.proper_name, s.xloc, s.yloc, s.zloc, p.alias FROM item i, sector s, player p ";
	$query .= "WHERE i.item_type_id = $item_type_id AND i.sector_id = s.sector_id AND i.item_id = p.item_id AND i.is_visible = true AND i.item_id <> $shipID ";
	$query .= "ORDER BY RAND() LIMIT $int";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$var = "The following ships have automatically responded. <br>";
	$var .= "Results vary due to signal interference or other propagation effects:<br><br>";
	$cnt = 1;
	$var .=  "+| Ships Responded |+----------------------------------------------------------"."<br><br>";
	$var .=  "NO  SHIP             CAPTAINED BY     CURRENTLY POSITIONED IN SECTOR           "."<br>";
	$var .=  "--  ---------------  ---------------  -----------------------------------------";
	while ($row = mysqli_fetch_assoc($result)) {
		$var .= "<br>" . str_pad($cnt,2," ",STR_PAD_LEFT) . "  <aRENDERclass='object'>" .  str_pad($row["proper_name"],15," ") . "</a>  <aRENDERclass='direction'>" .  str_pad($row["alias"],15," ") . "</a>  <aRENDERclass='prompt'>" . "[" . $row["xloc"] . "." .$row["yloc"] . "." . $row["zloc"] . "]</a>";
		$cnt++;
	}
	dbDisconnect();
	$var = str_replace(" ","&nbsp;",$var);	// Corrects the situation where browser ignores more than one space character
	$var = str_replace("RENDER"," ",$var);	// Corrects the situation where browser ignores more than one space character
	return $var;
}



function torpBeacon($item_id) {
// Torpedo the selected beacon
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "DELETE FROM item WHERE item_id = $item_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();

	// Get and return objects in the sector
	$objects = getSectorObjects($_SESSION['sector_id']);

	// Give player a negative point for torpedoeing a beacon
	addPlayerPoints(get_app_pointtype_id_by_name("NBT"),-25);

	$var = "<a class='object'>Beacon</a> torpedoed and eliminated from the sector.<br>";
	$var .= $objects;
	return $var;
}



?>
