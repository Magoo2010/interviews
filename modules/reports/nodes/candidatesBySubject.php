<?php
$confirmed = Students::find_all_confirmed();

// Build list of subjects
foreach ($confirmed AS $student) {
	$courseList[] = $student->course;
}

// itterate through each course name
foreach ($courseList AS $couseListUID => $courseName) {
	$pdf->Cell(90, 5, "Course Name: " . $courseName, 0, 1);
	
	// find students doing this course
	$confirmedByCourse = Students::find_all_confirmed_by_course($courseName);
	
	// itterate through each student doing this course
	foreach ($confirmedByCourse AS $student) {
		$pdf->Image($student->imageURL(),null,null,30);
		$pdf->Cell(90, 5, $student->fullDisplayName(), 0, 1);
	}
}

?>