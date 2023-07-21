<?php
// Ship Debris
// Must ensure "require_once 'objects/shipdebris.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function createShipDebris($sector_id) {
// Randomly create ship-debris in the given sector
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Get the item_type_id from table item_types where name = 'ship-debris'
	$item_type_id = get_item_type_id_by_name('ship-debris');

	$int = rand(0, 100);
	// 7% chance
	if ($int < 3) {
		dbConnect();
		$query = "INSERT INTO item (item_type_id, sector_id) VALUES ('$item_type_id', '$sector_id')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
		}
}



function createShipDebrisDetails($item_id) {
// Randomly create ship-debris details for the selected ship-debris
// Apr 2022 | Matt Robb
//
	global $db_server;

	$destroyed_years = rand(0,120);
	$type = rand(1,10);
	if ($type == 1) {
		$type = "passenger";	// ...
	}	elseif ($type == 2) {
		$type= "supply";	// ...
	}	elseif ($type == 3) {
		$type= "fuel";	// ...
	}	elseif ($type == 4) {
		$type= "container";	// ...
	}	elseif ($type == 5) {
		$type= "war";	// ...
	}	elseif ($type == 6) {
		$type= "mining";	// ...
	}	elseif ($type == 7) {
		$type= "scout";	// ...
	}	elseif ($type == 8) {
		$type= "science";	// ...
	}	elseif ($type == 9) {
		$type= "experimental";	// ...
	}	else {
		$type = "unknown";	// ...
	}

	dbConnect();
	$query = "INSERT INTO item_ship_debris (item_id, type, destroyed_years) VALUES ('$item_id', '$type', '$destroyed_years')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function getShipDebrisDetails($item_id) {
// Return details of a ship-debris when passed an item_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_ship_debris WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$type = $row["type"];
			$destroyed_years = $row["destroyed_years"];
		}
	dbDisconnect();
	} else {
		createShipDebrisDetails($item_id);
		dbConnect();
		$query = "SELECT * FROM item_ship_debris WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$type = $row["type"];
				$destroyed_years = $row["destroyed_years"];
			}
		dbDisconnect();
		} else {
			$var = null;
		}
	}
	$var = "Probe detects a possible ";
	// Get ship-debris
	if ($destroyed_years < 4) {
		$var .= $type . " ship destroyed in recent months.<br>";
	} else {
		$var .= $type . " ship destroyed nearly " . $destroyed_years . " years ago.<br>";
	}
	$var .= "The debris field is too large to determine identity or origin.";
	return $var;
}



function torpShipDebris($item_id) {
// Torpedo the selected ship-debris
// May 2022 | Matt Robb
//
	global $db_server;

	// Get and return objects in the sector
	$objects = getSectorObjects($_SESSION['sector_id']);

	$var = "Torpedo has passed straight through <a class='object'>ship-debris</a> without causing impact.<br>";
	$var .= $objects;
	return $var;
}



?>
