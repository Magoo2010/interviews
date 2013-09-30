<?php
include_once("../engine/initialise.php");

if (isset($_POST['email'])) {
	if (isset($_POST['name'])) {
		$messageFrom = $_POST['name'];
	} else {
		$messageFrom = "Unknown";
	}
	
	if (isset($_POST['email'])) {
		$messageEmail = $_POST['email'];
	} else {
		$messageEmail = "Unknown";
	}
	
	if (isset($_POST['ucas'])) {
		$messageUCAS = $_POST['ucas'];
	} else {
		$messageUCAS = "Unknown";
	}
	
	if (isset($_POST['course'])) {
		$messageCourse = $_POST['course'];
	} else {
		$messageCourse = "Unknown";
	}
	
	if (isset($_POST['description'])) {
		$messageBody  = "UCAS: " . $messageUCAS . "<br />";
		$messageBody .= "Name: " . $messageFrom . "<br />";
		$messageBody .= "Course of Study: " . $messageCourse . "<br />";
		$messageBody .= "E-Mail Address: " . $messageEmail . "<br />";
		$messageBody .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "<br /><br />";
		$messageBody .= $_POST['inputDescription'];
	} else {
		$messageBody = "No message given";
	}
	
	sendEmail("someone@somewhere.com", "Someones Name", "Message From SEH: Interviews", $messageBody);
	
	$output  = "<div class=\"alert alert-success\">";
	$output .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button>";
	$output .= "<strong>Success!</strong> Your message has been sent to St Edmund Hall Admissions";
	$output .= "</div>";
	
	echo $output;
}
?>