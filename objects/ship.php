<?php
// Ship
// Must ensure "require_once 'objects/ship.php';" is added to the "loadCommands.php" file
// May 2022 | Matt Robb
//



function createShipDetails($item_id) {
// Randomly create ship details for the selected ship
// May 2022 | Matt Robb
//
	global $db_server;

	// Force a Series-V ship
	// Series T (200-400 yrs old), U (401-600), or V (601-800)
	// $series = rand(1,3);
	$series = 3;
	if ($series == 1) {
		$series = "T";	// T-series (200-400 yrs old)
		$age_years = rand(200, 400);
	}	elseif ($series == 2) {
		$series = "U";	// U-series (401-600 yrs old)
		$age_years = rand(401, 600);
	}	else {
		$series = "V";	// V-series (601-800 yrs old)
		$age_years = rand(601, 800);
	}

	dbConnect();
	// At present, it will always be a Mining ship so that value is hard-coded
	$query = "INSERT INTO item_ships (item_id, type, series, age_years) VALUES ('$item_id', 'mining', '$series', '$age_years')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function getShipCargoPercent($item_id) {
// Update a ship's cargo percent from the $item_id
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	// Get composite details
	$composite_id = get_item_type_id_by_name("composite");
	dbConnect();
	$query = "SELECT ";
	$query .= "COALESCE(SUM(size_cubic_meters),0) AS sumSize ";
	$query .= "FROM item AS i, item_composites AS c WHERE i.parent_item_id = '$item_id' AND i.item_type_id = '$composite_id' AND i.item_id = c.item_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var = round((($row["sumSize"] / 600)*100));
		}
	} else {
		 // Do nothing
	}
	dbDisconnect();
	return $var;
}



function getShipFuelPercent($item_id) {
// Get a ship's fuel percent from the $item_id
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	// Get fuel-rod details
	$fuelrod_id = get_item_type_id_by_name("fuel-rod");
	dbConnect();
	$query = "SELECT ";
	$query .= "COALESCE(SUM(length_centimeters),0) AS sumLengthCentimeters ";
	$query .= "FROM item AS i, item_fuel_rods AS fr WHERE i.parent_item_id = '$item_id' AND i.item_type_id = '$fuelrod_id' AND i.item_id = fr.item_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var = $row["sumLengthCentimeters"];
		}
	} else {
	 	// Do nothing
	}
	dbDisconnect();
	return $var;
}



function getShipTorpCount($item_id) {
// Get a ship's torpedo count from the $item_id
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	// Get composite details
	$torpedo_id = get_item_type_id_by_name("torpedo");
	dbConnect();
	$query = "SELECT COALESCE(COUNT(item_type_id),0) AS TorpedoCount FROM item WHERE parent_item_id = '$item_id' AND item_type_id = '$torpedo_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var = $row["TorpedoCount"];
		}
	} else {
	 	// Do nothing
	}
		dbDisconnect();
		return $var;
}



function getRandomShipName() {
// Return a random ship name - unused - for assignment at account provisioning
// May 2022 | Matt Robb
//
		global $db_server;

		dbConnect();
		$query = "SELECT * FROM app_ship_names WHERE is_used = 0 ORDER BY RAND() LIMIT 1";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$var = $row["ship_name"];
			}
		}
		// Now update record so this ship name won't be used again
		$query = "UPDATE app_ship_names SET is_used = 1 WHERE ship_name = '$var'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
		return $var;
}



function getShipName($item_id) {
// Return a ship name from the $item_id
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT proper_name FROM item WHERE item_id = $item_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var = $row["proper_name"];
		}
	}
	dbDisconnect();
	return $var;
}



