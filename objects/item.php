<?php
// DB tables: item, item_types
// Must ensure "require_once 'objects/item.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function getMatchingInventoryCount($name, $shipID) {
// Return a count of matching items when passed a name and ship value
// Jun 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
					 $query = "SELECT i.item_id, i.item_type_id, COALESCE(i.proper_name, it.name) AS name FROM item AS i, item_types AS it ";
	$query = $query . "WHERE it.item_type_id = i.item_type_id AND i.parent_item_id = '$shipID' AND (i.proper_name LIKE '$name%' OR it.name LIKE '$name%' OR i.item_id LIKE '$name%')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$count = mysqli_num_rows($result);
	dbDisconnect();
	return $count;
}



function getInventoryIDFromName($name, $shipID) {
// Return item_id from name
// Jun 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
					 $query = "SELECT i.item_id, i.item_type_id, COALESCE(i.proper_name, it.name) AS name FROM item AS i, item_types AS it ";
	$query = $query . "WHERE it.item_type_id = i.item_type_id AND i.parent_item_id = '$shipID' AND (i.proper_name LIKE '$name%' OR it.name LIKE '$name%' OR i.item_id LIKE '$name%')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$itemID = $row["item_id"];
		}
	} else {
			$itemID= null;
	}
	dbDisconnect();
	return $itemID;
}



function getInventoryByShipID($name, $shipID) {
// Return HTML-formatted item list in the hull using the shipID
// Jun 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query =  "SELECT i.item_id, i.item_type_id, COALESCE(i.proper_name, it.name) AS name FROM item AS i, item_types AS it ";
	$query .= "WHERE it.item_type_id = i.item_type_id AND i.parent_item_id = '$shipID' AND (i.proper_name LIKE '$name%' ";
	$query .= "OR it.name LIKE '$name%' OR i.item_id LIKE '$name%')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			// Leading <br> instead of lagging <br> to avoid third (extra) carriage return upon last output
			$var .= "<br> Asset No.: " . "<a class='object'>" . $row["item_id"] . "</a> - " . $row["name"];
		}
	} else {
			$var= null;
	}
	dbDisconnect();
	return $var;
}



function get_item_type_id_by_name($name) {
// Return item_type_id from table item_types where name = $name
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT it.item_type_id FROM item_types AS it WHERE name = '$name'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$item_type_id = $row["item_type_id"];
		}
	} else {
		$item_type_id = null;
	}
	dbDisconnect();
	return $item_type_id;
}



function getMatchingItemCount($name, $sector_id) {
// Return a count of matching items when passed a name and sector value
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	         $query = "SELECT i.item_id, i.item_type_id, COALESCE(i.proper_name, it.name) AS name FROM item AS i, item_types AS it ";
	$query = $query . "WHERE it.item_type_id = i.item_type_id AND i.sector_id = '$sector_id' AND (i.proper_name LIKE '$name%' OR it.name LIKE '$name%' OR i.item_id LIKE '$name%')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$count = mysqli_num_rows($result);
	dbDisconnect();
	return $count;
}



function getItemIDFromName($name, $sector_id) {
// Return item_id from name
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	         $query = "SELECT i.item_id, i.item_type_id, COALESCE(i.proper_name, it.name) AS name FROM item AS i, item_types AS it ";
	$query = $query . "WHERE it.item_type_id = i.item_type_id AND i.sector_id = '$sector_id' AND (i.proper_name LIKE '$name%' OR it.name LIKE '$name%' OR i.item_id LIKE '$name%')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$itemID = $row["item_id"];
		}
	} else {
		$itemID= null;
	}
	dbDisconnect();
	return $itemID;
}



function getItemTypeFromItemID($item_id) {
// Return proper_name or name from tables item, item_types where item_id = $item_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query =  "SELECT it.name FROM item AS i, item_types AS it WHERE it.item_type_id = i.item_type_id AND i.item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$itemType = $row["name"];
		}
	} else {
		$itemType = null;
	}
	dbDisconnect();
	return $itemType;
}



function getItemTypeFromName($name) {
// Return proper_name or name from tables item, item_types
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	         // $query = "SELECT i.item_id, i.item_type_id, COALESCE(i.proper_name, it.name) AS name FROM item AS i, item_types AS it ";
					 $query = "SELECT i.item_id, i.item_type_id, it.name AS name FROM item AS i, item_types AS it ";
	$query = $query . "WHERE it.item_type_id = i.item_type_id AND (i.proper_name LIKE '$name%' OR it.name LIKE '$name%' OR i.item_id LIKE '$name%')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$itemType = $row["name"];
		}
	} else {
		$itemType = null;
	}
	dbDisconnect();
	return $itemType;
}



function getItemsBySectorID($name, $sector_id) {
// Return HTML-formatted item list in the sector using the sector_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query =  "SELECT i.item_id, i.item_type_id, COALESCE(i.proper_name, it.name) AS name FROM item AS i, item_types AS it ";
	$query .= "WHERE it.item_type_id = i.item_type_id AND i.sector_id = '$sector_id' AND (i.proper_name LIKE '$name%' ";
	$query .= "OR it.name LIKE '$name%' OR i.item_id LIKE '$name%')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			// Leading <br> instead of lagging <br> to avoid third (extra) carriage return upon last output
			$var .= "<br> FGC: " . $_SESSION['xloc'] . "." . $_SESSION['yloc'] . "." . $_SESSION['zloc'] . ".<a class='object'>" . $row["item_id"] . "</a> - " . $row["name"];
		}
	} else {
		$var= null;
	}
	dbDisconnect();
	return $var;
}



?>
