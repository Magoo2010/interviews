<?php
require_once('../../../engine/initialise.php');
$user = new Students();

//printArray($_POST);

$user->title = $_POST['title'];
$user->ucas = $_POST['ucas'];
$user->forenames = $_POST['forenames'];
$user->surname = $_POST['surname'];
$user->course_code = $_POST['course_code'];
$user->location_type = $_POST['location_type'];
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

if ($user->create()) {
	$log = new Logs();
	$log->type = "success";
	$log->title = "User Created";
	$log->description = "User UID:" . $user->uid . " was created";
	$log->userUID = $user->uid;
	$log->create();

	if ($_POST['sendemail'] == "true") {
		$emailWelcome = Settings::find_by_setting_name("welcome_email");
		
		sendEmail($_POST['email'], $user->forenames . " " . $user->surname, "Message From SEH Admissions", $emailWelcome->setting_value, true, $user->uid);
	}
	
	$message = "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Success!</strong> details successfully submitted.</div>";
} else {
	$log = new Logs();
	$log->type = "error";
	$log->title = "User Created";
	$log->description = "User with UCAS ID: " . $_POST['ucas'] . " was not created";
	$log->create();
	
	$message = "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Error!</strong> There was an error saving your details.  Please try again.</div>";
}


echo $message;
?>