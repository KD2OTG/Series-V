<?php
// Comet
// Must ensure "require_once 'objects/comet.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function createComet($sector_id) {
// Randomly create comet in the given sector
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Get the item_type_id from table item_types where name = 'comet'
	$item_type_id = get_item_type_id_by_name('comet');

	$int = rand(0, 1000);
	// 0.5% chance
	if ($int < 5) {
		dbConnect();
		$query = "INSERT INTO item (item_type_id, sector_id) VALUES ('$item_type_id', '$sector_id')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}
}



function createCometDetails($item_id) {
// Randomly create comet details for the selected comet
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Comets between 20,000 - 90,000 cubic meters
	$size_diameter_meters = rand(20000, 90000);
	dbConnect();
	$query = "INSERT INTO item_comets (item_id, size_diameter_meters) VALUES ('$item_id', '$size_diameter_meters')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function getCometDetails($item_id) {
// Return details of a comet when passed an item_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_comets WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$size_diameter_meters = $row["size_diameter_meters"];
		}
	dbDisconnect();
	} else {
		createCometDetails($item_id);
		dbConnect();
		$query = "SELECT * FROM item_comets WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$size_diameter_meters = $row["size_diameter_meters"];
			}
		dbDisconnect();
		} else {
			$var = null;
		}
	}
	// Get comet details
	$var = "Probe detects an ice-filled comet ";
	$var .= "measuring " . number_format($size_diameter_meters) . " meters in diameter.";
	return $var;
}



function torpComet($item_id) {
// Torpedo the selected comet
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

	$var = "<a class='object'>Comet</a> torpedoed and eliminated from the sector.<br>";
	$var .= $objects;
	return $var;
}



?>
