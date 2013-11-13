<?php
//require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/initialise.php');
require_once('../../../engine/initialise.php');

$emailConfirmation = Settings::find_by_setting_name("confirmation_email");

if (isset($_POST['uid'])) {
	$user = new Students();
	
	foreach ($_POST AS $key => $value) {
		$user->$key = $value;
	}
	
	if ($user->update()) {
		sendEmail($user->email, $user->forenames . " " . $user->surname, "Message From SEH Admissions", $emailConfirmation->setting_value, true, $user->uid);
		
		$message = "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Success!</strong> Yours details have been updated, and you have confirmed you're coming on " . date('Y-m-d', strtotime($user->arrival_date)) . "</div>";
	} else {
		$message = "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Warning!</strong> There was an error updating your details.  Please try again.</div>";
	}
	
	echo $message;

}
?>