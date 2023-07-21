<?php
// Asteroid
// Must ensure "require_once 'objects/asteroid.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function createAsteroid($sector_id) {
// Randomly create asteroid(s) in the given sector
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Get the item_type_id from table item_types where name = 'asteroid'
	$item_type_id = get_item_type_id_by_name('asteroid');

	$int = rand(0, 100);
	// 90% chance
	if ($int < 90) {
		// Determine count between 1 and 3
		$int = rand(1, 3);
		$x = 1;
		while($x <= $int) {
			dbConnect();
			$query = "INSERT INTO item (item_type_id, sector_id) VALUES ('$item_type_id', '$sector_id')";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			dbDisconnect();
			$x++;
		}
	}
}



function createAsteroidDetails($item_id) {
// Randomly create asteroid details for the selected asteroid
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Asteroids between 5 - 11,000 cubic meters
	$size_cubic_meters = rand(5, 11000);
	$type = rand(1,100);
	if ($type >= 1 && $type <= 59) {
		$type = "C";	// C-type (chrondrite) consisting of clay and silicate
	}	elseif ($type >= 60 && $type <= 89) {
		$type = "S";	// S-type (stony) consisting of silicate and nickel-iron
	}	else {
		$type = "M";	// M-type (metallic)
	}

	dbConnect();
	$query = "INSERT INTO item_asteroids (item_id, type, size_cubic_meters) VALUES ('$item_id', '$type', '$size_cubic_meters')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function getAsteroidDetails($item_id) {
// Return details of an asteroid when passed an item_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_asteroids WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$type = $row["type"];
			$size = $row["size_cubic_meters"];
		}
	dbDisconnect();
	} else {
		createAsteroidDetails($item_id);
		dbConnect();
		$query = "SELECT * FROM item_asteroids WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$type = $row["type"];
				$size = $row["size_cubic_meters"];
			}
		dbDisconnect();
		} else {
			$var = null;
		}
	}
	// Get asteroid type
	if ($type == "C") {
		$type = "chondrite asteroid ";	// C-type (chrondrite) consisting of clay and silicate
	}	elseif ($type == "S") {
		$type = "stony asteroid ";	// S-type (stony) consisting of silicate and nickel-iron
	}	else {
		$type = "metallic asteroid ";	// M-type (metallic)
	}
	$var = "Probe detects a " . $type;
	$var .= "measuring " . number_format($size) . " cubic meters.";
	return $var;
}



function getAsteroidType($item_id) {
// Return type of an asteroid when passed an item_id in order to create a like-material composite
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT type FROM item_asteroids WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$type = $row["type"];
		}
	dbDisconnect();
	}
	return $type;
}



function torpAsteroid($item_id) {
// Torpedo the selected asteroid
// May 2022 | Matt Robb
//
	global $db_server;

	$sector_id = $_SESSION['sector_id'];
	$type = getAsteroidType($item_id);

	dbConnect();
	$query = "DELETE FROM item WHERE item_id = $item_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();

	createComposite($sector_id, $type);

	// Get and return objects in the sector
	$objects = getSectorObjects($_SESSION['sector_id']);

	// Give player a point for torpedoing an asteroid
	addPlayerPoints(2,1);

	$var = "<a class='object'>Asteroid</a> torpedoed and eliminated from the sector.<br>";
	$var .= $objects;
	return $var;
}



?>
