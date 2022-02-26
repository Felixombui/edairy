<?php
include 'headers.php';
if ( $_POST['search'] ) {
    $stext = $_POST['banks'];
    $smonth = $_POST['smonth'];
    $syear = $_POST['syear'];
    $month = $smonth.' '.$syear;
    $storeqry = mysqli_query( $config, "SELECT * FROM payments WHERE PaymentMonth='$month' AND Bank='$stext'" );
}

?>
<table width = '90%' align = 'center'>
<tr><td>
<table width = '20%' align = 'left' bgcolor = 'cyan'>
<tr><td align = 'center'><img src = 'images/logo.png' width = '100' height = '100'><div class = 'creator'>Version 2.0<br> By Macra Systems</div>
<hr color = 'cadetblue'>
</td></tr>
</table>
<table width = '78%' align = 'right' bgcolor = 'cyan'><tr><td>
<form method = 'post'>
<select name = 'banks'>
<?php
$banksqry = mysqli_query( $config, 'SELECT * FROM banks' );
while( $bankrow = mysqli_fetch_assoc( $banksqry ) ) {
    echo '<option>'.$bankrow['BankName'].'</option>';
}
?>
</select>
Select Month: <select name = 'smonth'>
<option selected><?php echo $_POST['smonth'] ?></option>
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
<option selected><?php echo $_POST['syear'] ?></option>
<option>2018</option>
<option>2019</option>
<option>2020</option>
<option>2021</option>
<option>2022</option>
<option>2023</option>
<option>2024</option>
<option>2025</option>
</select>
<input type = 'submit' name = 'search' value = 'Search'><p>

</form>
<?php echo '<a href="downloadbankanalysis.php?smonth='.$smonth.'&syear='.$syear.'&bank='.$stext.'"><button id="smallbutton">Download</button>' ?>
</td>

</tr></table>
<table width = '78%' align = 'right'>
<tr><td>
<table id = 'widereports' width = '10%' align = 'left'>
<tr><th>Mno</th><th>Names</th><th>Amount</th><th>Month</th></tr>
<?php
$totalbalance = 0;
while( @$storerow = mysqli_fetch_assoc( $storeqry ) ) {
    $mno = $storerow['Mno'];
    $names = $storerow['Names'];
    $amount = $storerow['NetPay'];
    $balance = $storerow['PaymentMonth'];
    $totalbalance = $totalbalance+$amount;
    echo '<tr><td>'.$mno.'</td><td>'.$names.'</td><td align="right">'.number_format( $amount, 2 ).'</td><td align="right">'.$balance.'</td></tr>';
}
echo '<tr><td></td><td>Total</td><td align="right">'.number_format( $totalbalance, 2 ).'</td><td></td></tr>';
?>

</table>

</td></tr>
</table>
</td></tr>
</table>