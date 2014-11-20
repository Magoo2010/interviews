<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/engine/initialise.php');
$user = Students::find_by_uid($_POST['uid']);

if ($directory = opendir(SITE_LOCATION . "/uploads/")) {
	$uidLen = strlen($user->uid);
	$userPhotoPrefix = $user->uid . "_";
	
	while (false !== ($entry = readdir($directory))) {
		$photoUserID = substr($entry, 0, $uidLen) . "_";
		
		if ($photoUserID == $userPhotoPrefix) {
			unlink(SITE_LOCATION . "/uploads/". $entry);
			
			$log = new Logs();
			$log->type = "info";
			$log->title = "File Delete";
			$log->description = "File " . $entry . " was deleted";
			$log->create();
		}
	}
	
	closedir($directory);
}

$user->delete();

$log = new Logs();
$log->type = "warning";
$log->title = "User Deleted";
$log->description = "User UCAS:" . $user->ucas . " was deleted";
$log->create();
?>