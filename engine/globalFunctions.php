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
	//$mail->AddCC("admissions@seh.ox.ac.uk", "Admissions");
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
	
	// log this event!
	echo "<p class=\"lead\">SENDING E-MAIL TO " . $recipientAddress . "</p>";
	$log = new Logs();
	$log->type = "info";
	$log->title = "E-Mail Sent";
	$log->description = "An e-mail was sent to " . $recipientAddress;
	$log->userUID = $userUID;
	$log->create();
	
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

function _mirrorImage ( $imgsrc)
{
    $width = imagesx ( $imgsrc );
    $height = imagesy ( $imgsrc );

    $src_x = $width -1;
    $src_y = 0;
    $src_width = -$width;
    $src_height = $height;

    $imgdest = imagecreatetruecolor ( $width, $height );

    if ( imagecopyresampled ( $imgdest, $imgsrc, 0, 0, $src_x, $src_y, $width, $height, $src_width, $src_height ) )
    {
        return $imgdest;
    }

    return $imgsrc;
}

function adjustPicOrientation($full_filename){        
	$exif = exif_read_data($full_filename);
	
	if($exif && isset($exif['Orientation'])) {
		$orientation = $exif['Orientation'];
		
		if($orientation != 1) {
			$img = imagecreatefromjpeg($full_filename);
			
			$mirror = false;
			$deg    = 0;
			
			switch ($orientation) {
				case 2:
				$mirror = true;
				break;
				
				case 3:
				$deg = 180;
				break;
				
				case 4:
				$deg = 180;
				$mirror = true;  
				break;
				
				case 5:
				$deg = 270;
				$mirror = true; 
				break;
				
				case 6:
				$deg = 270;
				break;
				
				case 7:
				$deg = 90;
				$mirror = true; 
				break;
				
				case 8:
				$deg = 90;
				break;
			}
			
			if ($deg) $img = imagerotate($img, $deg, 0);
			if ($mirror) $img = _mirrorImage($img);
            //$full_filename = str_replace('.jpg', "-O$orientation.jpg",  $full_filename);
            //echo "attempting to save rotated image to: ". $full_filename;
            imagejpeg($img, $full_filename, 95);
        }
    }
    return $full_filename;
}

?>