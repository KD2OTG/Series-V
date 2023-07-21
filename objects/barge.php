<?php
// Barge
// Must ensure "require_once 'objects/barge.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function createBarge($sector_id) {
// Randomly create barge in the given sector
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Get the item_type_id from table item_types where name = 'barge'
	$item_type_id = get_item_type_id_by_name('barge');

	$int = rand(0, 1000);
	// 0.5% chance
	if ($int < 5) {
		dbConnect();
		$query = "INSERT INTO item (item_type_id, sector_id) VALUES ('$item_type_id', '$sector_id')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}
}



function createBargeDetails($item_id) {
// Randomly create barge details for the selected barge
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Series T (200-400 yrs old), U (401-600), or V (601-800)
	$series = rand(1,3);
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
	$query = "INSERT INTO item_barges (item_id, series, age_years) VALUES ('$item_id', '$series', '$age_years')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



function getBargeDetails($item_id) {
// Return details of a barge when passed an item_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_barges WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$series = $row["series"];
			$age_years = $row["age_years"];
		}
	dbDisconnect();
	} else {
		createBargeDetails($item_id);
		dbConnect();
		$query = "SELECT * FROM item_barges WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$series = $row["series"];
				$age_years = $row["age_years"];
			}
		dbDisconnect();
		} else {
			$var = null;
		}
	}
	$var = "Probe detects a ";
	// rectangular series-" . $series;
	// Get barge series
	if ($series == "T") {
		$var .= "red series-" . $series;	// T-series (200-400 yrs old)
	}	elseif ($series == "U") {
		$var .= "rectangular series-" . $series;	  // U-series (401-600 yrs old)
	}	else {
		$var .= "rusted series-" . $series;	// V-series (601-800 yrs old)
	}

	$var .= " barge commissioned " . number_format($age_years) . " years ago.";
	return $var;
}



?>
