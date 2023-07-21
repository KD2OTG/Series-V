<?php
// Composite
// Must ensure "require_once 'objects/composite.php';" is added to the "loadCommands.php" file
// 13-May-2022 | Matt Robb
//



	function createComposite($sector_id, $type) {
	// Randomly create composite(s) in the given sector
	// 13-May-2022 | Matt Robb
	//
		global $db_server;

		// Get the item_type_id from table item_types where name = 'composite'
		$item_type_id = get_item_type_id_by_name('composite');

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
				$item_id = mysqli_insert_id($db_server);	// $col[0] = item_id
				dbDisconnect();
				// Type is C, S, or M depending on the source Asteroid type
				createCompositeDetails($item_id, $type);
				$x++;
			}
		}
	}



	function createCompositeDetails($item_id, $type) {
	// Randomly create composite details for the selected composite
	// 13-May-2022 | Matt Robb
	//
		global $db_server;

		// Composite between 1 - 30 cubic meters
		$size_cubic_meters = rand(1, 30);

		// Type cooresponds to the type of asteroid from which it came
			// C-type (chrondrite) consisting of clay and silicate
			// S-type (stony) consisting of silicate and nickel-iron
			// M-type (metallic)

		if ($type == "C") {
			// C-type (chrondrite) consisting of clay and silicate
			// Most common; mostly clay and silicate (but intentional overlap w/ other elements)
			$randomness = rand(1,3);
			if ($randomness == 1) {
				// Intentional sum of < 100% to prevent rounding issue where sum exceeds total size
				$clay_m3 = ($size_cubic_meters * .6);
				$silicate_m3 = ($size_cubic_meters * .349);

			} elseif ($randomness == 2)  {
				$clay_m3 = ($size_cubic_meters * .6);
				$silicate_m3 = ($size_cubic_meters * .2);
				$nickel_iron_m3 = ($size_cubic_meters * .1);
				$iridium_m3 = ($size_cubic_meters * .049);

			} else {
				$clay_m3 = ($size_cubic_meters * .4);
				$silicate_m3 = ($size_cubic_meters * .2);
				$nickel_iron_m3 = ($size_cubic_meters * .2);
				$iridium_m3 = ($size_cubic_meters * .1);
				$palladium_m3 = ($size_cubic_meters * .049);
			}

		}	elseif ($type == "S") {
			// S-type (stony) consisting of silicate and nickel-iron
			// Next common; nickel, iridium, palladium (but intentional overlap)
			$randomness = rand(1,3);
			if ($randomness == 1) {
				// Intentional sum of < 100% to prevent rounding issue where sum exceeds total size
				$silicate_m3 = ($size_cubic_meters * .6);
				$nickel_iron_m3 = ($size_cubic_meters * .349);

			} elseif ($randomness == 2)  {
				$silicate_m3 = ($size_cubic_meters * .6);
				$nickel_iron_m3 = ($size_cubic_meters * .2);
				$iridium_m3 = ($size_cubic_meters * .1);
				$palladium_m3 = ($size_cubic_meters * .049);

			} else {
				$silicate_m3 = ($size_cubic_meters * .4);
				$nickel_iron_m3 = ($size_cubic_meters * .2);
				$iridium_m3 = ($size_cubic_meters * .2);
				$palladium_m3 = ($size_cubic_meters * .1);
				$osmium_m3 = ($size_cubic_meters * .049);
			}

		}	else {
			// M-type (metallic)
			// M - Metallic: osmium, ruthenium, rhodium (but intentional overlap)
			$randomness = rand(1,3);
			if ($randomness == 1) {
				// Intentional sum of < 100% to prevent rounding issue where sum exceeds total size
				$osmium_m3 = ($size_cubic_meters * .6);
				$ruthenium_m3 = ($size_cubic_meters * .349);

			} elseif ($randomness == 2)  {
				$osmium_m3 = ($size_cubic_meters * .5);
				$ruthenium_m3 = ($size_cubic_meters * .4);
				$rhodium_m3 = ($size_cubic_meters * .049);

			} else {
				$ruthenium_m3 = ($size_cubic_meters * .9);
				$rhodium_m3 = ($size_cubic_meters * .049);
			}

		}

		dbConnect();
		$query =  "INSERT INTO item_composites (item_id, type, size_cubic_meters, clay_cubic_meters, silicate_cubic_meters, nickel_iron_cubic_meters, ";
		$query .= "iridium_cubic_meters, palladium_cubic_meters, osmium_cubic_meters, ruthenium_cubic_meters, rhodium_cubic_meters) VALUES (";
		$query .= "'$item_id', '$type', '$size_cubic_meters', '$clay_m3', '$silicate_m3', '$nickel_iron_m3', '$iridium_m3', '$palladium_m3', '$osmium_m3', '$ruthenium_m3', '$rhodium_m3')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}



function dropComposite($item_id) {
// Drop composite from player's ship inventory to sector
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
	$_SESSION['cargoPercent'] = getShipCargoPercent($_SESSION['shipID']);
	$var = "Ship's asset management system dropped <a class='object'>composite</a>.  Pod thrusters holding current position.<br>";
	return $var;
}



	function getComposite($item_id) {
	// Get/retrieve composite and add to player's ship inventory
	// May 2022 | Matt Robb
	//
		global $db_server;

		// Only pick up composite if doing so will keep ship's cargo < 600 cubic meters (100%)
		$shipCargoPercent = getShipCargoPercent($_SESSION['shipID']);
		$size_cubic_meters = getCompositeSizeCubicMeters($item_id);

		if (($shipCargoPercent + $size_cubic_meters) <= 100.00) {
			dbConnect();
			$shipID = $_SESSION['shipID'];
			$query =  "UPDATE item SET parent_item_id = $shipID, sector_id = NULL WHERE item_id = $item_id";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			dbDisconnect();
			$_SESSION['cargoPercent'] = getShipCargoPercent($_SESSION['shipID']);
			$var = "Tractor beam retrieved <a class='object'>composite</a>.  Pod thrusters holding current position.<br>";
		} else {
			$var =  "The targeted composite measures " . number_format($size_cubic_meters) . " cubic meters and is too large to fit in the ship's cargo hold.<br>";
		}
		return $var;
	}



	function getCompositeDetails($item_id) {
	// Return details of a composite when passed an item_id
	// 13-May-2022 | Matt Robb
	//
		global $db_server;

		dbConnect();
		$query = "SELECT * FROM item_composites WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$type = $row["type"];
				$size_cubic_meters = $row["size_cubic_meters"];
				$clay_cubic_meters = $row["clay_cubic_meters"];
				$silicate_cubic_meters = $row["silicate_cubic_meters"];
				$nickel_iron_cubic_meters = $row["nickel_iron_cubic_meters"];
				$iridium_cubic_meters = $row["iridium_cubic_meters"];
				$palladium_cubic_meters = $row["palladium_cubic_meters"];
				$osmium_cubic_meters = $row["osmium_cubic_meters"];
				$ruthenium_cubic_meters = $row["ruthenium_cubic_meters"];
				$rhodium_cubic_meters = $row["rhodium_cubic_meters"];
			}
		dbDisconnect();
		} else {
// Eventually, composite details won't be created here, but will instead be created at time composite item is created
				createCompositeDetails($item_id, "M");
				dbConnect();
				$query = "SELECT * FROM item_composites WHERE item_id = '$item_id'";
				$result = mysqli_query($db_server, $query);
				if (!$result) die ("Database access failed: " . mysql_error());
				if (mysqli_num_rows($result) > 0) {
					// Output data of each row
					while ($row = mysqli_fetch_assoc($result)) {
						$type = $row["type"];
						$size_cubic_meters = $row["size_cubic_meters"];
						$clay_cubic_meters = $row["clay_cubic_meters"];
						$silicate_cubic_meters = $row["silicate_cubic_meters"];
						$nickel_iron_cubic_meters = $row["nickel_iron_cubic_meters"];
						$iridium_cubic_meters = $row["iridium_cubic_meters"];
						$palladium_cubic_meters = $row["palladium_cubic_meters"];
						$osmium_cubic_meters = $row["osmium_cubic_meters"];
						$ruthenium_cubic_meters = $row["ruthenium_cubic_meters"];
						$rhodium_cubic_meters = $row["rhodium_cubic_meters"];
					}
				dbDisconnect();
				} else {
						$var = null;
				}
		}
		// Determine the original asteroid type
		if ($type == "C") {
			$type = "chrondrite";
		} elseif ($type == "S") {
			$type = "stony";
		} else {
			$type = "metallic";
		}

		$var =  "Probe detects a " . $type . " asteroid composite measuring " . number_format($size_cubic_meters) . " cubic meters. ";
		$var .= "<br><br>Component parts in cubic meters:";
		$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;clay:&nbsp;" . $clay_cubic_meters;
		$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;silicate:&nbsp;" . $silicate_cubic_meters;
		$var .= "<br>&nbsp;&nbsp;nickel-iron:&nbsp;" . $nickel_iron_cubic_meters;
		$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;iridium:&nbsp;" . $iridium_cubic_meters;
		$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;palladium:&nbsp;" . $palladium_cubic_meters;
		$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;osmium:&nbsp;" . $osmium_cubic_meters;
		$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;ruthenium:&nbsp;" . $ruthenium_cubic_meters;
		$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;rhodium:&nbsp;" . $rhodium_cubic_meters;
		return $var;
	}



	function getCompositeSizeCubicMeters($item_id) {
	// Return size of cubic meters of composite when passed an item_id
	// May 2022 | Matt Robb
	//
		global $db_server;

		dbConnect();
		$query = "SELECT * FROM item_composites WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$size_cubic_meters = $row["size_cubic_meters"];
			}
		dbDisconnect();
		return $size_cubic_meters;
		}
	}



	function get_app_pointtype_id_by_name($name) {
	// Return app_pointtype_id from table app_point_type where name = $name
	// Jul 2022 | Matt Robb
	//
		global $db_server;

		dbConnect();
		$query = "SELECT apt.app_pointtype_id FROM app_pointtype AS apt WHERE name = '$name'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$app_pointtype_id = $row["app_pointtype_id"];
			}
		} else {
			$app_pointtype_id = null;
		}
		dbDisconnect();
		return $app_pointtype_id;
	}



	function torpComposite($item_id) {
	// Torpedo the selected composite
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

		$var = "<a class='object'>Composite</a> torpedoed and eliminated from the sector.<br>";
		$var .= $objects;
		return $var;
	}



	function transferComposites($item_id) {
	// Transfer composites from player's ship to Station or Barge
	// Jun 2022 | Matt Robb
	//
		global $db_server;

		// Get composite details
		$composite_id = get_item_type_id_by_name("composite");

		dbConnect();
		$query = "SELECT ";
		$query .= "COALESCE(SUM(size_cubic_meters),0) AS sumSize, ";
		$query .= "COALESCE(SUM(clay_cubic_meters),0) AS sumClay, ";
		$query .= "COALESCE(SUM(silicate_cubic_meters),0) AS sumSilicate, ";
		$query .= "COALESCE(SUM(nickel_iron_cubic_meters),0) AS sumNickelIron, ";
		$query .= "COALESCE(SUM(iridium_cubic_meters),0) AS sumIridium, ";
		$query .= "COALESCE(SUM(palladium_cubic_meters),0) AS sumPalladium, ";
		$query .= "COALESCE(SUM(osmium_cubic_meters),0) AS sumOsmium, ";
		$query .= "COALESCE(SUM(ruthenium_cubic_meters),0) AS sumRuthenium, ";
		$query .= "COALESCE(SUM(rhodium_cubic_meters),0) AS sumRhodium ";
		$query .= "FROM item AS i, item_composites AS c WHERE i.parent_item_id = '$item_id' AND i.item_type_id = '$composite_id' AND i.item_id = c.item_id";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$sumClay = (int) $row["sumClay"];
				$sumSilicate = (int) $row["sumSilicate"];
				$sumNickelIron = (int) $row["sumNickelIron"];
				$sumIridium = (int) $row["sumIridium"];
				$sumPalladium = (int) $row["sumPalladium"];
				$sumOsmium = (int) $row["sumOsmium"];
				$sumRuthenium = (int) $row["sumRuthenium"];
				$sumRhodium = (int) $row["sumRhodium"];
			}
		}
		dbDisconnect();

		// Give player points for various composites; points hard-coded and not yet pulled from DB record
		if ($sumClay > 0) {
			addPlayerPoints(get_app_pointtype_id_by_name("MCC"), (1 * $sumClay));
		}
		if ($sumSilicate > 0) {
			addPlayerPoints(get_app_pointtype_id_by_name("MSC"), (1 * $sumSilicate));
		}
		if ($sumNickelIron > 0) {
			addPlayerPoints(get_app_pointtype_id_by_name("MNIC"), (1 * $sumNickelIron));
		}
		if ($sumIridium > 0) {
			addPlayerPoints(get_app_pointtype_id_by_name("MIC"), (2 * $sumIridium));
		}
		if ($sumPalladium > 0) {
			addPlayerPoints(get_app_pointtype_id_by_name("MPC"), (2 * $sumPalladium));
		}
		if ($sumOsmium > 0) {
			addPlayerPoints(get_app_pointtype_id_by_name("MOC"), (3 * $sumOsmium));
		}
		if ($sumRuthenium > 0) {
			addPlayerPoints(get_app_pointtype_id_by_name("MRC"), (3 * $sumRuthenium));
		}
		if ($sumRhodium > 0) {
			addPlayerPoints(get_app_pointtype_id_by_name("MRHC"), (3 * $sumRhodium));
		}

		// Delete all composites from player's ship, as they've been "turned in"
		dbConnect();
		$query = "DELETE FROM item WHERE parent_item_id = $item_id AND item_type_id = $composite_id";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
		$_SESSION['cargoPercent'] = getShipCargoPercent($_SESSION['shipID']);
		return;
	}



?>
