<?php
$confirmed = Students::find_all_with_dietary();

$pdf->SetFont("Times", 'B', 18);
$pdf->Cell(0, 5, "Dietary Report", 0, 1);
$pdf->Cell(0, 5, "", 0, 1);

$pdf->SetFont("Times", '', 12);
// itterate through each course name
foreach ($confirmed AS $student) {
	$arrivalDate = date('d/m/Y', strtotime($student->arrival_date)) . " " . date('H:i', strtotime($student->arrival_time));
	
	$pdf->SetFont("Times", 'B', 12);
	$pdf->Cell(0, 5, $student->surname . ", " . $student->forenames, 0, 1);
	$pdf->SetFont("Times", '', 12);
	$pdf->Cell(0, 5, "Arrival Date: " . $arrivalDate, 0, 1);
	$pdf->MultiCell(0, 5, "Dietary: " . $student->diet, 0);
	$pdf->Cell(0, 5, "", 0, 1);
}

?>