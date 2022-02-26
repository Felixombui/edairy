<?php
include 'config.php';

$smonth = $_GET['smonth'];
$syear = $_GET['syear'];
$salesmonth = $smonth.' '.$syear;
$count = "SELECT * FROM advance WHERE advancemonth='$salesmonth'";
$qry = mysqli_query( $config, $count );
require( 'fpdf/fpdf.php' );
$pdf = new FPDF();

$pdf->AddPage();
$pdf->SetFont( 'Arial', 'B', 12 );
$pdf->Cell( 50, 10, 'Waraza Farmers Co-operative Society Limited ', 0, 0, L, false );
$pdf->Ln( 10 );
$pdf->Cell( 50, 10, 'Advance Reports '.$salesmonth, 0, 0, L, false );
$pdf->Ln( 10 );
$width_cell = array( 20, 50, 70, 20 );
$pdf->SetFont( 'Arial', 'B', 12 );
$pdf->SetFillColor( 193, 229, 252 );
// Background color of header
// Header starts ///
$pdf->Cell( $width_cell[0], 10, 'Mno', 1, 0, C, true );
// First header column
$pdf->Cell( $width_cell[1], 10, 'Names', 1, 0, C, true );
// Second header column
$pdf->Cell( $width_cell[2], 10, 'Advance Amount', 1, 0, C, true );
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
$totaladvance = 0;
while( $row = mysqli_fetch_assoc( $qry ) ) {
    $advanceAmount = $row['advanceAmount'];
    $totaladvance = $totaladvance+$advanceAmount;
    $pdf->SetFont( 'Arial', '', 10 );
    $pdf->Cell( $width_cell[0], 10, $row['mno'], 1, 0, C, $fill );
    $pdf->SetFont( 'Arial', '', 10 );
    $pdf->Cell( $width_cell[1], 10, $row['names'], 1, 0, L, $fill );
    $pdf->SetFont( 'Arial', '', 10 );
    $pdf->Cell( $width_cell[2], 10, number_format( $row['advanceAmount'], 0 ), 1, 0, C, $fill );
    $pdf->SetFont( 'Arial', 'U', 10 );
    $pdf->Cell( $width_cell[3], 10, $row['date_time'], 1, 1, C, $fill );
    $pdf->SetFont( 'Arial', '', 10 );
    $fill = !$fill;
    // to give alternate background fill  color to rows

}
//}
/// end of records ///
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( $width_cell[0], 10, '', 1, 0, C, $fill );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( $width_cell[1], 10, 'Total Advance', 1, 0, L, $fill );
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Cell( $width_cell[2], 10, number_format( $totaladvance, 2 ), 1, 0, C, $fill );
$pdf->SetFont( 'Arial', 'U', 10 );
$pdf->Cell( $width_cell[3], 10, '', 1, 1, C, $fill );
$pdf->SetFont( 'Arial', '', 10 );

$pdf->Ln( 10 );
$pdf->SetX( 20 );
$pdf->SetFont( 'Arial', '', 10 );
//$pdf->Cell( 40, 10, 'Click the Mark to get details', 0, 0, C, false );

$pdf->Output( 'D', 'Advance.pdf', false );
?>