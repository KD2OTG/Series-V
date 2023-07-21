<?php
// Fuel-rod
// Must ensure "require_once 'objects/fuelrod.php';" is added to the "loadCommands.php" file
// May 2022 | Matt Robb
//



function createFuelRod($parent_item_id, $sector_id, $length_centimeters) {
// Create fuel-rod in the given sector
// May 2022 | Matt Robb
//
	global $db_server;

	// Get the item_type_id from table item_types where name = 'fuel-rod'
	$item_type_id = get_item_type_id_by_name('fuel-rod');

	// Ensure null values are passed propertly to DB
	if ($parent_item_id == "" || is_null($parent_item_id)) {
		$parent_item_id = "NULL";
	}
	if ($sector_id == "" || is_null($sector_id)) {
		$sector_id = "NULL";
	}

	dbConnect();
	$query = "INSERT INTO item (item_type_id, parent_item_id, sector_id) VALUES ($item_type_id, $parent_item_id, $sector_id)";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$item_id = mysqli_insert_id($db_server);	// $col[0] = item_id
	dbDisconnect();
	createFuelRodDetails($item_id, $length_centimeters);
}



function createFuelRodDetails($item_id, $length_centimeters) {
// Create composite details for the selected composite
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query =  "INSERT INTO item_fuel_rods (item_id, length_centimeters) VALUES ('$item_id', '$length_centimeters')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function deleteFuelRod($item_id) {
// Delete fuel-rod and fuel-rod details
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();

	$query =  "DELETE FROM item_fuel_rods WHERE item_id = $item_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$query = "DELETE FROM item WHERE item_id = $item_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function dropFuelRod($item_id) {
// Drop fuel-rod from player's ship inventory to sector
// Jun 2022 | Matt Robb
//
	global $db_server;
	$sector_id = $_SESSION['sector_id'];

	dbConnect();
	$shipID = $_SESSION['shipID'];
	$query =  "UPDATE item SET parent_item_id = NULL, sector_id = $sector_id WHERE item_id = $item_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
	$_SESSION['fuel'] = getShipFuelPercent($_SESSION['shipID']);
	$var = "Ship's asset management system dropped <a class='object'>fuel-rod</a>.  Pod thrusters holding current position.<br>";
	return $var;
}



function getFuelRod($item_id) {
// Get/retrieve fuel-rod and add to player's ship inventory
// May 2022 | Matt Robb
//
	global $db_server;

	// Only pick up fuel-rod if doing so will keep ship's fuel < 100
	$shipFuelPercent = getShipFuelPercent($_SESSION['shipID']);
	$length_centimeters = getFuelRodPercent($item_id);

	if ($shipFuelPercent + $length_centimeters <= 100.00) {
		dbConnect();
		$shipID = $_SESSION['shipID'];
		$query =  "UPDATE item SET parent_item_id = $shipID, sector_id = NULL WHERE item_id = $item_id";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
		$_SESSION['fuel'] = getShipFuelPercent($_SESSION['shipID']);
		$var = "Tractor beam retrieved <a class='object'>fuel-rod</a>.  Pod thrusters holding current position.<br>";
	} else {
		$var =  "The targeted fuel rod measures " . number_format($length_centimeters) . " centimeters and is too long to fit in the ship's chamber.<br>";
	}
	return $var;
}



function getFuelRodDetails($item_id) {
// Return details of a fuel-rod when passed an item_id
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_fuel_rods WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$length_centimeters = $row["length_centimeters"];
		}
	dbDisconnect();
	} else {
			// Eventually, fuel-rod details won't be created here, but will instead be created at time fuel-rod item is created
			createFuelRodDetails($item_id, 20);
			dbConnect();
			$query = "SELECT * FROM item_fuel_rods WHERE item_id = '$item_id'";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			if (mysqli_num_rows($result) > 0) {
				// Output data of each row
				while ($row = mysqli_fetch_assoc($result)) {
					$length_centimeters = $row["length_centimeters"];
				}
			dbDisconnect();
			} else {
				$var = null;
		}
	}

	$var =  "Probe detects a small octagonal fuel-rod measuring " . number_format($length_centimeters) . " centimeters. ";
	return $var;
}



function getFuelRodPercent($item_id) {
// Return percent of fuel-rod when passed an item_id
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_fuel_rods WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$length_centimeters = $row["length_centimeters"];
		}
	dbDisconnect();
	return $length_centimeters;
	}
}



function torpFuelRod($item_id) {
// Torpedo the selected fuel-rod
// May 2022 | Matt Robb
//
	global $db_server;

	// Get and return objects in the sector
	$objects = getSectorObjects($_SESSION['sector_id']);

	$var = "<a class='object'>Fuel-rod</a> torpedoed, but was too small an object to dentonate.<br>";
	$var .= $objects;
	return $var;
}



function getRandomFuelRodFromShip($item_id, $approx_cm) {
// Get a fuel-rod from ship's inventory
// Jun 2022 | Matt Robb
//
	global $db_server;
	$item_type_id = get_item_type_id_by_name("fuel-rod");

	dbConnect();
	$query = "SELECT i.item_id, ifr.length_centimeters FROM item i, item_fuel_rods ifr WHERE i.item_id = ifr.item_id AND i.parent_item_id = $item_id AND i.item_type_id = $item_type_id AND ifr.length_centimeters <= $approx_cm ORDER BY ifr.length_centimeters DESC LIMIT 1";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$itemID["item_id"] = $row["item_id"];
			$itemID["length_centimeters"] = $row["length_centimeters"];
		}
	} else {
			$itemID["item_id"] = null;
	}
	dbDisconnect();
	return $itemID;
}



function xferFuel($item_id, $approx_cm) {
// Transfer fuel and add to another player's ship inventory
// Jun 2022 | Matt Robb
//
	global $db_server;
	$shipID = $_SESSION['shipID'];
	$length = $approx_cm;

	$x = true;
	while($x == true) {
		$fuelrodID = getRandomFuelRodFromShip($shipID, $length);
		if ($fuelrodID["item_id"] != null) {
			dbConnect();
			$rodID = $fuelrodID["item_id"];
			$query =  "UPDATE item SET parent_item_id = $item_id, sector_id = NULL WHERE item_id = $rodID";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			dbDisconnect();
			$length = ($length - $fuelrodID["length_centimeters"]);

			// Give player 1 point for each fuel-rod centimeter transferred to a ship
			addPlayerPoints(get_app_pointtype_id_by_name("NFR"),$fuelrodID["length_centimeters"]);
			
			$x = true;
				$var = "Tractor beam successfully transferred <a class='object'>fuel-rod(s)</a>. Pod thrusters holding current position.";
		} else {
			$x = false;
			$var2 = null;
		}
	}
	$_SESSION['fuel'] = getShipFuelPercent($_SESSION['shipID']);
	if ($var == null) {
		// return the null for handling
	} else {
		// $var already set above
	}
	return $var;
}



?>
