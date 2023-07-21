<?php
// Hastily thrown together code one week before Thanksgiving release in
// order to give appearance of more players...
// Randomly call this page from other clients to behave as NPC players
// Nov 2022 | Matt Robb
//
//
// TIP: On Linux/Unix, use edit the cron file ($: crontab -e)
// to call this page on an interval between 11 - 22 minutes
// BEGIN:
// t0to660secs="RANDOM % 661"
// */11 * * * * r=$(($t0to660secs)) ; sleep ${r}s ; curl https://series-v.com/admin/npc.php
// END:


require_once '../modDatabase.php';
require_once '../modGlobalConstants.php';
require_once '../modGame.php';


require_once '../commands/drop.php';
require_once '../commands/get.php';
require_once '../commands/go.php';
require_once '../commands/login.php';
require_once '../commands/logout.php';
require_once '../commands/probe.php';
require_once '../commands/torp.php';


// objects
require_once '../objects/asteroid.php';
require_once '../objects/barge.php';
require_once '../objects/beacon.php';
require_once '../objects/comet.php';
require_once '../objects/composite.php';
require_once '../objects/cosmicdust.php';
require_once '../objects/debris.php';
require_once '../objects/fuelrod.php';
require_once '../objects/item.php';
require_once '../objects/magneticfield.php';
require_once '../objects/player.php';
require_once '../objects/sector.php';
require_once '../objects/ship.php';
require_once '../objects/shipdebris.php';
require_once '../objects/torpedo.php';
require_once '../objects/wormhole.php';

global $db_server;


// Select a NPC at random...
$i = rand(2,26);
// echo '$i: ' . $i . '<br>';

// Assign the selected NPC details...
if ($i == 2) {
	$playerID = "2";
	$item_id = "2";
	$email = "npc1@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "New Jersey / US";

} elseif ($i == 3) {
	$playerID = "3";
	$item_id = "3";
	$email = "npc2@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "New Jersey / US";

} elseif ($i == 4) {
	$playerID = "4";
	$item_id = "4";
	$email = "npc3@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "New Jersey / US";

}	elseif ($i == 5) {
	$playerID = "5";
	$item_id = "5";
	$email = "npc4@series-v.com";
	$password = "Samjoey17";
	$stateandcountry = "New Jersey / US";

} elseif ($i == 6) {
	$playerID = "6";
	$item_id = "6";
	$email = "npc5@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "New Jersey / US";

} elseif ($i == 7) {
	$playerID = "7";
	$item_id = "7";
	$email = "npc6@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "/ US";

} elseif ($i == 8) {
	$playerID = "8";
	$item_id = "8";
	$email = "npc7@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "/ US";

} elseif ($i == 9) {
	$playerID = "9";
	$item_id = "9";
	$email = "npc8@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "/ US";

} elseif ($i == 10) {
	$playerID = "10";
	$item_id = "10";
	$email = "npc9@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Pennsylvania / US";

} elseif ($i == 11) {
	$playerID = "11";
	$item_id = "11";
	$email = "npc10@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Pennsylvania / US";

} elseif ($i == 12) {
	$playerID = "12";
	$item_id = "12";
	$email = "npc11@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Pennsylvania / US";

} elseif ($i == 13) {
	$playerID = "13";
	$item_id = "13";
	$email = "npc12@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "New York / US";

} elseif ($i == 14) {
	$playerID = "14";
	$item_id = "14";
	$email = "npc13@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "New York / US";

} elseif ($i == 15) {
	$playerID = "15";
	$item_id = "15";
	$email = "npc14@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "New York / US";

} elseif ($i == 16) {
	$playerID = "16";
	$item_id = "16";
	$email = "npc15@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "New York / US";

} elseif ($i == 17) {
	$playerID = "17";
	$item_id = "17";
	$email = "npc16@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "California / US";

} elseif ($i == 18) {
	$playerID = "18";
	$item_id = "18";
	$email = "npc17@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "California / US";

} elseif ($i == 19) {
	$playerID = "19";
	$item_id = "19";
	$email = "npc18@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Texas / US";

} elseif ($i == 20) {
	$playerID = "20";
	$item_id = "20";
	$email = "npc19@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Texas / US";

} elseif ($i == 21) {
	$playerID = "21";
	$item_id = "21";
	$email = "npc20@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Texas / US";

} elseif ($i == 22) {
	$playerID = "22";
	$item_id = "22";
	$email = "npc21@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Virginia / US";

} elseif ($i == 23) {
	$playerID = "23";
	$item_id = "23";
	$email = "npc22@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Virginia / US";

} elseif ($i == 24) {
	$playerID = "24";
	$item_id = "24";
	$email = "npc23@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Indiana / US";

} elseif ($i == 25) {
	$playerID = "25";
	$item_id = "25";
	$email = "npc24@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Indiana / US";

} else {
	$playerID = "26";
	$item_id = "26";
	$email = "npc25@series-v.com";
	$password = "insert-password-here";
	$stateandcountry = "Colorado / US";
}
// echo '$playerID: ' . $playerID . '<br>';

authenticate($email, $password);
recordNPCLoginTimestamp($playerID, $stateandcountry);
makePlayerShipVisible($item_id);

// randomly move NPC between 1 and 11 spaces...
$int = rand(1, 11);
$x = 1;
while($x <= $int) {
	randomlyMove();
	torp("SHIP");			   	// Torp a ship; only works if a single ship is found

	get("FUEL-ROD");		  // Get a fuel-rod; only works if a single rod is found
	get("COMPOSITE");		  // Get a composite; only works if a single composite is found
	get("TORPEDO");				// Get torpedo; only works if a single torpoedo is found

	torp("ASTEROID");		  // Torp an asteroid; only works if a single asteroid is found
	torp("COMET");		    // Torp a comet; only works if a single comet is found
	torp("COSMIC-DUST");	// Torp cosmic-dust; only works if a single dust cloud is found
	torp("DEBRIS");				// Torp debris; only works if a single debris is found

	probe("BEACON");		  // Probe sector, hoping to find a beacon
	probe("BARGE");			  // Probe sector, hoping to find a barge (to refuel/resupply)
	go("WORMHOLE");			  // Enter a wormhole, if one is found in sector
	// now do stuff... (probe a beacon? torp an asteroid? get something? drop something?)
	// check for fuel...
	$x++;
}

// Log NPC out of game...
logout();



function randomlyMove() {
	if ($_SESSION['fuel'] < 1 || $_SESSION['turns'] < 1) {
		// Do nothing ... stuck
	} else {
		$i = rand(1,6);

		if ($i == 1) {
			$param = "L";
		} elseif ($i == 2) {
			$param = "R";
		} elseif ($i == 3) {
			$param= "U";
		} elseif ($i == 4) {
			$param = "D";
		} elseif ($i == 5) {
			$param = "F";
		} else {
			$param = "B";
		}

		go($param);
	}
}



function recordNPCLoginTimestamp($playerID, $stateandcountry) {
// Create login timestamp for NPC
// Nov 2022 | Matt Robb
	global $db_server;
	dbConnect();
	$query = "INSERT INTO player_logins (player_id, location) VALUES ('$playerID','" . $stateandcountry . "')";
	$result = mysqli_query($db_server, $query);
	if (!$result) die ("Database access failed: " . mysql_error());
	dbDisconnect();
}



?>
