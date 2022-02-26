<?php
include 'headers.php';
//$result = shell_exec( 'D:\Systems\eDairyLite\exe\eDairyLite.exe' );
//echo $result;
if ( $_POST['find'] ) {
    $date = 'd/m/Y';
    $mno = $_POST['mno'];
    $month = $_POST['month'].' '.$_POST['year'];
    $frmqry = mysqli_query( $config, "SELECT * FROM members WHERE mno='$mno'" );
    if ( @mysqli_num_rows( $frmqry )>0 ) {
        $frmrow = mysqli_fetch_assoc( $frmqry );
        $names = $frmrow['FirstName'].' '.$frmrow['OtherNames'];
        //echo '<tr><td>Names</td><td><input type="text" name="names" value="'.$names.'"</td></tr>';
        $billingqry = mysqli_query( $config, "SELECT * FROM billing WHERE Mno='$mno' AND CollectionMonth='$month'" );
        if ( mysqli_num_rows( $billingqry )>0 ) {
            $billingrow = mysqli_fetch_assoc( $billingqry );
            $prevreading = $billingrow['TotalCollections'];
            

        } else {
            $prevreading = 0;
        }
        $data = '<tr><td>Names:</td><td><input type="text" name="names" value="'.$names.'"></td></tr><tr><td>Previous Reading:</td><td><input type="text" name="prevreading" value="'.$prevreading.'"</td></tr><tr><td>Current Reading</td><td><input type="text" name="curReading"></td></tr><tr><td></td><td><input type="submit" name="update" Value="Save"></td></tr>';

    } else {
        $data = '<img src="images/error.png" width="20" height="20" align="left">The member number you entered does not exist!';
    }
}
if ( $_POST['update'] ) {
    $curReading = addslashes( $_POST['curReading'] );
    $cumReading = $prevreading+$curReading;
    $date = date( 'd/m/Y' );
    //Save to collections;
    $mno = addslashes( $_POST['mno'] );
    $names = addslashes( $_POST['names'] );
    $prevreading = addslashes( $_POST['prevreading'] );
    $month = $_POST['month'].' '.$_POST['year'];
    mysqli_query( $config, "INSERT INTO collections(Mno,Names,PrevReading,CurrentReading,TotalCollections,CollectionDate,CollectionMonth) VALUES('$mno','$names','$prevreading','$curReading','$cumReading','$date','$month')" );
    //update billing
    if ( $prevreading>0 ) {
        //$mno = addslashes( $_POST['mno'] );
       // $names = addslashes( $_POST['names'] );
       // $prevreading = addslashes( $_POST['prevreading'] );
       // $curReading = addslashes( $_POST['curReading'] );
       // $cumReading = $prevreading+$curReading;
       // $date = date( 'd/m/Y' );
       // $month = $_POST['month'].' '.$_POST['year'];
       // mysqli_query( $config, "UPDATE billing SET PrevReading='$prevreading',CurrentReading='$curReading',TotalCollections='$cumReading' WHERE CollectionMonth='$month' AND Mno='$mno'" );
       $data = '<img src="images/error.png" width="20" height="20" align="left">The member has already been billed for this month!';
    } else {
        $mno = addslashes( $_POST['mno'] );
        $names = addslashes( $_POST['names'] );
        $prevreading = addslashes( $_POST['prevreading'] );
        $curReading = addslashes( $_POST['curReading'] );
        $cumReading = $prevreading+$curReading;
        $date = date( 'd/m/Y' );
        $month = $_POST['month'].' '.$_POST['year'];
        mysqli_query( $config, "INSERT INTO billing(Mno,Names,PrevReading,CurrentReading,TotalCollections,CollectionDate,CollectionMonth) VALUES('$mno','$names','0','$curReading','$cumReading','$date','$month')" );
        $data = '<img src="images/success.png" width="23" height="23" align="left">Collections recorded successfully.';
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
Farmer Collections
</td></tr></table>
<table width = '78%'><tr><td>
<form action = '' method = 'POST'>
<table width = '50%' align = 'center'>
<tr><td>Month</td><td><select name = 'month' class = 'selectinput'>
<option selected><?php echo $_POST['month'] ?></option>
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
<select name = 'year' class = 'selectinput'>
<option selected><?php echo $_POST['year'] ?></option>
<option>2020</option>
<option>2021</option>
<option>2022</option>
<option>2023</option>
<option>2024</option>
<option>2025</option>
</select>
</td></tr>
<tr><td>Member Number</td><td><input type = 'text' name = 'mno' value = "<?php echo $mno ?>"></td></tr>
<tr><td>&nbsp;
</td><td><input type = 'submit' name = 'find' value = 'Find'></td></tr>
<?php
echo $data;
?>
</table>
</form>
</td></tr></table>
</td></tr>
</table>