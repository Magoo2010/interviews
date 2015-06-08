<?php
$user = Students::find_by_uid($_GET['userUID']);
//$courses = Courses::find_all();
$specificCourse = Courses::find_by_uid($user->course_code);

if (isset($user->photograph) && $user->photograph != "" && !is_null($user->photograph)) {
	if (file_exists("uploads/" . $user->photograph)) {
		$photoURL = "uploads/" . $user->photograph;
	} else {
		$photoURL = "img/no_user_photo.png";
	}
} else {
	$photoURL = "img/no_user_photo.png";
}
	
$pdf->SetFont("Times", 'B', 16);
$pdf->Cell(0, 5, "St Edmund Hall, Interviews: Candidate Summary", 0, 1);
$pdf->Cell(0, 30, "", 0, 1);

$pdf->SetFont("Times", 'B', 24);
$pdf->Cell(0, 5, $user->fullDisplayName(), 0, 1);
$pdf->Cell(0, 5, "", 0, 1);

$pdf->SetFont("Times", 'B', 12);
$pdf->Cell(0, 0, $pdf->Image($photoURL, 140, $pdf->GetY(), 45, 45), 0, 1, 'R', false );
$pdf->Cell(0, 7, "Database Ref. (UID): " . $user->uid, 0, 1);
$pdf->Cell(0, 7, "UCAS: " . $user->ucas, 0, 1);

$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(0, 7, "Title: " . $user->title, 0, 1);
$pdf->Cell(0, 7, "Forename(s): " . $user->forenames, 0, 1);
$pdf->Cell(0, 7, "Surname: " . $user->surname, 0, 1);
$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(0, 7, "Course of Study: " . $specificCourse->displayName(), 0, 1);

$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(0, 7, "Student Location Type: " . $user->location_type, 0, 1);
$pdf->Cell(0, 7, "Address 1: " . $user->add1, 0, 1);
$pdf->Cell(0, 7, "Address 2: " . $user->add2, 0, 1);
$pdf->Cell(0, 7, "Address 3: " . $user->add3, 0, 1);
$pdf->Cell(0, 7, "Address 4: " . $user->add4, 0, 1);
$pdf->Cell(0, 7, "Address 5: " . $user->add5, 0, 1);

$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(0, 7, "E-Mail: " . $user->email, 0, 1);
$pdf->Cell(0, 7, "Skype ID: " . $user->skype, 0, 1);
$pdf->Cell(0, 7, "Contact Telephone Number: " . $user->phone, 0, 1);

$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(0, 7, "Arrival Date: " . date('Y/m/d', strtotime($user->arrival_date)), 0, 1);
$pdf->Cell(0, 7, "Arrival Time: " . date('H:i', strtotime($user->arrival_time)), 0, 1);

$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(0, 7, "Disability: " . $user->disability, 0, 1);
$pdf->Cell(0, 7, "Dietary: " . $user->diet, 0, 1);

if ($user->optout == 0) {
	$optOutName = "No";
} elseif ($user->optout == 1) {
	$optOutName = "Yes";
} else {
	$optOutName = "Unknown";
}

if ($user->confirmed_attendance == 0) {
	$confirmedName = "No";
} elseif ($user->confirmed_attendance == 1) {
	$confirmedName = "Yes";
} else {
	$confirmedName = "Unknown";
}

$pdf->Cell(0, 7, "", 0, 1);
$pdf->Cell(0, 7, "Opt-Out: " . $optOutName, 0, 1);
$pdf->Cell(0, 7, "Confirmed Attendance: " . $confirmedName, 0, 1);

?>