<?php
// DB tables: player, player_logins
// Must ensure "require_once 'objects/player.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function addPlayerPoints($app_pointtype_id, $points) {
// Add player points
// Jun 2022 | Matt Robb
//
	global $db_server;
	$id = $_SESSION['playerID'];

	dbConnect();
	$query = "INSERT INTO player_points (player_id, app_pointtype_id, points) VALUES ($id, $app_pointtype_id, $points)";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function getPlayerAlias($item_id) {
// Return a player alias from the $item_id (ship they captain)
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT alias FROM player WHERE item_id = $item_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var = $row["alias"];
		}
	}
	dbDisconnect();
	return $var;
}



function getPlayerShipLocation($player_id)	{
// Return item_id from table player
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT p.item_id FROM player AS p WHERE player_id = '$player_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$item_id = $row["item_id"];
		}
	} else {
		$item_id = null;
	}
	dbDisconnect();
	return $item_id;
}



function getPlayerShipName($item_id)	{
// Return proper_name from table item
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT i.proper_name FROM item AS i WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$proper_name = $row["proper_name"];
		}
	} else {
		$proper_name = null;
	}
	dbDisconnect();
	return $proper_name;
}



function getPlayerDailyTurns($player_id) {
// Return the player's daily turns
// Jul 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT turns FROM player WHERE player_id = $player_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var = $row["turns"];
		}
	}
	return $var;
}



function setPlayerShipLocation($sector_id, $item_id) {
// Set sector_id in table item for the player's ship
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "UPDATE item SET sector_id = '$sector_id' WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function decrementPlayerTorp() {
// Decrement the player's torpedo count
// May 2022 | Matt Robb
//
	global $db_server;

	$_SESSION['torp'] = ($_SESSION['torp'] - 1);
	$shipID = $_SESSION['shipID'];
	$item_type_id = get_item_type_id_by_name("torpedo");

	dbConnect();
	$query = "DELETE FROM item WHERE item_type_id = $item_type_id AND parent_item_id = $shipID LIMIT 1";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function decrementPlayerTurn() {
// Decrement the player's turn counter
// Feb 2017 | Matt Robb
//
	global $db_server;
	$id = $_SESSION['playerID'];

	$_SESSION['turns'] = ($_SESSION['turns'] - 1);
	$turns = $_SESSION['turns'];

	dbConnect();
	$query = "UPDATE player SET turns=$turns WHERE player_id=$id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function decrementPlayerFuel($item_id, $isPosMagneticField) {
// Decrement the player's ship's fuel
// Feb 2017 | Matt Robb
//
	global $db_server;

	// Get details of the shortest (smallest) fuel-rod on the player's ship
	$fuelrod_id = get_item_type_id_by_name("fuel-rod");
	dbConnect();

	$query =  "SELECT i.item_id, ";
	$query .= "i.item_type_id, ";
	$query .= "i.parent_item_id, ";
	$query .= "fr.item_fuelrod_id, ";
	$query .= "fr.length_centimeters ";
	$query .= "FROM item AS i, item_fuel_rods AS fr ";
	$query .= "WHERE i.item_id = fr.item_id AND i.parent_item_id = $item_id AND i.item_type_id = $fuelrod_id ";
	$query .= "ORDER BY fr.length_centimeters ASC LIMIT 1";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$fuelrod_id = $row["item_id"];
			$item_fuelrod_id = $row["item_fuelrod_id"];
			$length_centimeters = $row["length_centimeters"];
		}
	} else {
	 $var .= "<br>";
	}
	dbDisconnect();

	// Further reduce size of the shortest (smallest) fuel-rod on the player's ship
	if ($isPosMagneticField == true) {
		$decrease = (getShipFuelPercent($item_id) * 0.20); // Hefty 20% fuel consumption to break free from field
	} else {
		$cargoPercent = $_SESSION['cargoPercent'];
		// Reduce fuel proportional to carge weight carried...
		// To-Do: Perhaps modify the algorithm to reduce fuel when ship being towed...
		if ($cargoPercent <= 30) {
			$decrease = 0.03; // Approx. 33 turns
		} elseif ($cargoPercent > 30 && $cargoPercent <= 60) {
			$decrease = 0.05; // Approx. x turns
		} elseif ($cargoPercent > 60 && $cargoPercent <= 90) {
			$decrease = 0.08; // Approx. x turns
		} else {
			$decrease = 0.15; // Approx. x turns
		}
	}

	$length_centimeters = ($length_centimeters - $decrease);
	dbConnect();
	$query = "UPDATE item_fuel_rods SET length_centimeters = $length_centimeters WHERE item_fuelrod_id = $item_fuelrod_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();

	// Delete exhausted fuel rod
	if ($length_centimeters <= 0.25) {
		deleteFuelRod($fuelrod_id);
	}
	$_SESSION['fuel'] = getShipFuelPercent($item_id);	// display number is rounded in getStatusBar() function
}



?>
