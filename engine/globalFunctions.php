<?php
function printArray($array) {
	echo ("<pre>");
	print_r ($array);
	echo ("</pre>");
}

function convertToDateString($dateString) {
	$dateFormat = "Y-m-d";
	$date = strtotime($dateString);
	
	$returnDate = date($dateFormat, $date);
	
	return $returnDate;
}

function convertToDateTimeString($dateTimeString) {
	$dateFormat = "Y-m-d H:i:s";
	$date = strtotime($dateTimeString);
	
	$returnDate = date($dateFormat, strtotime($date));
	
	return $returnDate;
}

function sendEmail($recipientAddress = null, $recipientName="Unknown", $messageSubject="Message from St Edmund Hall", $messageBody = null, $expand = false, $userUID = null) {
	$mail = new phpmailer;
	
	// set mailer to use SMTP
	$mail->IsSMTP();
	$mail->Host = "smtp.ox.ac.uk";
	$mail->WordWrap = 70;
	$mail->Encoding = "8bit";
	$mail->IsHTML(true);
	
	$mail->From = "admissions@seh.ox.ac.uk";
	$mail->FromName = "St Edmund Hall: Admissions";
	
	$mail->AddAddress($recipientAddress, $recipientName);
	$mail->AddCC("admissions@seh.ox.ac.uk", "Admissions");
	$mail->AddReplyTo("admissions@seh.ox.ac.uk", "St Edmund Hall: Admissions");
	
	$mail->Subject = $messageSubject;
	
	if ($expand == true) {
		$user = Students::find_by_uid($userUID);
		
		$expandedMessage = $messageBody;
		
		$userClass = new Students();
		$class_vars = get_class_vars(get_class($userClass));
		
		foreach ($class_vars as $name => $value) {
			$expanded_vars[] = "{{" . $name . "}}";
		}
		
		foreach ($expanded_vars AS $var) {
			$cleanVar = str_replace(array("{", "}"), "", $var);
			
			$expandedMessage = str_replace($var, $user->$cleanVar, $expandedMessage);
		}
		
		$messageBody = $expandedMessage;
	}
	
	$mail->Body = $messageBody;
	
	$mail->Send();
}

function interviewArrivalDates() {
	$settings = New Settings();
	$interviewArrivalStart = $settings->find_by_setting_name("interviews_arrival_start_date");
	$interviewArrivalEnd = $settings->find_by_setting_name("interviews_arrival_end_date");
	
	$startDate = convertToDateString($interviewArrivalStart->setting_value);
	$endDate = convertToDateString($interviewArrivalEnd->setting_value);
	
	$aryRange=array();
	
	$iDateFrom=mktime(1,0,0,substr($startDate,5,2),     substr($startDate,8,2),substr($startDate,0,4));
	$iDateTo=mktime(1,0,0,substr($endDate,5,2),     substr($endDate,8,2),substr($endDate,0,4));
	
	if ($iDateTo>=$iDateFrom) {
		array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
		
		while ($iDateFrom<$iDateTo) {
			$iDateFrom+=86400; // add 24 hours
			array_push($aryRange,date('Y-m-d',$iDateFrom));
		}
	}
	
	return $aryRange;
}
?>