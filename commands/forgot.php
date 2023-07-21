<?php
// PURPOSE:  Allow user to reset [FORGOT]ten password
//   NOTES:
//     - Must ensure "require_once 'commands/forgot.php';" is added to the "loadCommands.php" file
//     - Relies on $_SESSION['resetPasswordProcedure'] so that switch statement in processCommand.php is bypassed, allowing this function to prompt user multiple times
// HISTORY:
//     - 30-Mar-2022 | Matt Robb | Initial version
//

	require_once 'modMail.php';



	function forgot($param) {
	// Allow user to reset [FORGOT]ten password
	// 30-Mar-2022 | Matt Robb

		// If not loggged-in (Visitor)
		if (!isset($_SESSION['alias'])) {
			// Track that user is attempting to reset a password...

			// Step #1 of #6 : Provide a prompt about the FORGOT process
			if ($_SESSION['resetPasswordProcedure'] == "1") {
				$_SESSION['resetPasswordProcedure'] = "2";
				// Show the command the user input before prompting for email address
				$var = '<a class="prompt">' . PROMPT . $param . '</a><br>';
				$var = $var . 'To reset a password you will need to provide your email address.<br><br>';
				$var = $var . 'Do you wish to continue? [Y/n]<br>';
				return $var;
			}

			// Step #2 of #6 : Provide an escape from FORGOT process, or prompt for email address
			if ($_SESSION['resetPasswordProcedure'] == "2") {
				$_SESSION['resetPasswordProcedure'] = "3";
				if($param != "Y" && $param != "y") {
					$_SESSION['resetPasswordProcedure'] = "";
					// Set a session variable to hide output of an invalid command prompt
					$_SESSION['suppressPrompt'] = "true";
					$var = $param . '<br><br>';
					$var = $var . 'Password reset process cancelled.<br>';
					return $var;
				}
				$var = strtoupper($param) . '<br><br>';
				$var = $var . 'Enter your email address:';
				return $var;
			}

			// Step #3 of #6 : Check for valid email address, then send validation PIN
			if ($_SESSION['resetPasswordProcedure'] == "3") {
				$_SESSION['resetPasswordProcedure'] = "4";
				$_SESSION['email'] = strtolower($param);
				// Check if email address appears to follow a valid format
				if(!isValidEmail($_SESSION['email'])) {
					$_SESSION['resetPasswordProcedure'] = "";
					$var = strtolower($param) . '<br><br>';
					$var = $var . 'The email address appears invalid.  Password reset process cancelled.<br>';
					return $var;
				}
				// If all conditions above pass, then send PIN via email and prompt for entry of PIN
				$_SESSION['verificationPin'] = rand(100000,999999);
				sendResetPin($_SESSION['email'], $_SESSION['verificationPin']);
				$var = $var . 'Enter the VERIFICATION PIN now.<br>';
				$var = $var . 'Please check your email inbox (and SPAM folder) to retrieve this number and <br>';
				$var = $var . 'continue the password reset process:';
				return $var;
			}

			// Step #4 of #6 : Capture PIN and verify, then prompt for new password
			if ($_SESSION['resetPasswordProcedure'] == "4") {
				$_SESSION['resetPasswordProcedure'] = "5";
				// Check if verification PIN is correct
				if($_SESSION['verificationPin'] != $param) {
					$_SESSION['resetPasswordProcedure'] = "4";
					$var = $param . '<br><br>';
					$var = $var . 'The PIN is incorrect.<br><br>';
					$var = $var . 'Enter the VERIFICATION PIN now.<br>';
					$var = $var . 'Please check your email inbox (and SPAM folder) to retrieve this number and <br>';
					$var = $var . 'continue the password reset process:';
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

			// Step #5 of #6 : Capture password entered, then prompt for re-entry of password
			if ($_SESSION['resetPasswordProcedure'] == "5") {
				$_SESSION['resetPasswordProcedure'] = "6";
				// Check if length of password is at least six characters
				if (strlen($param) <= 5) {
					$_SESSION['resetPasswordProcedure'] = "5";
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

			// Step #6 of #6 : Compare passwords, then prompt user to log in
			if ($_SESSION['resetPasswordProcedure'] == "6") {
				$_SESSION['resetPasswordProcedure'] = "7";
				// Check if password is the same from both entries
				if($_SESSION['password'] != $param) {
					$_SESSION['resetPasswordProcedure'] = "5";
					$var = '********************<br><br>';
					$var = $var . '<script>document.getElementById("txtInput").maxLength = "20";</script>';
					$var = $var . '<script>document.getElementById("txtInput").style.color = "#380C2A";</script>';
					$var = $var . 'The passwords do not match.<br>';
					$var = $var . 'Enter a 6-20 char password using mixed-case letters, numbers, and symbols ';
					$var = $var . 'except for the space " " and slash "\" character:';
					return $var;
				}
				// If all conditions above pass, then ...
				resetAccountPassword($_SESSION['email'], $_SESSION['password']);
				$_SESSION['resetPasswordProcedure'] = "";
				// Set a session variable to hide output of an invalid command prompt
				$_SESSION['suppressPrompt'] = "true";
				$_SESSION['email'] = "";
				$_SESSION['password'] = "";
				$_SESSION['verificationPin'] = "";
				$var = '<script>document.getElementById("txtInput").maxLength = "128";</script>';
				$var = $var . '<script>document.getElementById("txtInput").style.color = "#4E980A";</script>';
				$var = $var . 'Password reset successfully. Use the LOGIN command to join the game.';
				return $var;
			}
		}
		// If logged-in (Player), display message in output that won't reveal password
		else {
			$var = 'You are already logged into the game.';
		}
		return $var;
	}



	function sendResetPin($email, $pin) {
	// Send a PIN number to user's email address to validate
	// 29-Mar-2022 | Matt Robb

		global $db_server;
		dbConnect();
		$query = "SELECT * FROM app_emails WHERE app_email_id=2";			// id = 2 = FORGOTTEN password reset
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		if (mysqli_num_rows($result) > 0) {
		 // Output data of each row
		 while ($row = mysqli_fetch_assoc($result)) {
			 $email_subject = $row["email_subject"];
			 $email_body = $row["email_body"];
		 }
		} else {
			 // Do nothing
		}
		dbDisconnect();

		// Replace string blocks in email body
		$email_body = str_replace("[GAMENAME]", GAMENAME, $email_body);
		$email_body = str_replace("[PIN]", $pin, $email_body);

		// Send the email
		sendMail($email, $email_subject, $email_body);
		return true;
	}



	function resetAccountPassword($email, $password) {
	// Update user account after having first run isValidEmail() and isValidPassword()
	// 30-Mar-2022 | Matt Robb

		global $db_server;
		$salt1 = "tt&b";							// Careful, must match value in both login() and createAccount() and resetAccountPassword()
		$salt2 = "vc!*";							// Careful, must match value in both login() and createAccount() and resetAccountPassword()
		$token = md5("$salt1$password$salt2");
		// $token = $salt1 . $password . $salt2;

		// Update player record
		dbConnect();
		$query = "UPDATE player SET password = '$token' WHERE email = '$email'";
		$result = mysqli_query($db_server, $query);
		if (!$result) die ("Database access failed: " . mysql_error());
		dbDisconnect();
	}



?>