function getShipDetails($item_id) {
// Return details and items of a ship when passed an item_id
// May 2022 | Matt Robb
//
	global $db_server;

	$ship_name = getShipName($item_id);
	$player_alias = getPlayerAlias($item_id);

	dbConnect();
	$query = "SELECT * FROM item_ships WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$type = $row["type"];
			$series = $row["series"];
			$age_years = $row["age_years"];
		}
	dbDisconnect();
	} else {
		createShipDetails($item_id);
		dbConnect();
		$query = "SELECT * FROM item_ships WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$type = $row["type"];
				$series = $row["series"];
				$age_years = $row["age_years"];
			}
		dbDisconnect();
		} else {
			$var = null;
		}
	}

	$var  = "Probe detects <a class='object'>" . $ship_name . "</a> as a series-" . $series . " " . $type . " ship ";
	$var .= "currently captained by <a class='direction'> " . $player_alias . "</a>, a humanoid. The ship was first placed in service " . $age_years . " years ago ";
	$var .= "and has a standard cargo holding capacity of 600 cubic meters. ";
	$var .= "<br><br>Hull contents include:<br><br>";
	$var .= "Provisions:";

	// Get fuel-rod details
	$fuelrod_id = get_item_type_id_by_name("fuel-rod");
	dbConnect();
	$query =  "SELECT ";
	$query .= "COALESCE(COUNT(item_fuelrod_id),0) AS countRods, ";
	$query .= "COALESCE(SUM(length_centimeters),0) AS sumCentimeters ";
	$query .= "FROM item AS i, item_fuel_rods AS fr WHERE i.parent_item_id = '$item_id' AND i.item_type_id = '$fuelrod_id' AND i.item_id = fr.item_id";

	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;fuel-rods: " . $row["countRods"] . " measuring " . round($row["sumCentimeters"]) . " centimeters in total";
		}
	} else {
	 $var .= "<br>";
	}
	dbDisconnect();

	// Get torpedo details
	$torpedo_id = get_item_type_id_by_name("torpedo");
	dbConnect();
	$query = "SELECT COALESCE(COUNT(item_type_id),0) AS TorpedoCount FROM item WHERE parent_item_id = '$item_id' AND item_type_id = '$torpedo_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;torpedoes:&nbsp;" . $row["TorpedoCount"];
		}
	} else {
	 $var .= "<br>";
	}
	dbDisconnect();

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
			$var .= "<br><br>Cargo hold is " . round((($row["sumSize"] / 600)*100)) . "% full (material in cubic meters):";
			$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;clay: " . $row["sumClay"];
			$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;silicate: " . $row["sumSilicate"];
			$var .= "<br>&nbsp;&nbsp;nickel-iron: " . $row["sumNickelIron"];
			$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;iridium: " . $row["sumIridium"];
			$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;palladium: " . $row["sumPalladium"];
			$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;osmium: " . $row["sumOsmium"];
			$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;ruthenium: " . $row["sumRuthenium"];
			$var .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;rhodium: " . $row["sumRhodium"];
		}
	} else {
	 $var .= "<br>";
	}
	dbDisconnect();
	return $var;
}



function refuelShip($item_id) {
// Refuel a player's ship up to 100.00
// May 2022 | Matt Robb
//
	$shipFuelPercent = getShipFuelPercent($_SESSION['shipID']);
	$fuelToCreate = (100.00 - $shipFuelPercent);
	$numFullRods = ($fuelToCreate / 20);

	// Get the item_type_id from table item_types where name = 'fuel-rod'
	$item_type_id = get_item_type_id_by_name('fuel-rod');
	$x = 1;
	while($x <= $numFullRods) {
		createFuelRod($_SESSION['shipID'], "", 20);
		$_SESSION['fuel'] = getShipFuelPercent($_SESSION['shipID']);
		$x++;
	}

	// Create one rod with remainder
	$shipFuelPercent = getShipFuelPercent($_SESSION['shipID']);
	$fuelToCreate = (100.00 - $shipFuelPercent);
	$numFullRods = ($fuelToCreate / 20);
	if ($fuelToCreate > 0.00 && $numFullRods < 1) {
		createFuelRod($_SESSION['shipID'], "", $fuelToCreate);
		$_SESSION['fuel'] = getShipFuelPercent($_SESSION['shipID']);
	}
}



