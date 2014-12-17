<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/engine/initialise.php');

if (isset($_POST['uid']) && $_POST['uid'] <> '') {
	$user = Students::find_by_uid($_POST['uid']);
	printArray($user);
	
	if ($directory = opendir(SITE_LOCATION . "/uploads/")) {
		$uidLen = strlen($user->uid);
		$userPhotoPrefix = $user->uid . "_";
		
		while (false !== ($entry = readdir($directory))) {
			$underScorePos = strpos($entry, "_");
			$photoUserID = substr($entry, 0, $underScorePos) . "_";
			
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
} else {
	echo "No UID provided!";
}
?>