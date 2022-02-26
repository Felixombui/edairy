<?php
include 'headers.php';
if($_POST['go']){
    $mnumber=$_POST['search'];
    $memberqry=mysqli_query($config,"SELECT * FROM members WHERE mno='$mnumber'");
    $memberRow=mysqli_fetch_assoc($memberqry);
    $names=addslashes($memberRow['FirstName'].' '.$memberRow['OtherNames']);
    $mno=addslashes($memberRow['mno']); 
    $smonth=$_POST['smonth'];
    $syear=$_POST['syear'];
    $advancemonth=addslashes($_POST['smonth'].' '.$_POST['syear']);
    $_SESSION['month']=$advancemonth;
    $advqry=mysqli_query($config,"SELECT * FROM advance WHERE advancemonth='$advancemonth' AND mno='$mno'");
    $prevAdvance=0;
    if(mysqli_num_rows($advqry)>0){
        while($advrow=mysqli_fetch_assoc($advqry)){
            $currentadv=$advrow['advanceAmount'];
            $prevAdvance=$prevAdvance+$currentadv;
        }
        
    }
    $form='';
}
if($_POST['submit']){
    $mno=$_POST['mno'];
    $names=$_POST['names'];
    $amount=$_POST['amount'];
    $month=$_SESSION['month'];
    $date=date('d/m/Y');
    if(empty($mno)){
        $form='<img src="images/error.png" width="23" height="23" align="left">Error! Please enter a valid member number!';
    }else{
        if(empty($amount)){
            $form='<img src="images/error.png" width="23" height="23" align="left">Error! Please enter the advance amount issued!'; 
        }else{
            if(mysqli_query($config,"INSERT INTO advance(mno,names,advanceAmount,date_time,advancemonth) VALUES('$mno','$names','$amount','$date','$month')")){
                $form='<img src="images/success.png" width="23" height="23" align="left">Advance recorded successfully.'; 
                $_SESSION['month']="";
                $mno="";
                $names="";
            }else{
                $form='<img src="images/error.png" width="23" height="23" align="left">Error! Operation failed. Please contact system admin!'; 
            }
        }
    }
}
?>
<table width="90%" align="center">
    <tr><td>
        <table width="20%" align="left" bgcolor="cyan">
            <tr><td align="center"><img src="images/logo.png" width="100" height="100"><div class="creator">Version 2.0<br> By Macra Systems</div>
        <hr color="cadetblue">
        </td></tr>
        <tr><td><img src="images/view.png" width="23" height="23" align="left"><a href="advancelist.php">Advance List</a></td></tr>
        </table>
       <table width="78%" align="right" bgcolor="cyan"><tr><td>
           Advance
       </td>
       
    </tr></table>
    <table width="78%" align="right">
        <tr><td>
            <form action="" method="POST">
            <table id="reportsheader" width="100%"><tr><th>
                <input type="text" name="search" placeholder="M.Number" id="smallbutton" value="<?php echo $mno ?>">
                Month:
                <select name="smonth" id="smallbutton">
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
                <select id="smallbutton" name="syear">
                <option selected><?php echo $syear ?></option>
                <option>2020</option>
                <option>2021</option>
                <option>2022</option>
                <option>2023</option>
                <option>2024</option>
                <option>2025</option>
                <option>2026</option>
                </select>
                <input type="submit" name="go" value="Go" id="smallbutton">
            </th></tr></table>
            </form>
        <form method="POST"><table>
            <tr><td>Mno:</td><td><input type="text" name="mno" value="<?php echo $mno ?>" readonly></td></tr>
            <tr><td>Names:</td><td><input type="text" name="names" value="<?php echo $names ?>" readonly></td></tr>
            <tr><td>Previous Advance:</td><td><input type="text" name="prevadv" value="<?php echo $prevAdvance ?>" disabled></td></tr>
            <tr><td>Amount Issued:</td><td><input type="text" name="amount"></td></tr>
            <tr><td></td><td><input type="submit" name="submit" value="Submit Advance"</td></tr>
    </table></form>
        <?php echo $form ?>
        </td></tr>
    </table>
    </td></tr>
</table>