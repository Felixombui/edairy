<?php
include 'headers.php';
if ( $_POST['submit'] ) {
    $rate = $_POST['rate'];
    if ( empty( $rate ) ) {
        $msg = '<img src="images/error.png" width="20" height="20">You must enter the payment rate!';
    } else {
        ///check billing
        //$indicator = '<img src="images/error.png" width="20" height="20"> Error! Process aborted. Parameters missing!';
        $month = $_POST['pmonth'].' '.$_POST['pyear'];
        $percentage = 0;
        $indicator = '<div class="progressbar">
        <p>&nbsp;</p>
        <p>Processing...</p>
        <p>0%</p></div>';
        $billingqry = mysqli_query( $config, "SELECT * FROM billing WHERE CollectionMonth='$month'" );
        set_time_limit( 0 );
        while( $billingrow = mysqli_fetch_assoc( $billingqry ) ) {
            //start the payment process
            $mno = $billingrow['Mno'];
            $infoqry = mysqli_query( $config, "SELECT * FROM members WHERE mno='$mno'" );
            $inforow = mysqli_fetch_assoc( $infoqry );
            $names = addslashes( $inforow['FirstName'] ).' '.addslashes( $inforow['OtherNames'] );
            $bank = addslashes( $inforow['Bank'] );
            $account = addslashes( $inforow['AccountNo'] );
            $kgs = addslashes( $billingrow['TotalCollections'] );
            $gross = $kgs*$rate;
            //CheckAdvance
            $advance = 0;
            $advqry = mysqli_query( $config, "SELECT * FROM advance WHERE Mno='$mno' AND advancemonth='$month'" );
            while( $advrow = mysqli_fetch_assoc( $advqry ) ) {
                $advance = $advance+$advrow['advanceAmount'];
            }
            //check store
            $store = 0;
            $storeqry = mysqli_query( $config, "SELECT * FROM store WHERE Mno='$mno' AND SalesMonth='$month'" );
            while( $storerow = mysqli_fetch_assoc( $storeqry ) ) {
                $store = $store+$storerow['balance'];
            }
            //check clinical
            $clinical = 0;
            $clncalqry = mysqli_query( $config, "SELECT * FROM clinicals WHERE mno='$mno' AND ClinicalMonth='$month'" );
            while( $clncalrow = mysqli_fetch_assoc( $clncalqry ) ) {
                $clinical = $clinical+$clncalrow['Amount'];
            }
            //check bfowad
            $bfowad = 0;
            $bfqry = mysqli_query( $config, "SELECT * FROM fowarded WHERE Mno='$mno' and status='Unpaid'" );
            if ( mysqli_num_rows( $bfqry )>0 ) {
                $bfrow = mysqli_fetch_assoc( $bfqry );
                $bfowad = $bfrow['Amount'];
                mysqli_query( $config, "UPDATE fowarded  SET status='Paid' WHERE Mno='$mno'" );
            } else {
                $bfowad = 0;
            }
            //check bonus
            $bnsqry = mysqli_query( $config, "SELECT * FROM bonusexcemptions WHERE Mno='$mno'" );
            if ( mysqli_num_rows( $bnsqry )>0 ) {
                $bonus = 0;
            } else {
                $bonus = $kgs*2;
                $period = explode( ' ', $month );
                mysqli_query( $config, "INSERT INTO bonus(Mno,Names,Amount,BMonth,`period`) VALUES('$mno','$names','$bonus','$month','$period[1]')" );
            }
            //Check vehicle shares
            $vhcqry = mysqli_query( $config, "SELECT SUM(shares) AS TotalShares FROM vehicleshares WHERE mno='$mno'" );

            $vhcrow = mysqli_fetch_assoc( $vhcqry );
            if ( $vhcrow['TotalShares']>2499 ) {
                $shares = 0;
            } else {

                $myshares = 2500-$vhcrow['TotalShares'];
                if ( $myshares>300 ) {
                    $shares = 300;
                    $totalshares = $shares+$vhcrow['TotalShares'];
                    $sbalance = 2500-$totalshares;
                } else {
                    $shares = $myshares;
                    $sbalance = 0;
                }

                mysqli_query( $config, "INSERT INTO vehicleshares(mno,names,shares,Vmonth,instalment,balance) VALUES('$mno','$names','$shares','$month','300','$sbalance')" );
            }
            //total deductions
            $totaldeductions = $advance+$store+$clinical+$bfowad+$bonus+$shares;
            //net pay
            $netpay = $gross-$totaldeductions;
            //cummulative bonus
            $bonusmonth=date('m');
            if($bonusmonth=="12"){
                $bonusperiod=date('Y')+1;
            }else{
                $bonusperiod=date('Y');
            }
            $cumbonusqry = mysqli_query( $config, "SELECT SUM(Amount) AS CumBonus FROM bonus WHERE Mno='$mno' AND period='$bonusperiod'");
            $cumbonusrow = mysqli_fetch_assoc( $cumbonusqry );
            $cumbonus = $cumbonusrow['CumBonus'];//$cumbonusrow['cummbonus']+$bonus;
            if ( $netpay<0 ) {
                $neg = -1;
                $fowaded = $netpay*$neg;
                $netpay = 0;
                mysqli_query( $config, "INSERT INTO fowarded(Mno,Names,Amount,FMonth) VALUES('$mno','$names','$fowaded','$month')" );
            } else {
                $fowaded = 0;
            }
            //Save payments
            mysqli_query( $config, "INSERT INTO payments(Mno,Names,kgs,Rate,gross,advance,store,clinicals,totaldeds,NetPay,Forwarded,PaymentMonth,Bank,Account,bfowad,bonus,VehicleShares,cummbonus) VALUES('$mno','$names','$kgs','$rate','$gross','$advance','$store','$clinical','$totaldeductions','$netpay','$fowaded','$month','$bank','$account','$bfowad','$bonus','$shares','$cumbonus')" );
            mysqli_query( $config, "INSERT INTO statements(Mno,Names,kgs,Rate,gross,advance,store,clinicals,totaldeds,NetPay,Forwarded,PaymentMonth,Bank,Account,bfowad,bonus,Vehicleshares,cummbonus,`period`) VALUES('$mno','$names','$kgs','$rate','$gross','$advance','$store','$clinical','$totaldeductions','$netpay','$fowaded','$month','$bank','$account','$bfowad','$bonus','$shares','$cumbonus','$bonusperiod')" );
            $indicator = '<div class="progressbar">
            <p>&nbsp;</p>
            <p>Processing...</p>';

        }
        //tell me when payments are done;
        $indicator = '<img src="images/success.png" width="20" height="20"> Payments complete.';
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
Farmer Payments
</td></tr></table>
<table width = '50%' align = 'center'><tr><td align = 'center'>
<p> <form action = '' method = 'post'>
<p><input type = 'text' name = 'rate' placeholder = 'Enter payment rate'></p>
<p><select name = 'pmonth'>
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
</select></p>
<p><select name = 'pyear'>
<option>2020</option>
<option>2021</option>
<option>2022</option>
<option>2023</option>
<option>2024</option>
<option>2025</option>
<option>2026</option>

</select></p>
<p><input type = 'submit' value = 'Start Payments' name = 'submit'></p>
</form></p>
<?php echo $indicator ?>
</td></tr></table>
</td></tr>
</table>