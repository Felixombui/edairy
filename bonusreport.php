<?php
header('Content-type:text/plain');
include 'config.php';
$period=$_GET['year'];
$ba=$_GET['ba'];
$recov=$_GET['recov'];
$cf=$_GET['cf'];
$am=$_GET['am'];
$net=$_GET['net'];
$members=$_GET['members'];
$period=$_GET['period'];
require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
//Document heading
$pdf->Cell(10,8,'Waraza Farmers Co-operative Society Limited',0,0,L);
$pdf->Ln(8);
$pdf->Cell(10,8,'P.O Box 46 Kiganjo',0,0,L);
$pdf->Ln(8);
$pdf->Cell(10,8,'Bonus Payment Report',0,0,L);
$pdf->Ln(8);
$pdf->Cell(10,8,'Period: '.$period,0,0,L);
$pdf->Ln(20);
$pdf->SetFont('Arial','',11);
$pdf->Cell(10,8,'Bonus Amount: '.number_format($ba,2),0,0,L);
$pdf->Cell(100,8,'Recovered: '.number_format($recov,2),0,0,R);
$pdf->Ln(8);
$pdf->Cell(10,8,'Carried Forward: Ksh.'.number_format($cf,2),0,0,L);
$pdf->Cell(100,8,'Additional: Ksh.'.number_format($am,2),0,0,R);
$pdf->Ln(8);
$pdf->Cell(10,8,'Net Amount: Ksh.'.number_format($net,2),0,0,L);
$pdf->Cell(100,8,'Members Paid: Ksh.'.$members,0,0,R);
$pdf->Ln(32);


$pdf->Output( 'D', 'Bonus_Report_'.$period.'.pdf', false );


