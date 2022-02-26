<?php

include 'headers.php';
if(isset($_POST['search'])){
    $period=$_POST['period'];
    $bonusqry=mysqli_query($config,"SELECT SUM(Amount) AS TotalBonus FROM bonus WHERE `period`='$period'");
    $bonusrow=mysqli_fetch_assoc($bonusqry);
    $totalbonus=$bonusrow['TotalBonus'];
    $bonuskgs=$totalbonus/2;
    $addedamount=$bonuskgs*0.5;
    $totalamount=$totalbonus+$addedamount;
    $dedsqry=mysqli_query($config,"SELECT SUM(CFDeduction) AS BF FROM bonus_payments WHERE period='$period'");
    $dedsrow=mysqli_fetch_assoc($dedsqry);
    $deductions=$dedsrow['BF'];
    //$NetPayment=$totalamount-$deductions;
    $bonprd='Bonus '.$period;
    $cfqry=mysqli_query($config,"SELECT SUM(Forwarded) AS cf FROM payments WHERE PaymentMonth='$bonprd'");
    $cfrow=mysqli_fetch_assoc($cfqry);
    $carriedfowad=$cfrow['cf'];
    $recovered=$deductions-$carriedfowad;
    $pmtqry=mysqli_query($config,"SELECT * FROM bonus_payments WHERE period='$period'");
    $memberspaid=mysqli_num_rows($pmtqry);
    $NetPayment=$totalamount+$carriedfowad-$recovered;
    
}
?>

<table width="90%" align="center">
    <tr><td>
        <table width="20%" align="left" bgcolor="cyan" class="no-print">
            <tr><td align="center"><img src="images/logo.png" width="100" height="100"><div class="creator">Version 2.0<br> By Macra Systems</div>
        <hr color="cadetblue">
        </td></tr>
        <tr><td><img src="images/view.png" width="23" height="23" align="left"><a href="clinicallist.php">Clinical List</a></td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan"><tr><td>
            Bonus Payment Report
       </td>
       
    </tr></table>
    <table width="78%" align="right">
        <tr><td>
           <form method="post">
               <table><tr><td>Select Period</td><td>
               <select name="period">
               <option>2019</option>
               <option>2020</option>
               <option>2021</option>
               <option>2022</option>
               <option>2023</option>
               <option>2024</option>
               </select>
               <input type="submit" name="search" value="Search">
                </td></tr></table>
                <table style="border-collapse: collapse; border:solid 1px pink;"><tr><th style="border:solid 1px pink;">Bonus Amount</th style="border:solid 1px pink;"><th style="border:solid 1px pink;">Recovered</th><th>Carried Forward</th><th style="border:solid 1px pink;">Additional Amount</th><th style="border:solid 1px pink;">Total Amount</th><th style="border:solid 1px pink;">Members Paid</th></tr>
            <tr><td style="border:solid 1px pink;"><?php echo number_format($totalbonus,2) ?></td><td style="border:solid 1px pink;"><?php echo number_format($recovered,2) ?></td><td style="border:solid 1px pink;"><?php echo $carriedfowad ?></td><td style="border:solid 1px pink;"><?php echo number_format($addedamount,2) ?></td><td style="border:solid 1px pink;"><?php echo number_format($NetPayment,0) ?></td><td style="border:solid 1px pink;"><?php echo number_format($memberspaid,0) ?></td></tr>
            </table>
           </form> 
           <?php echo '<a href="bonusreport.php?ba='.$totalbonus.'&recov='.$recovered.'&cf='.$carriedfowad.'&am='.$addedamount.'&net='.$NetPayment.'&members='.$memberspaid.'&period='.$period.'"' ?>
           <a href="bonusreport.php?year=<?php echo $period ?>"><img src="images/invoice.png" width="30" height="30">Bonus Report</a></a><br>
        <a href="bonuspayslips.php?year=<?php echo $period ?>"><img src="images/icons/Print.jpg" width="30" height="30"> Payslips</a>
        
        </td></tr>
    </table>
    </td></tr>
</table>