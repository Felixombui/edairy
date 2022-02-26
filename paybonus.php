<?php

include 'headers.php';
if($_POST['pay']){
    set_time_limit(0);
    $period=$_POST['period'];
    $frmqry=mysqli_query($config,"SELECT * FROM members");
    $paid=0;
    while($frmrow=mysqli_fetch_assoc($frmqry)){
        $mno=$frmrow['mno'];
        $names=addslashes($frmrow['FirstName']).' '.addslashes($frmrow['OtherNames']);
        $bank=$frmrow['Bank'];
        $account=$frmrow['AccountNo'];
        $bonusqry=mysqli_query($config,"SELECT * FROM bonus WHERE Mno='$mno' AND period='$period'");
        if(mysqli_num_rows($bonusqry)>0){
            $bonusamount=0;
            $additional=0.5;
            while($bonusrow=mysqli_fetch_assoc($bonusqry)){
                $bonusamount=$bonusamount+$bonusrow['Amount'];
            }
            $actualkgs=$bonusamount/2;
            $additionalcash=$actualkgs*0.5;
            $amountpayable=$bonusamount+$additionalcash;
            $bfqry=mysqli_query($config,"SELECT * FROM payments WHERE Mno='$mno' ORDER BY id DESC LIMIT 1");
            $bfrow=mysqli_fetch_assoc($bfqry);
            $bf=$bfrow['Forwarded'];
            $netpay=$amountpayable-$bf;if($netpay<0){
                $neg=-1;
                $forwarded=$netpay*$neg;
                $netpay=0;
            }else{
                $forwarded=0;
            }
            if(mysqli_query($config,"INSERT INTO bonus_payments(Mno,Names,Amount,Bank,AccountN0,CFDeduction,NetPay,`period`) VALUES('$mno','$names','$bonusamount','$bank','$account','$bf','$netpay','$period')")){
                $paid=$paid+1;
                if($forwarded>0){
                    mysqli_query($config,"INSERT INTO payments(Mno,Names,kgs,NetPay,Forwarded,PaymentMonth) VALUES('$mno','$names','0','0','$forwarded','Bonus 2020')");
                }
            }
        }else{
            //skip
        }
    }
    $msg='Bonus payment succeeded. Members paid: '.$paid;
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
            Pay Bonus
       </td>
       
    </tr></table>
    <table width="78%" align="right">
        <tr><td>
           <form method="post">
               <table><tr><td>
                   Select Period: </td><td><select name="period">
                       <option>2019</option>
                       <option>2020</option>
                       <option>2021</option>
                       <option>2022</option>
                       <option>2023</option>
                       <option>2024</option>
                       <option>2025</option>
                   </select>
               </td></tr>
            <tr><td>Additional Deduction:</td><td> <input type="text" name="deduction"></td></tr>
            <tr><td>Additional Payment:</td><td><input type="text" name="addpayment"></td></tr>
            <tr><td></td><td><input type="submit" name="pay" value="Pay Bonus"></td></tr>
        </table>
           </form> 
        <?php echo $msg ?>
        
        </td></tr>
    </table>
    </td></tr>
</table>