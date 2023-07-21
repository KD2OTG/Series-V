<?php
// Functions pertaining to string manipulation
// Mar 2017 | Matt Robb
//



function sanitizeString($var) {
// Sanitize strings for displaying on output and passing parameters to database
// Feb 2017 | Matt Robb
//
	$var = stripslashes($var);
	$var = htmlentities($var);
	$var = strip_tags($var);
	return $var;
}



function extractCommand($var) {
// Extract the first word/command and convert to uppercase
// Mar 2022 | Matt Robb
//
	$pos = strpos($var," ");						// Position of first space character in string
	if ($pos == false) { 								// If no space character included, the entire string is assumed the command
		$pos = strlen($var);
	}
	$var = substr($var,0,$pos);					// Extract the left-most word, it is assumed the command

	if (!$_SESSION['createAccountProcedure'] == "" || !$_SESSION['loginProcedure'] == "" || !$_SESSION['resetPasswordProcedure'] == "") {
	// CREATE or LOGIN or FORGOT procedure, so don't convert to upper case
	} else {
		$var = strtoupper($var);
	}
	return $var;
}



function extractParams($var) {
// Extract the parameters (all text) after the first word/command
// Feb 2017 | Matt Robb
//
	$pos = strpos($var," ");						// Position of first space character in string
	if ($pos == false) {								// If no space character included, the entire string is assumed the command
		$pos = strlen($var);
		return "";
	}
	$var = substr($var,$pos + 1);
	//	$var = strtoupper($var);
	return $var;
}



function show80columns() {
// Show an 80-column ruler, for debugging purposes
// Feb 2017 | Matt Robb
//
	$var = "<br>|--------1---------2---------3---------4---------5---------6---------7---------8<br>";
	return $var;
}



?>
