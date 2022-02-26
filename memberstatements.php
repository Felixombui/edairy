<?php
include 'headers.php';
if ( $_POST['search'] ) {
    $stext = $_POST['searchtext'];
    //$smonth = $_POST['smonth'];
    $syear = $_POST['syear'];
    $month = $smonth.' '.$syear;
    if ( empty( $stext ) ) {
        $storeqry = mysqli_query( $config, "SELECT * FROM statements WHERE PaymentMonth Like '%$syear%'" );
        $firstcols = '<th>Mno</th><th>Names</th>';
    } else {
        $firstcols = '';
        if ( $stext == 'All' ) {
            $storeqry = mysqli_query( $config, "SELECT * FROM statements WHERE Mno='$stext'" );
        } else {
            $storeqry = mysqli_query( $config, "SELECT * FROM statements WHERE Mno='$stext' and PaymentMonth LIKE '%$syear%'" );
        }
        $memberqry = mysqli_query( $config, "SELECT * FROM members WHERE mno='$stext'" );
        $memberrow = mysqli_fetch_assoc( $memberqry );
        $mno = $memberrow['mno'];
        $names = $memberrow['FirstName'].' '.$memberrow['OtherNames'];
        $bank = $memberrow['Bank'];
        $account = $memberrow['AccountNo'];
    }
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
<input type = 'text' name = 'searchtext' value = "<?php echo $_POST['searchtext'] ?>" placeholder = 'Search Member Number'>
Select Year:

<select name = 'syear'>
<option selected><?php echo $_POST['syear'] ?></option>
<option>All</option>
<option>2017</option>
<option>2018</option>
<option>2019</option>
<option>2020</option>
<option>2021</option>
<option>2022</option>
<option>2023</option>
<option>2024</option>
<option>2025</option>
</select>
<input type = 'submit' name = 'search' value = 'Search'>
</form>
</td>

</tr></table>
<div id = 'areaToPrint'>
<table width = '78%' align = 'right'>
<tr><td>
<table id = 'widereports'><th><?php echo $names.' ('.$mno.') Bank: '.$bank.' Account: '.$account ?></th></table>
<table id = 'widereports' width = '10%' align = 'left'>
<tr><?php echo $firstcols ?><th>Kgs</th><th>Rate</th><th>Gross</th><th>Advance</th><th>Store</th><th>A.I</th><th>B.F</th><th>Bonus</th><th>V.Shares</th><th>T.Deds</th><th>Net Pay</th><th>Fowaded</th><th>Month</th></tr>
<?php
$totalbalance = 0;
while( @$storerow = mysqli_fetch_assoc( $storeqry ) ) {
    $mno = $storerow['Mno'];
    $names = $storerow['Names'];
    $kgs = $storerow['kgs'];
    $rate = $storerow['Rate'];
    $gross = $storerow['gross'];
    $advance = $storerow['advance'];
    $store = $storerow['store'];
    $ai = $storerow['clinicals'];
    $bf = $storerow['bfowad'];
    $bonus = $storerow['bonus'];
    $vshares = $storerow['VehicleShares'];
    $totaldeds = $storerow['totaldeds'];
    $net = $storerow['NetPay'];
    $month = $storerow['PaymentMonth'];
    $cf = $storerow['Forwarded'];
    if ( empty( $stext ) ) {
        echo '<tr><td>'.$mno.'</td><td>'.$names.'</td><td>'.$kgs.'</td><td>'.$rate.'</td><td>'.$gross.'</td><td>'.$advance.'</td><td>'.$store.'</td><td align="right">'.$ai.'</td><td>'.$bf.'</td><td>'.$bonus.'</td><td>'.$vshares.'</td><td>'.$totaldeds.'</td><td>'.$net.'</td><td>'.$cf.'</td><td>'.$month.'</td></tr>';
    } else {
        echo '<tr><td>'.$kgs.'</td><td>'.$rate.'</td><td>'.$gross.'</td><td>'.$advance.'</td><td>'.$store.'</td><td align="right">'.$ai.'</td><td>'.$bf.'</td><td>'.$bonus.'</td><td>'.$vshares.'</td><td>'.$totaldeds.'</td><td>'.$net.'</td><td>'.$cf.'</td><td>'.$month.'</td></tr>';
    }
}

?>

</table>

</td></tr>
</table>
</div>
<table width = '100%'><tr><td align = 'right'><button onclick = 'printDiv()'>Print</button></td></tr></table>
<div align = 'right'></div>
</td></tr>
</table>