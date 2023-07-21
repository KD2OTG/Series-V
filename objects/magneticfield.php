<?php
// Magnetic Field
// Must ensure "require_once 'objects/magneticfield.php';" is added to the "loadCommands.php" file
// Apr 2022 | Matt Robb
//



function createMagneticField($sector_id) {
// Randomly create magnetic field in the given sector
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Get the item_type_id from table item_types where name = 'magnetic-field'
	$item_type_id = get_item_type_id_by_name('magnetic-field');

	$int = rand(0, 5000);
	// 0.02% chance
	if ($int < 1) {
		dbConnect();
		$query = "INSERT INTO item (item_type_id, sector_id) VALUES ('$item_type_id', '$sector_id')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}
}



function createMagneticFieldDetails($item_id) {
// Randomly create magnetic-field details for the selected magnetic-field
// Apr 2022 | Matt Robb
//
	global $db_server;

	// Polarity P = Positive, or N = Negative
	$polarity = rand(1,2);
	if ($polarity == 1) {
		$polarity = "P";	// Positive polarity
	}	else {
		$polarity = "N";	// Negative polarity
	}

	dbConnect();
	$query = "INSERT INTO item_magnetic_fields (item_id, polarity) VALUES ('$item_id', '$polarity')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();

	// Give player 25 points for discovering a magnetic field
	addPlayerPoints(16,25);
}



function getMagneticFieldDetails($item_id) {
// Return details of a magnetic-field when passed an item_id
// Apr 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_magnetic_fields WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$polarity = $row["polarity"];
		}
	dbDisconnect();
	} else {
		createMagneticFieldDetails($item_id);
		dbConnect();
		$query = "SELECT * FROM item_magnetic_fields WHERE item_id = '$item_id'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
			// Output data of each row
			while ($row = mysqli_fetch_assoc($result)) {
				$polarity = $row["polarity"];
			}
		dbDisconnect();
		} else {
			$var = null;
		}
	}
	$var = "Probe detects a ";
	// Get magnetic-field polarity
	if ($polarity == "P") {
		$var .= "positive charged";
	}	else {
		$var .= "negative charged";
	}

	$var .= " magnetic-field.";
	return $var;
}



function getMagneticFieldPolarity($item_id) {
// Return polarity of a magnetic-field when passed an item_id
// May 2022 | Matt Robb
//
	global $db_server;

	dbConnect();
	$query = "SELECT * FROM item_magnetic_fields WHERE item_id = '$item_id'";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	if (mysqli_num_rows($result) > 0) {
		// Output data of each row
		while ($row = mysqli_fetch_assoc($result)) {
			$polarity = $row["polarity"];
		}
	dbDisconnect();
	$var = $polarity;
	return $var;
	}
}



?>
