<?php
include 'headers.php';
if ( $_POST['analyze'] ) {
    $banksqry = mysqli_query( $config, 'SELECT * FROM banks' );
    $smonth = $_POST['smonth'];
    $syear = $_POST['syear'];
    $pmonth = $_POST['smonth'].' '.$_POST['syear'];
}

?>
<table width = '90%' align = 'center'>
<tr><td>
<table width = '20%' align = 'left' bgcolor = 'cyan'>
<tr><td align = 'center'><img src = 'images/logo.png' width = '100' height = '100'><div class = 'creator'>Version 2.0<br> By Macra Systems</div>
<hr color = 'cadetblue'>
</td></tr>
<tr><td><a href = 'payslips.php'><img src = 'images/invoice.png' width = '23' height = '23' align = 'left'>Payslips</a></td></tr>
</table>
<table width = '78%' align = 'right' bgcolor = 'cyan' id = 'reportsheader' ><tr><th>
Member Payments <form method = 'POST'>
Select Month: <select name = 'smonth'>
<option selected><?php echo $smonth ?></option>
<option>January</option>
<option>February</option>
<option>March</option>
<option>April</option>
<option>May</option>
<option>June</option>
<option>July</option>
<option>August</option>
<option>September</option>
<option>October</option>
<option>November</option>
<option>December</option>
</select>
<select name = 'syear'>
<option selected><?php echo $syear ?></option>
<option>2018</option>
<option>2019</option>
<option>2020</option>
<option>2021</option>
<option>2022</option>
<option>2023</option>
<option>2024</option>
<option>2025</option>
<option>2026</option>
</select>
<input type = 'submit' name = 'analyze' value = 'Analyze Payments'>
</form>
</th></tr></table>
&nbsp;
<div id = 'areaToPrint'>
<table width = '78%' align = 'right'><tr><td>
<table align = 'left' width = '30%' border = '1' class = 'datatable' id = 'reports'><tr><td>
<b>Bank</b>
</td>
<td>
<b> Amount</b>
</td>
</tr>
<?php
$totalamount = 0;
while( @$banksrow = mysqli_fetch_assoc( $banksqry ) ) {
    $bank = $banksrow['BankName'];
    $amntqry = mysqli_query( $config, "SELECT * FROM statements WHERE Bank='$bank' AND PaymentMonth='$pmonth'" );
    $amount = 0;
    while( $amntrow = mysqli_fetch_assoc( $amntqry ) ) {
        $amount = $amount+$amntrow['NetPay'];
    }
    $totalamount = $totalamount+$amount;
    echo '<tr><td>'.$bank.'</td><td align="right">'.number_format( $amount, 2 ).'</td></tr>';
}
echo '<tr><td><b>Total</b></td><td align="right"><b>'.number_format( $totalamount, 2 ).'</b></td></tr>';
?>
</table>
<?php
$gross = 0;
$advance = 0;
$store = 0;
$vet = 0;
$bf = 0;
$vehicle = 0;
$bonus = 0;
$cf = 0;
$totalPayable = 0;
$totaldeductions = 0;
$kgs = 0;
$payqry = mysqli_query( $config, "SELECT * FROM statements WHERE PaymentMonth='$pmonth'" );
$members = mysqli_num_rows( $payqry );
while( $payrow = mysqli_fetch_assoc( $payqry ) ) {
    $gross = $gross+$payrow['gross'];
    $rate = $payrow['Rate'];
    $advance = $advance+$payrow['advance'];
    $store = $store+$payrow['store'];
    $vet = $vet+$payrow['clinicals'];
    $totaldeductions = $totaldeductions+$payrow['totaldeds'];
    $totalPayable = $totalPayable+$payrow['NetPay'];
    $cf = $cf+$payrow['Forwarded'];
    $bf = $bf+$payrow['bfowad'];
    $bonus = $bonus+$payrow['bonus'];
    $vehicle = $vehicle+$payrow['VehicleShares'];
    $kgs = $kgs+$payrow['kgs'];
}
?>
<table width = '40%' align = 'center' id = 'reports' border = '1'><tr><td>Total Kgs</td><td><?php echo number_format( $kgs, 2 ) ?></td><td>Rate: Ksh.<?php echo $rate ?></td></tr></table>
&nbsp;
<table id = 'reports' width = '40%' align = 'center' border = '1'><tr><td><b>Description</b></td><td><b>Payment</b></td><td><b>Deduction</b></td></tr>
<tr><td>Gross</td><td align = 'right'><?php echo number_format( $gross, 2 ) ?></td><td>&nbsp;
</td></tr>
<tr><td>Advance</td><td>&nbsp;
</td><td align = 'right'><?php echo number_format( $advance, 2 ) ?></td></tr>
<tr><td>Store</td><td>&nbsp;
</td><td align = 'right'><?php echo number_format( $store, 2 ) ?></td></tr>
<tr><td>Vet Services</td><td>&nbsp;
</td><td align = 'right'><?php echo number_format( $vet, 2 ) ?></td></tr>
<tr><td>Brought Forward</td><td>&nbsp;
</td><td align = 'right'><?php echo number_format( $bf, 2 ) ?></td></tr>
<tr><td>Vehcile Shares</td><td>&nbsp;
</td><td align = 'right'><?php echo number_format( $vehicle, 2 ) ?></td></tr>
<tr><td>Bonus</td><td>&nbsp;
</td><td align = 'right'><?php echo number_format( $bonus, 2 ) ?></td></tr>
<tr><td>Carried Forward</td><td align = 'right'><?php echo number_format( $cf, 2 ) ?></td><td>&nbsp;
</td></tr>
<tr><td><b>Total</b></td><td align = 'right'><b><?php echo number_format( $totalPayable, 2 ) ?></b></td><td align = 'right'><b><?php echo number_format( $totaldeductions, 2 ) ?></b></td></tr>
</table>
&nbsp;
<table width = '40%' align = 'center' border = '1' id = 'reports'><tr><td align = 'center'>Members Paid: <?php echo $members ?></td></tr></table>
</td></tr></table></div>
<table align = 'right'><tr><td></td></tr> </table>
</td></tr>
</table>
<table width = '78%' border = '0' align = 'center'>
<tr><td align = 'right'>
<button onclick = 'printDiv()'>Print</button>
</td></tr>
</table>