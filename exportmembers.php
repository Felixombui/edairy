<?php
include 'config.php';
$qry=mysqli_query($config,"SELECT * FROM members");

require( 'fpdf/fpdf.php' );
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont( 'Arial', 'B', 12 );
$pdf->Cell( 50, 10, 'Waraza Farmers Co-operative Society Limited ', 0, 0, L, false );
$pdf->Ln( 10 );
$pdf->Cell( 50, 10, 'List of Members ', 0, 0, L, false );
$pdf->Ln( 7 );
$width_cell = array( 20, 70,70 );
$pdf->SetFont( 'Arial', 'B', 12 );
$pdf->SetFillColor( 193, 229, 252 );
// Background color of header
// Header starts ///
$pdf->Cell( $width_cell[0], 7, 'Mno', 1, 0, C, true );
// First header column
$pdf->Cell( $width_cell[1], 7, 'Names', 1, 0, C, true );
// First header column
$pdf->Cell( $width_cell[2], 7, 'Phone Number', 1, 0, C, true );
$records=mysqli_num_rows($qry);
$pdf->SetFont( 'Arial', '', 10 );
$pdf->Ln( 7 );
while($row=mysqli_fetch_assoc($qry)){
    $mno=$row['mno'];
    $names=$row['FirstName'].' '.$row['OtherNames'];
    $phone=$row['PhoneNumber'];
    $pdf->Cell($width_cell[0],7,$mno,1,0,L);
    $pdf->Cell($width_cell[1],7,$names,1,0,L);
    $pdf->Cell($width_cell[2],7,$phone,1,0,L);
    $pdf->Ln( 7 );
}
$pdf->Output( 'D', 'Members.pdf', FALSE );
?>