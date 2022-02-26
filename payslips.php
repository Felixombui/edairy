<?php
include 'headers.php';
if($_POST['analyze']){
    $pmonth=$_POST['smonth'].' '.$_POST['syear'];
    $slpqry=mysqli_query($config,"SELECT * FROM payments WHERE PaymentMonth='$pmonth'");
}
?>
<table width="90%" align="center">
    <tr><td>
        <table width="20%" align="left" bgcolor="cyan">
            <tr><td align="center"><img src="images/logo.png" width="100" height="100"><div class="creator">Version 2.0<br> By Macra Systems</div>
        <hr color="cadetblue">
        </td></tr>
        <tr><td><a href="memberpayments.php"><img src="images/invoice.png" width="23" height="23" align="left">Payment Analysis</a></td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan" id="reportsheader" ><tr><th>
           Payslips <form method="POST">
               Select Month: <select name="smonth">
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
               <select name="syear">
               <option selected><?php echo $syear ?></option>
                   <option>2020</option>
                   <option>2021</option>
                   <option>2022</option>
                   <option>2023</option>
                   <option>2024</option>
                   <option>2025</option>
                   <option>2026</option>
               </select>
               <input type="submit" name="analyze" value="Show Payslips">
           </form>
       </th></tr></table>
       &nbsp;
       <div id="areaToPrint">
       <table width="78%" align="right"><tr><td>
       
    <?php
    if(@mysqli_num_rows($slpqry)>0){
        while($slprow=mysqli_fetch_assoc($slpqry)){
            echo '<table width="80%" align="center"><tr><td align="center"><h3>Waraza Farmers Co-operative Society Limited<br>P.O Box 46 Kiganjo.<h3><h5>Member Payslip</h5></td></tr><tr><td>
            
            <table width="80%"><tr><td>Slip No:'.$slprow['id'].'</td><td align="right">Month: '.$slprow['PaymentMonth'].'</td></tr>
            <tr><td>Mno: '.$slprow['Mno'].'</td><td align="right">Names: '.$slprow['Names'].'</td></tr>
            <tr><td>Bank: '.$slprow['Bank'].'</td><td align="right">Account: '.$slprow['Account'].'</td></tr>
            <tr><td>Kgs: '.$slprow['kgs'].'</td><td align="right">Rate: '.$slprow['Rate'].'</td></tr>
            </table>

            </td></tr></table>';
        }
    }else{
        echo 'No payments for the selected month!';
    }
    ?>

<?php
$gross=0;
$advance=0;
$store=0;
$vet=0;
$bf=0;
$vehicle=0;
$bonus=0;
$cf=0;
$totalPayable=0;
$totaldeductions=0;
$kgs=0;
$payqry=mysqli_query($config,"SELECT * FROM payments WHERE PaymentMonth='$pmonth'");
$members=mysqli_num_rows($payqry);
while($payrow=mysqli_fetch_assoc($payqry)){
    $gross=$gross+$payrow['gross'];
    $rate=$payrow['Rate'];
    $advance=$advance+$payrow['advance'];
    $store=$store+$payrow['store'];
    $vet=$vet+$payrow['clinicals'];
    $totaldeductions=$totaldeductions+$payrow['totaldeds'];
    $totalPayable=$totalPayable+$payrow['NetPay'];
    $cf=$cf+$payrow['Forwarded'];
    $bf=$bf+$payrow['bfowad'];
    $bonus=$bonus+$payrow['bonus'];
    $vehicle=$vehicle+$payrow['VehicleShares'];
    $kgs=$kgs+$payrow['kgs'];
}
?>

&nbsp;

</td></tr></table></div>
<table align="right"><tr><td></td></tr> </table>
    </td></tr>
</table>
<table width="78%" border="0" align="center">
    <tr><td align="right">
    <button onclick="printDiv()">Print</button>
    </td></tr>
</table>