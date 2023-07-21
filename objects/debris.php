<?php
// debris (from beacon)
// Must ensure "require_once 'objects/debris.php';" is added to the "loadCommands.php" file
// May 2022 | Matt Robb
//



function createBeaconDebris($item_id, $sector_id) {
// Create beacon-debris in the given sector
// May 2022 | Matt Robb
//
	global $db_server;

	// Get details of the beacon being destroyed
	dbConnect();
	$query = "SELECT series, age_years FROM item_beacons WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$series = $row["series"];
			$age_years = $row["age_years"];
		}
	dbDisconnect();

	// Get the item_type_id from table item_types where name = 'beacon-debris'
	$item_type_id = get_item_type_id_by_name('debris');

	// Create item record
	dbConnect();
	$query = "INSERT INTO item (item_type_id, sector_id) VALUES ('$item_type_id', '$sector_id')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
  $item_id = mysqli_insert_id($db_server);	// $col[0] = id = item_id
	dbDisconnect();

	// Create beacon-debris record
	dbConnect();
	$query = "INSERT INTO item_beacon_debris (item_id, series, age_years, destroyed_years) VALUES ('$item_id', '$series', '$age_years', '0')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
	}

	$var = "";
	return $var;
}



function getBeaconDebrisDetails($item_id) {
// Return details of a beacon-debris when passed an item_id
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_beacon_debris WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$series = $row["series"];
			$age_years = $row["age_years"];
			$destroyed_years = $row["destroyed_years"];
		}
	dbDisconnect();
	}

	$var =  "Probe detects debris from a series-" . $series . " ";
	$var .= "transmitting beacon destroyed in recent months.";
	return $var;
}



function torpBeaconDebris($item_id) {
// Torpedo the selected beacon-debris
// May 2022 | Matt Robb
//
	global $db_server;

	// Get and return objects in the sector
	$objects = getSectorObjects($_SESSION['sector_id']);

	$var = "Torpedo has passed straight through <a class='object'>debris</a> without causing impact.<br>";
	$var .= $objects;
	return $var;
}



?>