function reTorpShip($item_id) {
// Refill a player's ship with torpedoes up to 40
// May 2022 | Matt Robb
//
	$shipTorpCount = getShipTorpCount($_SESSION['shipID']);
	$numTorpToCreate = (40 - $shipTorpCount);
	createTorpedo($item_id, "", $numTorpToCreate);
	$_SESSION['torp'] = getShipTorpCount($_SESSION['shipID']);
}



function torpShip($item_id) {
// Torpedo the selected ship to jostle loose fuel and composites
// Jun 2022 | Matt Robb
//
	global $db_server;

	$int = rand(1, 4);
	$fuel_rod_id = get_item_type_id_by_name("fuel-rod");
	$composite_id = get_item_type_id_by_name("composite");
	$torpedo_id = get_item_type_id_by_name("torpedo");
	$sector_id = $_SESSION['sector_id'];
	$num = 0;

	// Get number of fuel rods in ship
	dbConnect();
	$query = "SELECT * FROM item WHERE parent_item_id = $item_id AND item_type_id = $fuel_rod_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$fuel_row_cnt = mysqli_num_rows($result);
	dbDisconnect();

	// Get number of composites in ship
	dbConnect();
	$query = "SELECT * FROM item WHERE parent_item_id = $item_id AND item_type_id = $composite_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$composite_row_cnt = mysqli_num_rows($result);
	dbDisconnect();

	// Get number of torpedoes in ship
	dbConnect();
	$query = "SELECT * FROM item WHERE parent_item_id = $item_id AND item_type_id = $torpedo_id";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	$torpedo_row_cnt = mysqli_num_rows($result);
	dbDisconnect();

	if ($int == 1) { 					// Jostle fuel-rods only
		$num = rand(0,$fuel_row_cnt);
		$x = 1;
		while($x <= $num && $x > 0) {
			// Get the first fuel-rod ID to jostle free
			dbConnect();
			$query =  "SELECT item_id FROM item WHERE parent_item_id = $item_id AND item_type_id = $fuel_rod_id ORDER BY RAND() LIMIT 1";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			if (mysqli_num_rows($result) > 0) {
			// Output data of each row
				while ($row = mysqli_fetch_assoc($result)) {
					$the_id = $row["item_id"];
				}
			dbDisconnect();

			// Update the fuel-rod to place it in the sector
			dbConnect();
			$query =  "UPDATE item SET parent_item_id = NULL, sector_id = $sector_id WHERE item_id = $the_id";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			dbDisconnect();
			$x++;
			$f_cnt = $num;
			}
		}

	} elseif ($int == 2) {								// Jostle composites only
		$num = rand(0,$composite_row_cnt);
		$x = 1;
		while($x <= $num && $x > 0) {
			// Get the first composite ID to jostle free
			dbConnect();
			$query =  "SELECT item_id FROM item WHERE parent_item_id = $item_id AND item_type_id = $composite_id ORDER BY RAND() LIMIT 1";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			if (mysqli_num_rows($result) > 0) {
			// Output data of each row
				while ($row = mysqli_fetch_assoc($result)) {
					$the_id = $row["item_id"];
				}
			dbDisconnect();

			// Update the composite to place it in the sector
			dbConnect();
			$query =  "UPDATE item SET parent_item_id = NULL, sector_id = $sector_id WHERE item_id = $the_id";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			dbDisconnect();
			$x++;
			$c_cnt = $num;
			}
		}

	} elseif ($int == 3) {								// Jostle torpedoes only
		$num = rand(0,$torpedo_row_cnt);
		$x = 1;
		while($x <= $num && $x > 0) {
			// Get the first torpedo ID to jostle free
			dbConnect();
			$query =  "SELECT item_id FROM item WHERE parent_item_id = $item_id AND item_type_id = $torpedo_id ORDER BY RAND() LIMIT 1";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			if (mysqli_num_rows($result) > 0) {
			// Output data of each row
				while ($row = mysqli_fetch_assoc($result)) {
					$the_id = $row["item_id"];
				}
			dbDisconnect();

			// Update the torpedo to place it in the sector
			dbConnect();
			$query =  "UPDATE item SET parent_item_id = NULL, sector_id = $sector_id WHERE item_id = $the_id";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			dbDisconnect();
			$x++;
			$t_cnt = $num;
			}
		}

	} else {									// Jostle fuel, composites, and torpedoes
		$num = rand(0,$fuel_row_cnt);
		$x = 1;
		while($x <= $num && $x > 0) {
			// Get the first fuel-rod ID to jostle free
			dbConnect();
			$query =  "SELECT item_id FROM item WHERE parent_item_id = $item_id AND item_type_id = $fuel_rod_id ORDER BY RAND() LIMIT 1";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			if (mysqli_num_rows($result) > 0) {
			// Output data of each row
				while ($row = mysqli_fetch_assoc($result)) {
					$the_id = $row["item_id"];
				}
			dbDisconnect();

			// Update the fuel-rod to place it in the sector
			dbConnect();
			$query =  "UPDATE item SET parent_item_id = NULL, sector_id = $sector_id WHERE item_id = $the_id";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			dbDisconnect();
			$x++;
			$f_cnt = $num;
			}
		}

		$num = rand(0,$composite_row_cnt);
		$x = 1;
		while($x <= $num && $x > 0) {
			// Get the first composite ID to jostle free
			dbConnect();
			$query =  "SELECT item_id FROM item WHERE parent_item_id = $item_id AND item_type_id = $composite_id ORDER BY RAND() LIMIT 1";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$the_id = $row["item_id"];
			}
			dbDisconnect();

			// Update the composite to place it in the sector
			dbConnect();
			$query =  "UPDATE item SET parent_item_id = NULL, sector_id = $sector_id WHERE item_id = $the_id";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			dbDisconnect();
			$x++;
			$c_cnt = $num;
			}

		$num = rand(0,$torpedo_row_cnt);
		$x = 1;
		while($x <= $num && $x > 0) {
			// Get the first torpedo ID to jostle free
			dbConnect();
			$query =  "SELECT item_id FROM item WHERE parent_item_id = $item_id AND item_type_id = $torpedo_id ORDER BY RAND() LIMIT 1";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			if (mysqli_num_rows($result) > 0) {
			// Output data of each row
				while ($row = mysqli_fetch_assoc($result)) {
					$the_id = $row["item_id"];
				}
			dbDisconnect();

			// Update the torpedo to place it in the sector
			dbConnect();
			$query =  "UPDATE item SET parent_item_id = NULL, sector_id = $sector_id WHERE item_id = $the_id";
			$result = mysqli_query($db_server, $query);
			if (!$result) die ("Database access failed: " . mysql_error());
			dbDisconnect();
			$x++;
			$t_cnt = $num;
			}
		}
		}
	}

	// Get ship name
	$ship_name = getShipName($item_id);

	// ensure placeholders aren't NULL
	if ($f_cnt == NULL) {
		$f_cnt = 0;
	}
	if ($c_cnt == NULL) {
		$c_cnt = 0;
	}
	if ($t_cnt == NULL) {
		$t_cnt = 0;
	}

	// Give player negative 150 points for torpedoeing a ship
	addPlayerPoints(get_app_pointtype_id_by_name("NST"),-150);

	$var =  "Torpedo struck and detonated against the hull of <a class='object'>". $ship_name . "</a>. The hull was not breached, but hatches have malfunctioned ";
	$var .= "causing the release of ";
	$var .= "<a class='object'>fuel-rods (" . $f_cnt . ")</a>, ";
	$var .= "<a class='object'>composites (" . $c_cnt . ")</a>, and ";
	$var .= "<a class='object'>torpedoes (" . $t_cnt . ")</a> into the sector.<br>";
	// Get and return objects in the sector
	$objects = getSectorObjects($_SESSION['sector_id']);

	$var .= $objects;
	return $var;
}



?>
