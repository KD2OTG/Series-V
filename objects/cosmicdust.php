<?php
// Cosmic Dust
// Must ensure "require_once 'objects/cosmicdust.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function createCosmicDust($sector_id) {
// Randomly create cosmic dust in the given sector
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Get the item_type_id from table item_types where name = 'cosmic-dust'
	$item_type_id = get_item_type_id_by_name('cosmic-dust');

	$int = rand(0, 100);
	// 5% chance
	if ($int < 5) {
		dbConnect();
		$query = "INSERT INTO item (item_type_id, sector_id) VALUES ('$item_type_id', '$sector_id')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}
}



function createCosmicDustDetails($item_id) {
// Randomly create cosmic-dust details for the selected cosmic-dust
// Apr 2022 | Matt Robb
//
	global $db_server;

	$size_diameter_meters = rand(10, 20000);
	// Various composites
	$composite = rand(1,6);
	if ($composite == 1) {
		$composite = "a carbon dioxide";
	}	elseif ($composite == 2) {
		$composite = "a silicon carbide";
	}	elseif ($composite == 3) {
		$composite = "an amorphous silicate";
	}	elseif ($composite == 4) {
		$composite = "an ice";
	}	elseif ($composite == 5) {
		$composite = "a polyformaldehyde";
	}	else {
		$composite= "an unknown material";
	}

	dbConnect();
	$query = "INSERT INTO item_cosmic_dusts (item_id, composite, size_diameter_meters) VALUES ('$item_id', '$composite', '$size_diameter_meters')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function getCosmicDustDetails($item_id) {
// Return details of cosmic-dust when passed an item_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_cosmic_dusts WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$size_diameter_meters = $row["size_diameter_meters"];
			$composite = $row["composite"];
		}
	dbDisconnect();
	} else {
		createCosmicDustDetails($item_id);
		dbConnect();
		$query = "SELECT * FROM item_cosmic_dusts WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$size_diameter_meters = $row["size_diameter_meters"];
				$composite = $row["composite"];
			}
		dbDisconnect();
		} else {
			$var = null;
		}
	}
	$var = "Probe detects " . $composite;
	$var .= "-filled dust cloud of " . number_format($size_diameter_meters) . " meters in diameter.";
	return $var;
}



function torpCosmicDust($item_id) {
// Torpedo the selected cosmic-dust
// May 2022 | Matt Robb
//
	global $db_server;

	// Get and return objects in the sector
	$objects = getSectorObjects($_SESSION['sector_id']);

	$var = "Torpedo has passed straight through <a class='object'>cosmic-dust</a> without causing impact.<br>";
	$var .= $objects;
	return $var;
}



?>
