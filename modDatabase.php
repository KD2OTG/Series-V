<?php
// Functions related to database connectivity
// Mar 2017 | Matt Robb
//

global $db_hostname, $db_database, $db_username, $db_password, $db_server;
$db_hostname = 'insert-db-hostname-here';
$db_database = 'insert-db-name-here';
$db_username = 'insert-db-username-here';
$db_password = 'insert-db-password-here';
$db_server = null;



function dbConnect() {
// Make a connection to the database
// Feb 2017 | Matt Robb
//
	global $db_hostname, $db_database, $db_username, $db_password, $db_server;
	$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
	if (!$db_server) die("Unable to connect to MySQL: " . mysql_error());
}



function dbDisconnect() {
// Make a disconnection from the database
// Feb 2017 | Matt Robb
//
	global $db_server;
	mysqli_close($db_server);
}



function sanitizeMySQL($var) {
// Sanitize strings for saving to database
// Feb 2017 | Matt Robb
//
	$var = mysql_real_escape_string($var);
	$var = sanitizeString($var);
	return $var;
}



?>
