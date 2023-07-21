<?php
// Take actions to reset the game ... used for debugging
// Ensure this script doesn't stay on PROD system; as a web crawler might find it
// allowing an individual to run it.
// Jul 2022 | Matt Robb
//

require_once 'fakecron.php';
require_once 'modDatabase.php';
require_once 'objects/fuelrod.php';
require_once 'objects/item.php';
require_once 'objects/sector.php';
require_once 'objects/torpedo.php';



moveShipsToSectorZero();
makeShipsInvisible();
deleteNonCoreItems();
deleteBeaconActivations();
deletePlayerPoints();
deletePlayerLogins(); // Leave player log-ins intact for now between games; demonstrates activity?
deleteNonCoreSectors();
// reindexShips();		// 30-Jun-23; run this, but then comment and run entire script again to populate ships with fuel and torps
reloadShips();
resetDailyTurns();



function deleteBeaconActivations() {
// Delete beacon activations
// Jul 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "DELETE FROM item_beacon_activations";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function deleteNonCoreItems() {
// Delete non-core items
// Core items include:  STATION; SHIP;
// Jul 2022 | Matt Robb
//
	global $db_server;

	$s1 = get_item_type_id_by_name("station");
	$s2 = get_item_type_id_by_name("ship");

	dbConnect();
	// $query = "DELETE FROM item WHERE parent_item_id IS NULL AND item_type_id NOT IN($s1, $s2)";
	$query = "DELETE FROM item WHERE item_type_id NOT IN($s1, $s2)";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function deleteNonCoreSectors() {
// Delete non-core sectors
// Core sectors include:  0.0.0;
// Jul 2022 | Matt Robb
//
	global $db_server;

	$s1 = get_sector_id_by_coord(0, 0, 0);

	dbConnect();
	$query = "DELETE FROM sector WHERE sector_id NOT IN($s1)";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function deletePlayerLogins() {
// Delete player logins
// Jul 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "DELETE FROM player_logins";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function deletePlayerPoints() {
// Delete player points
// Jul 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "DELETE FROM player_points";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function makeShipsInvisible() {
// Make all ships sitting in sector 0.0.0 as invisible
// Jul 2022 | Matt Robb
//
	global $db_server;

	$item_type_id = get_item_type_id_by_name("ship");

	dbConnect();
	$query = "UPDATE item SET is_visible = false WHERE item_type_id = $item_type_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function moveShipsToSectorZero() {
// Move all ships to sector 0.0.0
// Jul 2022 | Matt Robb
//
	global $db_server;

	$sector_id = get_sector_id_by_coord(0, 0, 0);

	dbConnect();
	$query = "UPDATE item SET sector_id = $sector_id WHERE proper_name IS NOT NULL";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function reindexShips() {
// re-index the item_id value of all ships
// Jul 2022 | Matt Robb
//
	global $db_server;

	$item_type_id = get_item_type_id_by_name("ship");

	dbConnect();
	$query = "SELECT * FROM item WHERE item_type_id = $item_type_id ORDER BY proper_name";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		$x = 2;																// Start with #2, as Station-14 is item_id = 1
		while ($row = mysqli_fetch_assoc($result)) {
			echo $row["item_id"] . "<br>";
			$item_id = $row["item_id"];
			$query2 = "UPDATE item SET item_id = $x WHERE item_id = $item_id";
			echo $query2 . "<br><br>";
			$result2 = mysqli_query($db_server, $query2);
			if (!$result2) die ("Database access failed: " . mysql_error());
			$x++;
			}
		}
		// Alter table reset item_id index for future records...
		$query = "ALTER TABLE item AUTO_INCREMENT = 1001";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());

	dbDisconnect();
}



function reloadShips() {
// reload all ships with 40 torpedoes and 100% fuel
// Jul 2022 | Matt Robb
//
	global $db_server;

	$item_type_id = get_item_type_id_by_name("ship");

	dbConnect();
	$query = "SELECT item_id FROM item WHERE item_type_id = $item_type_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$item_id = $row["item_id"];

			// Load ship with 40 torpedoes
			createTorpedo($item_id, "", 40);

			// Load ship with 5, 20cm fuel-rods
			$x = 1;
			while($x <= 5) {
				createFuelRod($item_id, "", 20.00);
			$x++;
			}
		}
	// dbDisconnect() commented out by MR to prevent error message from
	// appearing, as connection is also closed
	// in createTorpedo() and createFuelRod() above
	// dbDisconnect();
	}
}



?>
