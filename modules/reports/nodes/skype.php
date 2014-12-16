<?php
$students = Students::find_all_with_skype();

$pdf->SetAutoPageBreak(false);
$pdf->SetFont("Times", 'B', 18);

foreach ($students AS $student) {
	if (isset($student->photograph) && $student->photograph != "" && !is_null($student->photograph)) {
		if (file_exists("uploads/" . $student->photograph)) {
			$photoURL = "uploads/" . $student->photograph;
		} else {
			$photoURL = "img/no_user_photo.png";
		}
	} else {
		$photoURL = "img/no_user_photo.png";
	}
	
	$course = Courses::find_by_uid($student->course_code);
	
	$studentArray[] = array(
		'photograph' => $photoURL,
		'surname' => $student->surname,
		'forenames' => $student->forenames,
		'course' => $course->displayName(),
		'email' => $student->email,
		'skype' => $student->skype,
		'phone' => $student->phone
	);
}

$sets = array_chunk($studentArray, 3);

$pdf->SetFont("Times", 'B', 18);
$pdf->Cell(0, 10, "Skype Candidates", 0, 1);
$pdf->Cell(0, 10, "", 0, 1);

$pdf->SetFont("Times", '', 14);

$rowCounter = 0;

foreach ($sets as $set) {
	if (file_exists($set[0]['photograph'])) {
		$pdf->Cell(65, 45, $pdf->Image($set[0]['photograph'], $pdf->GetX()+ 15, $pdf->GetY(), 45, 45), 0, 0, 'C', false );
	} else {
		$pdf->Cell(65, 45, "", 1, 0, 'C', false);
	}
	if (file_exists($set[1]['photograph'])) {
		$pdf->Cell(65, 45, $pdf->Image($set[1]['photograph'], $pdf->GetX()+ 15, $pdf->GetY(), 45, 45), 0, 0, 'C', false );
	} else {
		$pdf->Cell(65, 45, "", 1, 0, 'C', false);
	}
	if (file_exists($set[2]['photograph'])) {
		$pdf->Cell(65, 45, $pdf->Image($set[2]['photograph'], $pdf->GetX()+ 15, $pdf->GetY(), 45, 45), 0, 1, 'C', false );
	} else {
		$pdf->Cell(65, 45, "", 1, 1, 'C', false);
	}
	
	$pdf->Cell(65, 5, $set[0]['surname'] . ", " . $set[0]['forenames'], 0, 0, 'C', false);
	$pdf->Cell(65, 5, $set[1]['surname'] . ", " . $set[1]['forenames'], 0, 0, 'C', false);
	$pdf->Cell(65, 5, $set[2]['surname'] . ", " . $set[2]['forenames'], 0, 1, 'C', false);
	$pdf->Ln();
	$pdf->Cell(65, 3, $set[0]['course'], 0, 0, 'C', false);
	$pdf->Cell(65, 3, $set[1]['course'], 0, 0, 'C', false);
	$pdf->Cell(65, 3, $set[2]['course'], 0, 1, 'C', false);
	$pdf->Ln();
	$pdf->Cell(65, 3, $set[0]['email'], 0, 0, 'C', false);
	$pdf->Cell(65, 3, $set[1]['email'], 0, 0, 'C', false);
	$pdf->Cell(65, 3, $set[2]['email'], 0, 1, 'C', false);
	$pdf->Ln();
	$pdf->Cell(65, 3, "Skype: " . $set[0]['skype'], 0, 0, 'C', false);
	$pdf->Cell(65, 3, "Skype: " . $set[1]['skype'], 0, 0, 'C', false);
	$pdf->Cell(65, 3, "Skype: " . $set[2]['skype'], 0, 1, 'C', false);
	$pdf->Ln();
	$pdf->Cell(65, 5, $set[0]['phone'], 0, 0, 'C', false);
	$pdf->Cell(65, 5, $set[1]['phone'], 0, 0, 'C', false);
	$pdf->Cell(65, 5, $set[2]['phone'], 0, 1, 'C', false);
	$pdf->Ln();
	
	$rowCounter = $rowCounter + 1;
	
	if ($rowCounter >= '3') {
		$pdf->AddPage();
		$rowCounter = 0;
	}
}
?>