<?php
// PURPOSE:  Allow user to [ENROLL] account to play game
//   NOTES:
//     - Must ensure "require_once 'commands/enroll.php';" is added to the "loadCommands.php" file
//     - Relies on $_SESSION['createAccountProcedure'] so that switch statement in processCommand.php is bypassed, allowing this function to prompt user multiple times
// HISTORY:
//     - 25-Mar-2022 | Matt Robb | Initial version
//

	require_once 'modMail.php';



	function enroll($param) {
	// Allow user to [ENROLL] account to play game
	// 24-Mar-2022 | Matt Robb

		// If not loggged-in (Visitor)
		if (!isset($_SESSION['alias'])) {
			// Track that user is attempting to create an account...

			// Step #1 of #10 : Provide a prompt about the ENROLL process
			if ($_SESSION['createAccountProcedure'] == "1") {
				$_SESSION['createAccountProcedure'] = "2";
				// Show the command the user input before prompting for email address
				$var = '<a class="prompt">' . PROMPT . $param . '</a><br>';
				$var = $var . 'To enroll a new account you will need to provide your first name (or a<br>';
				$var = $var . 'handle/alias), a valid email address, and a password.<br><br>';
				$var = $var . 'Continuing constitutes your agreement to the Terms, Conditions, and Policies <br>';
				$var = $var . 'that you may read using the TERMS command.<br><br>';
				$var = $var . 'Do you wish to continue? [Y/n]<br>';
				return $var;
			}

			// Step #2 of #10 : Provide an escape from ENROLL process, or prompt for email address
			if ($_SESSION['createAccountProcedure'] == "2") {
				$_SESSION['createAccountProcedure'] = "3";
				if($param != "Y" && $param != "y") {
					$_SESSION['createAccountProcedure'] = "";
					// Set a session variable to hide output of an invalid command prompt
					$_SESSION['suppressPrompt'] = "true";
					$var = $param . '<br><br>';
					$var = $var . 'Account enrollment process cancelled.<br>';
					return $var;
				}
				$var = strtoupper($param) . '<br><br>';
				$var = $var . 'Enter your email address:';
				return $var;
			}

			// Step #3 of #10 : Capture email address entered, then prompt for re-entry of email address
			if ($_SESSION['createAccountProcedure'] == "3") {
				$_SESSION['createAccountProcedure'] = "4";
				$_SESSION['email'] = strtolower($param);
				$var = strtolower($param) . '<br><br>';
				$var = $var . 'Re-enter your email address:';
				return $var;
			}

			// Step #4 of #10 : Compare email addresses, then prompt for first name (handle/alias)
			if ($_SESSION['createAccountProcedure'] == "4") {
				$_SESSION['createAccountProcedure'] = "5";
				// Check if email address is the same from both entries
				if($_SESSION['email'] != strtolower($param)) {
					$_SESSION['createAccountProcedure'] = "";
					// Set a session variable to hide output of an invalid command prompt
					$_SESSION['suppressPrompt'] = "true";
					$var = strtolower($param) . '<br><br>';
					$var = $var . 'The email addresses do not match.  Account enrollment process cancelled.<br>';
					return $var;
				}
				// Check if email address appears to follow a valid format
				if(!isValidEmail($_SESSION['email'])) {
					$_SESSION['createAccountProcedure'] = "";
					// Set a session variable to hide output of an invalid command prompt
					$_SESSION['suppressPrompt'] = "true";
					$var = strtolower($param) . '<br><br>';
					$var = $var . 'The email address appears invalid.  Account enrollment process cancelled.<br>';
					return $var;
				}
				// Check if an account already exists under email address
				if (emailAlreadyExists(strtolower($param)) == true) {
					$_SESSION['createAccountProcedure'] = "";
					// Set a session variable to hide output of an invalid command prompt
					$_SESSION['suppressPrompt'] = "true";
					$var = strtolower($param) . '<br><br>';
					$var = $var . 'An account already exists with that email address.  Try using the password<br>';
					$var = $var . 'reset command instead.<br><br>Account enrollment process cancelled.<br>';
					return $var;
				}
				// If all conditions above pass, then provide a prompt for first name (handle/alias)
				$var = strtolower($param) . '<br><br>';
				$var = $var . '<script>document.getElementById("txtInput").maxLength = "15";</script>';
				$var = $var . 'Enter your 2-15 char first name (or a handle/alias) to be shown publicly to<br>';
				$var = $var . 'other players in the game:';
				return $var;
			}

			// Step #5 of #10 : Validate first name (handle/alias), then prompt for confirmation to use
			if ($_SESSION['createAccountProcedure'] == "5") {
				$_SESSION['createAccountProcedure'] = "6";

				// Next three lines sanitize the alias for consistency across players
				$_SESSION['newalias'] = strtolower($param);
				$_SESSION['newalias'] = ucfirst($_SESSION['newalias']);
				$param = $_SESSION['newalias'];

				// Check if first name (handle/alias) contains only alphabetic characters
				if (ctype_alpha($param) == false) {
					$_SESSION['createAccountProcedure'] = "5";
					$var = $param . '<br><br>';
					$var = $var . '<script>document.getElementById("txtInput").maxLength = "15";</script>';
					$var = $var . 'To enhance the game playing experience, only alphabetic characters accepted.<br>';
					$var = $var . 'Please enter something else:';
					return $var;
				}
				// Check if length of first name (handle/alias) is at least two characters
				if (strlen($param) < 2) {
					$_SESSION['createAccountProcedure'] = "5";
					$var = $param . '<br><br>';
					$var = $var . '<script>document.getElementById("txtInput").maxLength = "15";</script>';
					$var = $var . 'The char length of this first name (or alias/handle) is too short.<br>';
					$var = $var . 'Please enter something else:';
					return $var;
				}
				// Check if an account already exists using first name (alias/handle)
				if (aliasAlreadyExists($param) == true) {
					$_SESSION['createAccountProcedure'] = "5";
					$var = $param . '<br><br>';
					$var = $var . '<script>document.getElementById("txtInput").maxLength = "15";</script>';
					$var = $var . 'Another person is already playing the game using this first name ';
					$var = $var . '(or alias/handle).  Please enter something else:';
					return $var;
				}
				// Show the handle to the user for confirmation
				$var = 'OK, ' . $param . '.  Proceed with setup using this name/alias/handle)? [Y/n]';
				return $var;
			}

			// Step #6 of #10 : Provide an escape, or prompt for user's password
			if ($_SESSION['createAccountProcedure'] == "6") {
				$_SESSION['createAccountProcedure'] = "7";
				if($param != "Y" && $param != "y") {
					$_SESSION['createAccountProcedure'] = "5";
					$var = $param . '<br><br>';
					$var = $var . 'Enter your 2-15 char first name (or a handle/alias) to be shown publicly to<br>';
					$var = $var . 'other players in the game:';
					return $var;
				}
				// If all conditions above pass, then provide a prompt for password
				$var = $param . '<br><br>';
				$var = $var . '<script>document.getElementById("txtInput").maxLength = "20";</script>';
				$var = $var . '<script>document.getElementById("txtInput").style.color = "#380C2A";</script>';
				$var = $var . 'Enter a 6-20 char password using mixed-case letters, numbers, and symbols ';
				$var = $var . 'except for the space " " and slash "\" character:';
				return $var;
			}

			// Step #7 of #10 : Capture password entered, then prompt for re-entry of password
			if ($_SESSION['createAccountProcedure'] == "7") {
				$_SESSION['createAccountProcedure'] = "8";
				// Check if length of password is at least six characters
				if (strlen($param) <= 5) {
					$_SESSION['createAccountProcedure'] = "7";
					$var = '********************<br><br>';
					$var = $var . '<script>document.getElementById("txtInput").maxLength = "20";</script>';
					$var = $var . '<script>document.getElementById("txtInput").style.color = "#380C2A";</script>';
					$var = $var . 'The char length of this password is too short.<br>';
					$var = $var . 'Please enter something else:';
					return $var;
				}
				// If all conditions above pass, then capture password and re-prompt for password
				$_SESSION['password'] = $param;
				$var = '********************<br><br>';
				$var = $var . 'Re-enter your password:';
				return $var;
			}

			// Step #8 of #10 : Compare passwords, then prompt user to log in
			if ($_SESSION['createAccountProcedure'] == "8") {
				$_SESSION['createAccountProcedure'] = "9";
				// Check if password is the same from both entries
				if($_SESSION['password'] != $param) {
					$_SESSION['createAccountProcedure'] = "7";
					$var = '********************<br><br>';
					$var = $var . '<script>document.getElementById("txtInput").maxLength = "20";</script>';
					$var = $var . '<script>document.getElementById("txtInput").style.color = "#380C2A";</script>';
					$var = $var . 'The passwords do not match.<br>';
					$var = $var . 'Enter a 6-20 char password using mixed-case letters, numbers, and symbols ';
					$var = $var . 'except for the space " " and slash "\" character:';
					return $var;
				}
			}

			// Step #9 of #10 : Send check PIN via email
			if ($_SESSION['createAccountProcedure'] == "9") {
				$_SESSION['createAccountProcedure'] = "10";
				// If all conditions above pass, then send PIN via email and prompt for entry of PIN
				$_SESSION['verificationPin'] = rand(100000,999999);
				sendPin($_SESSION['email'], $_SESSION['newalias'], $_SESSION['verificationPin']);
				$var = '<script>document.getElementById("txtInput").maxLength = "128";</script>';
				$var = $var . '<script>document.getElementById("txtInput").style.color = "#4E980A";</script>';
				$var = $var . 'Enter the VERIFICATION PIN now.<br>';
				$var = $var . 'Please check your email inbox (and SPAM folder) to retrieve this number and <br>';
				$var = $var . 'finalize your enrollment:';
				return $var;
			}


			// Step #10 of #10 : Capture PIN and verify, then create account and prompt user to log in
			if ($_SESSION['createAccountProcedure'] == "10") {
				$_SESSION['createAccountProcedure'] = "11";
				// Check if password is the same from both entries
				if($_SESSION['verificationPin'] != $param) {
					$_SESSION['createAccountProcedure'] = "10";
					$var = $param . '<br><br>';
					$var = $var . 'The PIN is incorrect.<br><br>';
					$var = $var . 'Enter the VERIFICATION PIN now.<br>';
					$var = $var . 'Please check your email inbox (and SPAM folder) to retrieve this number and <br>';
					$var = $var . 'finalize your enrollment:';
					return $var;
				}
				// If all conditions above pass, then ...
				createAccount($_SESSION['email'], $_SESSION['password'], $_SESSION['newalias']);
				$_SESSION['createAccountProcedure'] = "";
				// Set a session variable to hide output of an invalid command prompt
				$_SESSION['suppressPrompt'] = "true";
				$_SESSION['email'] = "";
				$_SESSION['password'] = "";
				$_SESSION['newalias'] = "";
				$_SESSION['verificationPin'] = "";
				$var = $param . '<br><br>';
				$var = $var . 'Account created successfully. Use the LOGIN command to join the game.';
				return $var;
			}
		}
		// If logged-in (Player), display message in output that won't reveal password
		else {
			$var = 'You are already logged into the game.';
		}
		return $var;
	}



	function isValidEmail($var) {
	// Determine if the string is likely a valid e-mail address
	// 21-Feb-2017 | Matt Robb
		if ((stripos($var,"@") > 0) && (stripos($var,".") > 0)) {
			return true;
		}
		else {
			return false;
		}
	}



	function sendPin($email, $alias, $pin) {
	// Send a PIN number to user's email address to validate
	// 29-Mar-2022 | Matt Robb

	global $db_server;
	dbConnect();
		$query = "SELECT * FROM app_emails WHERE app_email_id=1";			// id = 1 = CREATE account email
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());

		// These next lines are pre- 11-Apr-2022
		//	$row = mysqli_fetch_row($result);
		// Set variables
		//		$email_subject = $row[1];					// $row[1] = email_subject
		//		$email_body = $row[2];						// $row[2] = email_body


		// Replacement lines post- 11-Apr-2022
	  if (mysqli_num_rows($result) > 0) {
	 	 // Output data of each row
	 	 while ($row = mysqli_fetch_assoc($result)) {
			 $email_subject = $row["email_subject"];
			 $email_body = $row["email_body"];
	 	 }
	  } else {
	 		 $var = null;
	  }
	  // End replacement of lines above


	dbDisconnect();

	// Replace string blocks in email body
	$email_body = str_replace("[ALIAS]", $alias, $email_body);
	$email_body = str_replace("[GAMENAME]", GAMENAME, $email_body);
	$email_body = str_replace("[PIN]", $pin, $email_body);

	// Send the email
	sendMail($email, $email_subject, $email_body);

	return true;
	}



	function emailAlreadyExists($email) {
	// Determine if the email address already exists in the player table
	// 21-Feb-2017 | Matt Robb
		global $db_server;

		dbConnect();
		$query = "SELECT * FROM player WHERE email = '" . $email . "'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		$row_cnt = mysqli_num_rows($result);
		dbDisconnect();
		if ($row_cnt > 0) {
			return true;
		}
		else {
			return false;
		}
	}



	function aliasAlreadyExists($alias) {
	// Determine if the first name (handle/alias) already exists in the player table
	// 25-Mar-2022 | Matt Robb
		global $db_server;

		dbConnect();
		$query = "SELECT * FROM player WHERE alias = '" . $alias . "'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		$row_cnt = mysqli_num_rows($result);
		dbDisconnect();
		if ($row_cnt > 0) {
			return true;
		}
		else {
			return false;
		}
	}



	function createAccount($email, $password, $alias) {
	// Create user account after having first run isValidEmail() and isValidPassword()
	// 20-Mar-2022 | Matt Robb
		global $db_server;
		$salt1 = "tt&b";							// Careful, must match value in both login() and createAccount()
		$salt2 = "vc!*";							// Careful, must match value in both login() and createAccount()
		$token = md5("$salt1$password$salt2");

		// Get a random ship name to assign to player
		$ship_name = getRandomShipName();

		// Get sector_id and ship_id for starting coordinates
		$sector_id = get_sector_id_by_coord(0, 0, 0);
		$ship_id = get_item_type_id_by_name('ship');

		// Create a ship record for the player
		dbConnect();
		$query = "INSERT INTO item (item_type_id, proper_name, sector_id, is_visible) VALUES ('$ship_id', '$ship_name', '$sector_id','0')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		$ship_id = mysqli_insert_id($db_server);	// $col[0] = id = ship_id
		dbDisconnect();

		// Load ship with 40 torpedoes
		createTorpedo($ship_id, "", 40);

		// Load ship with 5, 20cm fuel-rods
		$x = 1;
		while($x <= 5) {
			createFuelRod($ship_id, "", 20.00);
		$x++;
		}


		// Create player record
		dbConnect();
		$query = "INSERT INTO player (email, password, alias, item_id) VALUES ('$email', '$token', '$alias', '$ship_id')";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}



?>
