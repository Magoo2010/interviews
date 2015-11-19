<?php
$confirmed = Students::find_all_confirmed_by_arrival_date();

// build headers
$pdf->SetFont("Times", 'B', 12);
$pdf->Cell(33, 5, "Arrival", 0, 0);
$pdf->Cell(30, 5, "Surname", 0, 0);
$pdf->Cell(30, 5, "Firstname", 0, 0);
$pdf->Cell(70, 5, "Subject", 0, 0);
$pdf->Cell(50, 5, "Contact Phone Number", 0, 0);
$pdf->Cell(40, 5, "Notes/Room Number", 0, 1);

$pdf->SetFont("Times", '', 12);
// itterate through each course name
foreach ($confirmed AS $student) {
	$course = Courses::find_by_uid($student->course_code);
	$arrivalDate = date('j M Y', strtotime($student->arrival_date)) . " " . date('H:i', strtotime($student->arrival_time));
	
	$pdf->Cell(33, 5, $arrivalDate, 0, 0);
	$pdf->Cell(30, 5, $student->surname, 0, 0);
	$pdf->Cell(30, 5, $student->forenames, 0, 0);
	$pdf->Cell(70, 5, $course->displayShortName(), 0, 0);
	$pdf->Cell(50, 5, $student->phone, 0, 0);
	$pdf->Cell(40, 5, "", 0, 1);
}

?>