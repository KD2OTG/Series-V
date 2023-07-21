<?php
// PURPOSE:  Sends an email to a player, notably for account verification and password resets
// HISTORY:  
//     - 30-Mar-2022 | Matt Robb | Initial version
// 
 
	function sendMail($email_to, $email_subject, $email_body) {
	// Populates the PHP mail() function to send an email
	// 30-Mar-2022 | Matt Robb
		
		// Some example code for added parameters if not on shared hosting platform
		// $email_to = "";
		// $email_from = "";
		// $email_headers = "MIME-Version: 1.0\r\n";
		// $email_headers = $email_headers . "From: info@emailaddress.com <info@emailaddress.com>\r\n";
		// $email_headers = $email_headers . "Content-Type: text/html; charset=UTF-8\r\n";
		// $email_headers = $email_headers . "Reply-To: info@semailaddress.com\r\n";
		// $email_subject = "My subject";
		// Use wordwrap() if lines are longer than 70 characters
		// $email_body = wordwrap("First line of text\nSecond line of text",70);
		
		// Populate and send email
		mail($email_to, $email_subject, $email_body);
	}
?> 