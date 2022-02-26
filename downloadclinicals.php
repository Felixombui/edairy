<?php

include 'config.php';
//include 'fpdf/fpdf.php';
$smonth = $_GET['smonth'];
$syear = $_GET['syear'];
$salesmonth = $smonth.' '.$syear;
$count = "SELECT * FROM clinicals WHERE ClinicalMonth='$salesmonth'";
$qry = mysqli_query( $config, $count );
require( 'fpdf/fpdf.php' );
$pdf = new FPDF();

$pdf->AddPage();
$pdf->SetFont( 'Arial', 'B', 12 );
$pdf->Cell( 50, 10, 'Waraza Farmers Co-operative Society Limited ', 0, 0, L, false );
$pdf->Ln( 10 );
$pdf->Cell( 50, 10, 'Clinical & A.I Reports '.$salesmonth, 0, 0, L, false );
$pdf->Ln( 10 );
$width_cell = array( 20, 70, 40, 30 );
$pdf->SetFont( 'Arial', 'B', 12 );
$pdf->SetFillColor( 193, 229, 252 );
// Background color of header
// Header starts ///
$pdf->Cell( $width_cell[0], 10, 'Mno', 1, 0, C, true );
// First header column
$pdf->Cell( $width_cell[1], 10, 'Names', 1, 0, C, true );
// Second header column
$pdf->Cell( $width_cell[2], 10, 'Amount', 1, 0, C, true );
// Third header column
$pdf->Cell( $width_cell[3], 10, 'Date', 1, 1, C, true );
// Fourth header
//// header ends ///////
$pdf->SetFont( 'Arial', '', 10 );
$pdf->SetFillColor( 235, 236, 236 );
// Background color of header
$fill = false;
// to give alternate background fill color to rows

/// each record is one row  ///
//if ( $result_set = $connection->query( $count ) ) {
//while( $row = $result_set->fetch_array( MYSQLI_ASSOC ) ) {
$totalbalance = 0;
while( $row = mysqli_fetch_assoc( $qry ) ) {
    $pdf->SetFont( 'Arial', '', 10 );
    $pdf->Cell( $width_cell[0], 10, $row['mno'], 1, 0, C, $fill );
    $pdf->SetFont( 'Arial', '', 10 );
    $pdf->Cell( $width_cell[1], 10, $row['Names'], 1, 0, L, $fill );
    $pdf->SetFont( 'Arial', '', 10 );
    $pdf->Cell( $width_cell[2], 10, number_format( $row['Amount'], 0 ), 1, 0, C, $fill );
    $pdf->SetFont( 'Arial', '', 10 );
    $pdf->Cell( $width_cell[3], 10,  $row['ClinicalMonth'], 1, 1, R, $fill );
    $pdf->SetFont( 'Arial', '', 10 );
    $fill = !$fill;
    $totalbalance = $totalbalance+$row['Amount'];
    // to give alternate background fill  color to rows
}
//}
/// end of records ///
//$pdf->Ln( 10 );
//put totals
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( $width_cell[0], 10, '', 1, 0, C, $fill );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( $width_cell[1], 10, 'Total', 1, 0, L, $fill );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( $width_cell[2], 10, number_format( $totalbalance, 2 ), 1, 0, C, $fill );
$pdf->SetFont( 'Arial', 'U', 10 );
$pdf->Cell( $width_cell[3], 10, '', 1, 1, C, $fill );
$pdf->SetFont( 'Arial', '', 10 );
$fill = !$fill;
//end of totals
$pdf->Ln( 10 );
$pdf->SetX( 20 );
$pdf->SetFont( 'Arial', '', 10 );
//$pdf->Cell( 40, 10, 'Click the Mark to get details', 0, 0, C, false );

$pdf->Output( 'D', 'Clinicals.pdf', FALSE );

?>