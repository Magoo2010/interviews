<?php

$log = new Logs();
$log->type = "success";
$log->title = "User Created";
$log->description = "User UID: 0 was created";
$log->userUID = 0;
$log->create();


/*
if ($directory = opendir(SITE_LOCATION . "/uploads/")) {
	$user = Students::find_by_uid(68);
	printArray($user);
	
	$uidLen = strlen($user->uid);
	
    echo "Entries:<br />";
    
    while (false !== ($entry = readdir($directory))) {
    	$photoUserID = substr($entry, 0, $uidLen);
    	if ($photoUserID == $user->uid) {
	    	echo $photoUserID;
	    	echo $entry . "<br />";
	    	echo "del: " . SITE_LOCATION . "/uploads/". $entry;
	    	//unlink(dirname(SITE_LOCATION . "/uploads/". $entry);
    	}
      
    }
    
    closedir($directory);
}
*/
?>