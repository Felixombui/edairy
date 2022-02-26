<?php
include 'headers.php';
$stockqry = mysqli_query( $config, 'SELECT * FROM stockcard ORDER BY ItemName' );
$mno = $_GET['mno'];
if ( $_POST['find'] ) {
    $mnumber = $_POST['mnumber'];
    $memberqry = mysqli_query( $config, "SELECT * FROM members WHERE mno='$mnumber'" );
    $memberRow = mysqli_fetch_assoc( $memberqry );
    $_SESSION['membernames'] = $memberRow['FirstName'].' '.$memberRow['OtherNames'];
    $_SESSION['mno'] = $memberRow['mno'];

    $_SESSION['month'] = $_POST['smonth'].' '.$_POST['syear'];
    $mno = $_SESSION['mno'];

}
if ( empty( $mno ) ) {
    //do nothing
} else {
    $orderqry = mysqli_query( $config, "SELECT * FROM cart WHERE mno='$mno'" );
}
if ( $_POST['remove'] ) {
    $confirmation = '<form method="POST"><img src="question.png" width="23" height="23" align="left">Are you sure you want to remove this item?<br><input type="submit" id="smallbutton" name="cyes" value="Yes">&nbsp;<input type="submit" id="smallbutton" name="cno" value="Yes">';
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
Issue Store
</td>

</tr></table>
<table width = '78%' align = 'right'>
<tr><td>
<table id = 'reportsheader' width = '100%'><th><form method = 'post'>
Enter Member Number: <input type = 'text' name = 'mnumber' value = "<?php echo $mno ?>">
Select Month:<select name = 'smonth' id = 'smallbutton'>
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
<select id = 'smallbutton' name = 'syear'>
<option selected><?php echo $_POST['syear'] ?></option>
<option>2020</option>
<option>2021</option>
<option>2022</option>
<option>2023</option>
<option>2024</option>
<option>2025</option>
<option>2026</option>
</select>
<input type = 'submit' name = 'find' value = 'Find'>
</form></th></table>
<table id = 'reports' width = '10%' align = 'left'>
<tr><th>Select Items</th></tr>
<tr><td>
<table class = 'datatable'>
<?php
while( @$stockrow = mysqli_fetch_assoc( $stockqry ) ) {
    $id = $stockrow['id'];
    $itemname = $stockrow['ItemName'];
    $url = 'cart.php?id='.$id;
    echo '<tr><td>'.$itemname.'</td><td><form method="post" action="cart.php?id='.$id.'"><input type="submit" name="add" id="smallbutton" value="Add"></form></tr>';
}
?>
</table>
</td></tr>

</table>
<table id = 'reports' width = '10%' align = 'right'>
<?php $membernames = $_SESSION['membernames'];
$mno = $_SESSION['mno']
?>
<tr><th>Member: <?php echo $membernames.' (Mno:'.$mno.') ' ?></th></tr>
<tr><td>
<table class = 'simpletable'><tr>
<th>Item</th><th>Cost</th><th></th>
</tr>
<?php
$totalcost = 0;
while( @$orderrow = mysqli_fetch_assoc( $orderqry ) ) {
    $cartid = $orderrow['id'];
    echo '<tr><td>'.$orderrow['item'].'</td><td align="right">'.number_format( $orderrow['cost'], 2 ).'</td><td><a href="deletecart.php?cartid='.$cartid.'"><img src="images/delete.ico" width="20" height="20"></a></td></tr>';
    $totalcost = $totalcost+$orderrow['cost'];
}

?>
<tr><td><b>Total</b></td><td align = 'right'><b><?php echo number_format( $totalcost, 2 ) ?></b></td></tr>
</table>

</td></tr>
<?php echo '<tr><td align="center"><a href="submitcart.php?mno='.$mno.'"><input type="submit" name="submitcart" value="Save to store">' ?>
</table>

</td></tr>
</table>
</td></tr>
</table>