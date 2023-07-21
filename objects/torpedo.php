<?php
// Torpedo
// Must ensure "require_once 'objects/torpedo.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function createTorpedo($parent_item_id, $sector_id, $count) {
// Create torpedo within the given ship and sector; allow for counter
// May 2022 | Matt Robb
//
	global $db_server;
	if ($count == "" || is_null($count)) {
		$count = 0;
	}

	// Ensure null values are passed propertly to DB
	if ($parent_item_id == "" || is_null($parent_item_id)) {
		$parent_item_id = "NULL";
	}
	if ($sector_id == "" || is_null($sector_id)) {
		$sector_id = "NULL";
	}

	// Get the item_type_id from table item_types where name = 'torpedo'
	$item_type_id = get_item_type_id_by_name('torpedo');

	$x = 0;
	while($x < $count) {
		dbConnect();
		$query = "INSERT INTO item (item_type_id, parent_item_id, sector_id) VALUES ($item_type_id, $parent_item_id, $sector_id)";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
		$x++;
	}
}



function getTorpedo($item_id) {
// Get/retrieve torpedo and add to player's ship inventory
// Jun 2022 | Matt Robb
//
	global $db_server;

	// Only pick up torpedo if doing so will keep ship's inventory <= 40
	$shipTorpCount = getShipTorpCount($_SESSION['shipID']);

	if ($shipTorpCount < 40) {
		dbConnect();
		$shipID = $_SESSION['shipID'];
		$query =  "UPDATE item SET parent_item_id = $shipID, sector_id = NULL WHERE item_id = $item_id";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
		$_SESSION['torp'] = getShipTorpCount($_SESSION['shipID']);
		$var = "Tractor beam retrieved <a class='object'>torpedo</a>.  Pod thrusters holding current position.<br>";
	} else {
		$var =  "Ship's torpedo tray is at capacity. There is not enough free space to add another torpedo.<br>";
	}
	return $var;
}



function dropTorpedo($item_id) {
// Drop torpedo from player's ship inventory to sector
// June 2022 | Matt Robb
//
	global $db_server;
	$sector_id = $_SESSION['sector_id'];

	dbConnect();
	$shipID = $_SESSION['shipID'];
	$query =  "UPDATE item SET parent_item_id = NULL, sector_id = $sector_id WHERE item_id = $item_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
	$_SESSION['torp'] = getShipTorpCount($_SESSION['shipID']);
	$var = "Ship's asset management system dropped <a class='object'>torpedo</a>.  Pod thrusters holding current position.<br>";
	return $var;
}



function torpTorpedo($item_id) {
// Torpedo the selected torpedo
// May 2022 | Matt Robb
//
	global $db_server;

	$sector_id = $_SESSION['sector_id'];
	$sectorTorpCount = getMatchingItemCount("torpedo", $sector_id);
	$item_type_id = get_item_type_id_by_name("torpedo");

	if ($sectorTorpCount > 6) {
		// Cascading torp explosion...
		dbConnect();
		$query = "DELETE FROM item WHERE item_type_id = $item_type_id and sector_id = $sector_id";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
		$var = "<a class='object'>Torpedo</a> caused a cascading explosion by detonating all torpedoes in sector.<br>";
	} else {
		// Only one torpedo exploded
		dbConnect();
		$query = "DELETE FROM item WHERE item_id = $item_id";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
		$var = "<a class='object'>Torpedo</a> torpedoed and eliminated from the sector.<br>";
	}

	// Get and return objects in the sector
	$objects = getSectorObjects($sector_id);

	$var .= $objects;
	return $var;
}



function getRandomTorpedoFromShip($item_id) {
// Get a torpedo from ship's inventory
// Jun 2022 | Matt Robb
//
	global $db_server;
	$item_type_id = get_item_type_id_by_name("torpedo");

	dbConnect();
	$query = "SELECT item_id FROM item WHERE parent_item_id = $item_id AND item_type_id = $item_type_id ORDER BY RAND() LIMIT 1";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$itemID = $row["item_id"];
		}
	} else {
			$itemID = null;
	}
	dbDisconnect();
	return $itemID;
}



function xferTorpedo($item_id, $count) {
// Transfer torpedo and add to another player's ship inventory
// Jun 2022 | Matt Robb
//
	global $db_server;
	$shipID = $_SESSION['shipID'];

	$x = 1;
	while($x <= $count) {
		$torpedoID = getRandomTorpedoFromShip($shipID);
		dbConnect();
		$query =  "UPDATE item SET parent_item_id = $item_id, sector_id = NULL WHERE item_id = $torpedoID";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
		$x++;
	}
	$_SESSION['torp'] = getShipTorpCount($_SESSION['shipID']);

	// Give player 1 point for each torpedo transferred to a ship
	addPlayerPoints(get_app_pointtype_id_by_name("NTR"),$x - 1);

	$var = "Tractor beam successfully transferred " . ($x - 1) . " <a class='object'>torpedo(es)</a>.  Pod thrusters holding current position.";
	return $var;
}



?>
