<?php
header('Content-type:text/plain');
include 'config.php';
$period=$_GET['year'];
require('fpdf/fpdf.php');
$pdf=new FPDF();
$pdf->AddPage();
$bonusqry=mysqli_query($config,"SELECT * FROM bonus_payments WHERE period='$period'");
while($bonusrow=mysqli_fetch_assoc($bonusqry)){
    $mno=$bonusrow['Mno'];
    $names=$bonusrow['Names'];
    $bonusamount=$bonusrow['Amount'];
    $deduction=$bonusrow['CFDeduction'];
    $netpay=$bonusrow['NetPay'];
    $grosspay=$netpay+$deduction;
    $addedbonus=$grosspay-$bonusamount;
$pdf->SetFont('Arial','B',14);
//Document heading
$pdf->Cell(10,8,'Waraza Farmers Co-operative Society Limited',0,0,L);
$pdf->Ln(8);
$pdf->Cell(10,8,'P.O Box 46 Kiganjo',0,0,L);
$pdf->Ln(8);
$pdf->Cell(10,8,'Bonus Payment Slip',0,0,L);
$pdf->Ln(8);
$pdf->Cell(10,8,'Period: '.$period,0,0,L);
$pdf->Ln(20);
$pdf->SetFont('Arial','',11);
$pdf->Cell(10,8,'M.No: '.$mno,0,0,L);
$pdf->Cell(100,8,'Names: '.$names,0,0,R);
$pdf->Ln(8);
$pdf->Cell(10,8,'Bonus Amount: Ksh.'.$bonusamount,0,0,L);
$pdf->Cell(79,8,'B.Forward: Ksh.'.number_format($deduction,2),0,0,R);
$pdf->Ln(8);
$pdf->Cell(10,8,'Added Amount: Ksh.'.number_format($addedbonus,2),0,0,L);
$pdf->Cell(80,8,'Net Pay: Ksh.'.$netpay,0,0,R);
$pdf->Ln(32);
}

$pdf->Output( 'D', 'Bonus_Payslips_'.$period.'.pdf', false );
?>