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
	


$pdf->SetFont("Times", 'B', 18);
$pdf->Cell(0, 5, $user->fullDisplayName(), 0, 1);
$pdf->Cell(0, 5, "", 0, 1);

$pdf->SetFont("Times", 'B', 12);
$pdf->Cell(0, 0, $pdf->Image($photoURL, 180, $pdf->GetY(), 45, 45), 0, 1, 'R', false );
$pdf->Cell(0, 5, "UID: " . $user->uid, 0, 1);
$pdf->Cell(0, 5, "UCAS: " . $user->ucas, 0, 1);
$pdf->Cell(0, 5, "Title: " . $user->title, 0, 1);
$pdf->Cell(0, 5, "Forename(s): " . $user->forenames, 0, 1);
$pdf->Cell(0, 5, "Surname: " . $user->Surname, 0, 1);
$pdf->Cell(0, 5, "Course of Study: " . $specificCourse->displayName(), 0, 1);
$pdf->Cell(0, 5, "Student Location Type: " . $user->location_type, 0, 1);
$pdf->Cell(0, 5, "Address: " . $user->add1 . $user->add2 . $user->add3 . $user->add4 . $user->add5, 0, 1);
$pdf->Cell(0, 5, "E-Mail: " . $user->email, 0, 1);
$pdf->Cell(0, 5, "Skype ID: " . $user->skype, 0, 1);
$pdf->Cell(0, 5, "Contact Telephone Number: " . $user->phone, 0, 1);
$pdf->Cell(0, 5, "Arrival Date: " . date('Y/m/d', strtotime($user->arrival_date)), 0, 1);
$pdf->Cell(0, 5, "Arrival Time: " . date('H:i', strtotime($user->arrival_time)), 0, 1);
$pdf->Cell(0, 5, "Disability: " . $user->disability, 0, 1);
$pdf->Cell(0, 5, "Dietary: " . $user->diet, 0, 1);
$pdf->Cell(0, 5, "Opt-Out: " . $user->optout, 0, 1);
$pdf->Cell(0, 5, "Confirmed Attendance: " . $user->confirmed_attendance, 0, 1);

?>