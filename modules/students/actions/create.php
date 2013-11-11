<?php
echo "test";
require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/initialise.php');
$user = new Students();

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

if ($user->create()) {
	if ($_POST['sendEmail'] == "true") {
		//sendEmail($_POST['email'], "SEH: Interviews", "Message From SEH: Interviews", $messageBody);
	}
	
	$message = "<div class=\"alert alert-success\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Success!</strong> details successfully submitted.</div>";
} else {
	$message = "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\">×</button><strong>Error!</strong> There was an error saving your details.  Please try again.</div>";
}


echo $message;
?>