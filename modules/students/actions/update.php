<?php
//require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/initialise.php');
require_once('../../../engine/initialise.php');



if (isset($_POST['uid'])) {
	$user = new Students();
	
	foreach ($_POST AS $key => $value) {
		$user->$key = $value;
	}
	/*
	$user = new Students();
	$user->uid = $_POST['userUID'];
	$user->title = $_POST['title'];
	$user->forenames = $_POST['forenames'];
	$user->surname = $_POST['surname'];
	$user->course = $_POST['course'];
	$user->add1 = $_POST['add1'];
	$user->add2 = $_POST['add2'];
	$user->add3 = $_POST['add3'];
	$user->add4 = $_POST['add4'];
	$user->add5 = $_POST['add5'];
	$user->email = $_POST['email'];
	$user->phone = $_POST['phone'];
	$user->skype = $_POST['skype'];
	$user->arrival_date = $_POST['arrival_date'];
	$user->arrival_time = $_POST['arrival_time'];
	$user->disability = $_POST['disability'];
	$user->diet = $_POST['diet'];
	$user->allow_feedback = $_POST['feedback'];
	$user->location_type = $_POST['location_type'];
	*/
	if ($user->update()) {
		$message = "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Success!</strong> Yours details have been updated, and you have confirmed you're coming on the {{DATE}}</div>";
	} else {
		$message = "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Warning!</strong> There was an error updating your details.  Please try again.</div>";
	}
	
	echo $message;

}
?>