<?php
// This file processes all player commands entered from the UI as posted to from
// the 'processCommand.php' file.
//
// 23-Mar-2022 | Matt Robb
//
	session_start(); 	// Trigger use of session variables

	require_once 'loadCommands.php';
	require_once 'modDatabase.php';
	require_once 'modGame.php';
	require_once 'modGlobalConstants.php';
	require_once 'modStrings.php';
	require_once 'modMail.php';

	// Assign the inputted text to the variable
	$input = sanitizeString($_POST['txtInput']);		// Any text inputted by the user is sanitized before going further
	$command = extractCommand($input);							// Text returned as all capital letters for comparison purposes
	$param = extractParams($input);									// Text returned as all capital letters for comparison purposes


	// If user is logged in but a game is not underway,
	// don't accept any game commands
		$result = isGameActive();
		$isActive = $result["isActive"];
		if (($isActive == false) && (isset($_SESSION['alias']))) {
				$command = "LOGOUT";
		}


	// Skip the large switch statement below if user is trying to log into game
	if ($_SESSION['loginProcedure'] == 1) {
		echo login($command) . "<br>";
	} elseif ($_SESSION['loginProcedure'] == 2) {
		echo login($command) . "<br>";
	} elseif ($_SESSION['loginProcedure'] == 3) {
		echo login($command) . "<br>";
	}

	// Skip the large switch statement below if user is trying to create an account
	if ($_SESSION['createAccountProcedure'] == 1) {
		echo enroll($command) . "<br>";
	} elseif ($_SESSION['createAccountProcedure'] == 2) {
		echo enroll($command) . "<br>";
	} elseif ($_SESSION['createAccountProcedure'] == 3) {
		echo enroll($command) . "<br>";
	} elseif ($_SESSION['createAccountProcedure'] == 4) {
		echo enroll($command) . "<br>";
	} elseif ($_SESSION['createAccountProcedure'] == 5) {
		echo enroll($command) . "<br>";
	} elseif ($_SESSION['createAccountProcedure'] == 6) {
		echo enroll($command) . "<br>";
	} elseif ($_SESSION['createAccountProcedure'] == 7) {
		echo enroll($command) . "<br>";
	} elseif ($_SESSION['createAccountProcedure'] == 8) {
		echo enroll($command) . "<br>";
	} elseif ($_SESSION['createAccountProcedure'] == 9) {
		echo enroll($command) . "<br>";
	} elseif ($_SESSION['createAccountProcedure'] == 10) {
		echo enroll($command) . "<br>";
	} elseif ($_SESSION['createAccountProcedure'] == 11) {
		echo enroll($command) . "<br>";
	}

	// Skip the large switch statement below if user is trying to reset a forgotten password
	if ($_SESSION['resetPasswordProcedure'] == 1) {
		echo forgot($command) . "<br>";
	} elseif ($_SESSION['resetPasswordProcedure'] == 2) {
		echo  forgot($command) . "<br>";
	} elseif ($_SESSION['resetPasswordProcedure'] == 3) {
		echo  forgot($command) . "<br>";
	} elseif ($_SESSION['resetPasswordProcedure'] == 4) {
		echo  forgot($command) . "<br>";
	} elseif ($_SESSION['resetPasswordProcedure'] == 5) {
		echo  forgot($command) . "<br>";
	} elseif ($_SESSION['resetPasswordProcedure'] == 6) {
		echo  forgot($command) . "<br>";
	} elseif ($_SESSION['resetPasswordProcedure'] == 7) {
		echo  forgot($command) . "<br>";
	}


	else
	{

		// Process the player's submitted command and parameter
		switch ($command) {
			case "_9":																	// Non user command. forces a screen refresh of the current sector using jquery at 3-minute intervals. valid for logged in users
				echo  _9() . '<br><br>';
				break;

			case ".":																		// period key -- display the status bar
				echo formatUIOutput(_period());
				break;

			case "?":																		// Help (same as HELP)
				echo formatUIOutput(help($param));
				break;

			case "ABOUT":																// Display "About Game" text
				echo formatUIOutput(about($command));
				break;

			case "BULLETIN":														// Display Bulletin text
				echo formatUIOutput(bulletin($command));
				break;

			case "DROP":																	// Drop inventory item to sector
				echo formatUIOutput(drop($param));
				break;

			case "ENROLL":															// Enroll an account
				$_SESSION['createAccountProcedure'] = "1";
				echo enroll($command);
				break;

			case "FORGOT":															// Forgot / reset password
				$_SESSION['resetPasswordProcedure'] = "1";
				echo forgot($command);
				break;

			case "GET":																	// Retrieve a sector item
				echo formatUIOutput(get($param));
				break;

			case "GO":																	// Move/Navigate
				echo formatUIOutput(go($param));
				break;

			case "HELP":																// Help (same as ?)
				echo formatUIOutput(help($param));
				break;

			case "LOG":																	// Log
				echo formatUIOutput(shiplog($param));
				break;

			case "LOGIN":																// Login
				$_SESSION['loginProcedure'] = "1";
				echo login($command);
				break;

			case "LOGOUT":															// Logout
				echo formatUIOutput(logout($command, $param));
				break;

			case "PROBE":																// Probe
				echo formatUIOutput(probe($param));
				break;

			case "SCORE":																// Score
				echo formatUIOutput(score($param));
				break;

			case "TERMS":																// Terms and conditions
				echo formatUIOutput(terms($param));
				break;

			case "TORP":																// Fire torpedo
				echo formatUIOutput(torp($param));
				break;

			case "XFER":																// Transfer fuel or torpedoes
				echo formatUIOutput(xfer($param));
				break;

			default:
				// CREATE or LOGIN or FORGOT procedure, so other text may be entered that doesn't match a command
				if (!$_SESSION['createAccountProcedure'] == "" || !$_SESSION['loginProcedure'] == "" || !$_SESSION['resetPasswordProcedure'] == "") {
					// Don't return anything...
				} else {
					// Hide password from being displayed on screen before welcome message upon login
					if($_SESSION['suppressPrompt'] == "true") {
						$_SESSION['suppressPrompt'] = "false";
					} else {
					echo '<a class="prompt">' . PROMPT . $command. '</a><br>';
					echo '"' . $command . '" is an invalid command.  Please try again.<br><br>';
					break;
					}
				}
		}
	}
?>
