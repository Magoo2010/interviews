<?php
require_once($_SERVER['DOCUMENT_ROOT'] . 'engine/initialise.php');

$studentClass = new Students();
$invitees = $studentClass->find_all_unconfirmed();

// build header rows for CSV
$classVars1 = get_class_vars(get_class($studentClass));
$n = 0;
foreach ($classVars1 as $name => $value) {
	$outputArray[1][$n] = $name;
	$n++;
}


// start itterating through the database
$i = 2;

foreach ($invitees AS $user) {
	$n = 0;
	$classVars2 = get_object_vars($user);
	
	foreach ($classVars2 as $name => $value) {
		if ($value == "" || $value == null) {
			$value = "";
		}
		$outputArray[$i][$n] = $value;
		
		$n++;
	}
	
	$i++;
}
//printArray($outputArray);

header("Content-type:text/octect-stream");
header("Content-Disposition:attachment;filename=interviews_unconfirmed-invitees.csv");

function outputCSV($data) {
	$outstream = fopen("php://output", "w");
	
	function __outputCSV(&$vals, $key, $filehandler) {
		fputcsv($filehandler, $vals, ',', '"');
	}
	
	array_walk($data, '__outputCSV', $outstream);
	
	fclose($outstream);
}

outputCSV($outputArray);

?>