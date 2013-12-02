<?php
include_once("engine/initialise.php");


$confirmed = Students::find_all_confirmed_by_course("English");
$sets = array_chunk($confirmed, 3);

echo "English";

$rowCounter = 0;

foreach ($sets as $set) {
	printArray($set);
	$pdf->Cell(90, 5, $set, 0, 1);
	/*
	if (file_exists($set[0]['photo'])) {
		$pdf->Cell(65, 50, $pdf->Image($set[0]['photo'], $pdf->GetX()+ 15, $pdf->GetY(), 38), 0, 0, 'C', false );
	} else {
		$pdf->Cell(65, 50, "", 1, 0, 'C', false);
	}
	if (file_exists($set[1]['photo'])) {
		$pdf->Cell(65, 50, $pdf->Image($set[1]['photo'], $pdf->GetX()+ 15, $pdf->GetY(), 38), 0, 0, 'C', false );
	} else {
		$pdf->Cell(65, 50, "", 1, 0, 'C', false);
	}
	if (file_exists($set[2]['photo'])) {
		$pdf->Cell(65, 50, $pdf->Image($set[2]['photo'], $pdf->GetX()+ 15, $pdf->GetY(), 38), 0, 1, 'C', false );
	} else {
		$pdf->Cell(65, 50, "", 1, 1, 'C', false);
	}
	
	$pdf->Cell(65, 5, $set[0]['surname'], 0, 0, 'C', false);
	$pdf->Cell(65, 5, $set[1]['surname'], 0, 0, 'C', false);
	$pdf->Cell(65, 5, $set[2]['surname'], 0, 1, 'C', false);
	$pdf->Cell(65, 5, $set[0]['surname'], 0, 0, 'C', false);
	$pdf->Cell(65, 5, $set[1]['surname'], 0, 0, 'C', false);
	$pdf->Cell(65, 5, $set[2]['surname'], 0, 1, 'C', false);
	$pdf->Cell(65, 5, $set[0]['surname'], 0, 0, 'C', false);
	$pdf->Cell(65, 5, $set[1]['surname'], 0, 0, 'C', false);
	$pdf->Cell(65, 5, $set[2]['surname'], 0, 1, 'C', false);
	$pdf->Ln();
	*/
	$rowCounter = $rowCounter + 1;
	
	if ($rowCounter >= '4') {
		$pdf->AddPage();
		$rowCounter = 0;
	}
}
?>