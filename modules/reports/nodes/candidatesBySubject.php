<?php
$confirmed = Students::find_all_confirmed();

// Build list of subjects
foreach ($confirmed AS $student) {
	$courseList[$student->course] = $student->course;
}

// itterate through each course name
foreach ($courseList AS $course) {
	$pdf->SetFont("Times", 'B', 18);
	$pdf->Cell(90, 5, $course, 0, 1);
	$pdf->SetFont("Times", '', 18);
	// find students doing this course
	$confirmedByCourse = Students::find_all_confirmed_by_course($course);
	
	// itterate through each student doing this course
	foreach ($confirmedByCourse AS $student) {
		$pdf->Image($student->imageURL(),null,null,30);
		$pdf->Cell(90, 5, $student->fullDisplayName(), 0, 1);
	}
	
	$pdf->AddPage();
}

?>