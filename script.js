//Jquery script
// This file represents the game UI window.
//
// The following JQuery script is used to monitor text input by the player into the
// 'txtInput' textarea on 'index.php, posts the submitted data to 'processCommand.php'
// which then updates the database and ultimately returns and appends text back to
// the player into the 'txtOutput' text area on 'index.php'.
//
// 17-Mar-2022 | Matt Robb
//    Modified response to convert e.which (deprecated) to 'keyup' to monitor inputs
//    Gboard virtual keyboard (Android phone and tablet is spotty) whereas a return
//    code sent after a number or punctuation, but a new line is sent after text
//    which then requires pressing enter twice to submit the Enter key
// 06-Feb-2019 | Matt Robb
//
$(document).ready(function(){
	// Respond to enter key being pressed in #txtInput box
	$("#txtInput").on('keyup',function (e) {
		//If the Enter key is pressed (carriage return = 13)
		if(e.key == "Enter"){

			//Assign txtInput value to variable
			var datastring = 'txtInput='+ jQuery.trim($("#txtInput").val());

			//AJAX code to submit form
			$.ajax({
				type: "POST",
				url: "processCommand.php",
				data: datastring,
				cache: false,
				success: function(result){

					//alert(result);

					//Update txtOutput DIV tag -- UI
					$("#txtOutput").append(result + "<br>");
					$("#txtInput").val("");		// Reset txtInput to nothing
					$("#txtFooter").load(location.href + " #txtFooter");
					e.preventDefault();

					//Scroll to bottom of DIV tag as data is added -- nice UI experience
					var elem = document.getElementById('txtOutput');
					elem.scrollTop = elem.scrollHeight;
				}
			});
		}
	});



	// Dynamically resize #txtOutput div tag
	$(window).resize(function() {
    $('#txtOutput').height($(window).height() - 125);		// 180 is an arbitrary value to still show the connection bar (or 125, as of May 2022)


// Next three lines added 5-Jun
		//Scroll to bottom of DIV tag as data is added -- nice UI experience
		var elem = document.getElementById('txtOutput');
		elem.scrollTop = elem.scrollHeight;
// Above three lines added 5-Jun


	});
	$(window).trigger('resize');



	// Append DIV tag every 20 minutes to force a refresh / see new objects in the sector
	setInterval(function() {

			//Assign txtInput value to variable
			$("#txtInput").val("_9");
			var datastring = 'txtInput='+ $("#txtInput").val();

			//AJAX code to submit form
			$.ajax({
				type: "POST",
				url: "processCommand.php",
				data: datastring,
				cache: false,
				success: function(result){

					//alert(result);

					//Update txtOutput DIV tag -- UI
					$("#txtOutput").append(result + "<br>");
					$("#txtInput").val("");		// Reset txtInput to nothing
					$("#txtFooter").load(location.href + " #txtFooter");
					// e.preventDefault();		// Disable this line in this function to allow the data scroll to occur

					//Scroll to bottom of DIV tag as data is added -- nice UI experience
					var elem = document.getElementById('txtOutput');
					elem.scrollTop = elem.scrollHeight;
				}
			});
    }, 1200 * 1000);

});
