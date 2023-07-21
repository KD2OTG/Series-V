<?php
// Wormhole
// Must ensure "require_once 'objects/wormhole.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function createWormhole($sector_id) {
// Randomly create wormhole in the given sector
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Get the item_type_id from table item_types where name = 'wormhole'
	$item_type_id = get_item_type_id_by_name('wormhole');

	$int = rand(0, 1000);
	// 0.3% chance
	if ($int < 3) {
		dbConnect();
		$query = "INSERT INTO item (item_type_id, sector_id) VALUES ('$item_type_id', '$sector_id')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}
}



function createWormholeDetails($item_id) {
// Randomly create wormhole details for the selected wormhole
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Determine wormhole type...
	$type = rand(1,2);
	if ($type == 1) {
		$type = "S";	// stable, bi-directional
	}	else {
		$type = "U";	// one-way, no-return
	}

	// Set destination... but don't go too far to edge of universe (integer limits)
	$xloc = rand(-99999,99999);
	$yloc = rand(-99999,99999);
	$zloc = rand(-99999,99999);

	// Create pair of stable wormholes
	if ($type == "S") {
		dbConnect();
		$query = "INSERT INTO item_wormholes (item_id, type, xloc, yloc, zloc) VALUES ('$item_id', '$type', '$xloc', '$yloc', '$zloc')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();

		// Get sector ID
		$sector_id = get_sector_id_by_coord($xloc, $yloc, $zloc);

		if (is_null($sector_id)) {
			// If the sector was never visited by a player, build it now with random object generation
			$sector_id = insertSector($xloc, $yloc, $zloc);
		}

		// Get get_item_type_id
		$item_type_id = get_item_type_id_by_name("wormhole");

		// Create return wormhole
		dbConnect();
		$query = "INSERT INTO item (item_type_id, sector_id) VALUES ('$item_type_id', '$sector_id')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		$item_id = mysqli_insert_id($db_server);	// $col[0] = id = wormhole_id
		dbDisconnect();

		// Set return coordinates to the current sector_id
		$xloc = $_SESSION['xloc'];
		$yloc = $_SESSION['yloc'];
		$zloc = $_SESSION['zloc'];

		// Build return wormhole details
		dbConnect();
		$query = "INSERT INTO item_wormholes (item_id, type, xloc, yloc, zloc) VALUES ('$item_id', '$type', '$xloc', '$yloc', '$zloc')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();

	} else {
		// Create single one-way wormhole
		dbConnect();
		$query = "INSERT INTO item_wormholes (item_id, type, xloc, yloc, zloc) VALUES ('$item_id', '$type', '$xloc', '$yloc', '$zloc')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}

	// Give player 150 points for discovering a wormhole
	addPlayerPoints(15,150);
}



function getWormholeDestination($item_id) {
// Return destination of a wormhole when passed an item_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_wormholes WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$type = $row["type"];
			$xloc = $row["xloc"];
			$yloc = $row["yloc"];
			$zloc = $row["zloc"];
		}
	dbDisconnect();
	} else {
		createWormholeDetails($item_id);
		dbConnect();
		$query = "SELECT * FROM item_wormholes WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$type = $row["type"];
				$xloc = $row["xloc"];
				$yloc = $row["yloc"];
				$zloc = $row["zloc"];
			}
		dbDisconnect();
		} else {
			$var = null;
		}
	}
	return array(
		'xloc' => $xloc,
		'yloc' => $yloc,
		'zloc' => $zloc
	);
}



function getWormholeDetails($item_id) {
// Return details of a wormhole when passed an item_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_wormholes WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$type = $row["type"];
			$xloc = $row["xloc"];
			$yloc = $row["yloc"];
			$zloc = $row["zloc"];
		}
	dbDisconnect();
	} else {
		createWormholeDetails($item_id);
		dbConnect();
		$query = "SELECT * FROM item_wormholes WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$type = $row["type"];
				$xloc = $row["xloc"];
				$yloc = $row["yloc"];
				$zloc = $row["zloc"];
			}
		dbDisconnect();
		} else {
			$var = null;
		}
	}
	$var = "Probe detects a potentially ";
	// Get wormhole type
	if ($type== "S") {
		$var .= "stable";
	}	else {
		$var .= "unstable";
	}
	$var .= " wormhole.";
	// $var .= "x: " . $xloc . "<br>";
	// $var .= "y: " . $yloc . "<br>";
	// $var .= "z: " . $zloc;
	return $var;
}



function torpWormhole($item_id) {
// Torpedo the selected wormhole
// May 2022 | Matt Robb
//
	global $db_server;

	// Get and return objects in the sector
	$objects = getSectorObjects($_SESSION['sector_id']);

	$var = "Torpedo entered the <a class='object'>wormhole</a> and vanished from sight.<br>";
	$var .= $objects;
	return $var;
}



?>
