<?php
require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/initialise.php');
$user = Students::find_by_uid($_POST['uid']);

if ($directory = opendir(SITE_LOCATION . "/uploads/")) {
	$uidLen = strlen($user->uid);
	
	while (false !== ($entry = readdir($directory))) {
		$photoUserID = substr($entry, 0, $uidLen);
		
		if ($photoUserID == $user->uid) {
			unlink(SITE_LOCATION . "/uploads/". $entry);
		}
	}
	
	closedir($directory);
}

$user->delete();

?>