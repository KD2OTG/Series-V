<?php
// Sector
// Must ensure "require_once 'objects/sector.php';" is added to the "loadObjects.php" file
// Mar 2017 | Matt Robb
//



function get_sector_id_by_coord($xloc, $yloc, $zloc) {
// Return sector_id from table sector by xloc, yloc, and zloc
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT s.sector_id FROM sector AS s WHERE s.xloc = '$xloc' AND s.yloc = '$yloc' AND s.zloc = '$zloc'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$sector_id = $row["sector_id"];
		}
	} else {
		$sector_id = null;
	}
	dbDisconnect();
	return $sector_id;
}



function insertSector($xloc, $yloc, $zloc) {
// If the sector was never visited by a player, build it now with random object generation
// Mar 2022 | Matt Robb
//
	global $db_server;

	// Insert a sector record
	dbConnect();
	$query = "INSERT INTO sector (xloc, yloc, zloc) VALUES ('$xloc','$yloc','$zloc')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$sector_id = mysqli_insert_id($db_server);				// $row[0] = sector_id
	dbDisconnect();
	$_SESSION['sector_id'] = $sector_id;

	createAsteroid($sector_id);												// Randomly create no more than 3 asteroids (90% chance)
	createCosmicDust($sector_id);											// Randomly create cosmic dust (5% chance)
	createShipDebris($sector_id);											// Randomly create ship-debris (3% chance)
	createBeacon($sector_id);													// Randomly create beacon (1% chance)
	createComet($sector_id);													// Randomly create comet (0.5% chance)
	createMagneticField($sector_id);									// Randomly create magnetic field (0.02% chance)
	createBarge($sector_id);													// Randomly create barge (0.02% chance)
	createWormhole($sector_id);												// Randomly create wormhole pair (0.01% chance)

	// Give player a point for discovering a new sector
	addPlayerPoints(1,1);
	return $sector_id;
}



function getSectorObjects($sector_id) {
// Return the list of objects found in the sector
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Get the items in the sector
	dbConnect();
	$ship_id = $_SESSION['shipID'];
	// $query = "SELECT i.item_id, i.item_type_id, it.name FROM item AS i, item_types AS it WHERE it.item_type_id = i.item_type_id AND i.sector_id = '$sector_id' AND i.item_id <> '$ship_id' ORDER BY RAND()";
	$query = "SELECT i.item_id, i.item_type_id, COALESCE(i.proper_name, it.name) AS name FROM item AS i, item_types AS it WHERE it.item_type_id = i.item_type_id AND i.sector_id = '$sector_id' AND i.item_id <> '$ship_id' AND i.parent_item_id IS NULL AND i.is_visible = true ORDER BY RAND()";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$num_rows = mysqli_num_rows($result);

	if ($num_rows > 0) {
		// Perhaps insert some code here to clean this up a little, like returning "and" something...
		$obj = 'Auto-sensor sweep of sector detects: ';
		while ($row = mysqli_fetch_assoc($result)) {
			$name = $row["name"];
			// if ($name == 'asteroid') {		// If asteroid, return the last digit of the ID column
			// 	$obj = $obj . '<a class="object">' . $row["name"] . "-" . substr($row["item_id"], -1, 1) . '</a>, ';
			// }
			// else {
			$obj = $obj . '<a class="object">' . $row["name"] . '</a>, ';
		// }
		}
		dbDisconnect();
	}	else {
		$obj = 'Auto-sensor sweep of sector detects nothing.';
		return $obj;
	}
	$obj = substr($obj,0,-2);
	return $obj;
}



?>
