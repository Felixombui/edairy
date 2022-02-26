<?php
include 'headers.php';
$searchkey=$_GET['skey'];
$billingqry = mysqli_query( $config, "SELECT * FROM billing WHERE CollectionMonth='$searchkey'" );
if ( $_POST['search'] ) {
    $searchkey = $_POST['smonth'].' '.$_POST['syear'];
    $billingqry = mysqli_query( $config, "SELECT * FROM billing WHERE CollectionMonth='$searchkey'" );
}

?>
<table width = '90%' align = 'center'>
<tr><td>
<table width = '20%' align = 'left' bgcolor = 'cyan'>
<tr><td align = 'center'><img src = 'images/logo.png' width = '100' height = '100'><div class = 'creator'>Version 2.0<br> By Macra Systems</div>
<hr color = 'cadetblue'>
</td></tr>
<tr><td><img src = 'images/view.png' width = '23' height = '23' align = 'left'><a href = 'clinicallist.php'>Clinical List</a></td></tr>
</table>
<table width = '78%' align = 'right' bgcolor = 'cyan'><tr><td>
Collections
</td>

</tr></table>
<table width = '78%' align = 'right'>
<tr><td>
<form action = '' method = 'POST'>
<table id = 'reportsheader' width = '100%'><tr><th>
<form action = '' method = 'post'>
Select Month: <select name = 'smonth' id = 'smallbutton'>
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
<select name = 'syear' id = 'smallbutton'>
<option selected><?php echo $_POST['syear'] ?></option>
<option>2020</option>
<option>2021</option>
<option>2022</option>
<option>2023</option>
<option>2024</option>
<option>2025</option>
</select>
<input type = 'submit' name = 'search' id = 'smallbutton' value = 'Analyze'>
</form>
</th></tr></table>
</form>
<form method = 'POST'><table>
<tr><td>
<table id = 'reportsheader' width = '100%' align = 'center'><th>Mno</th><th>Names</th><th>Kgs</th><th>Month</th><th></th>
<?php
$totalcollections = 0;
while( @$billingrow = mysqli_fetch_assoc( $billingqry ) ) {
    $id=$billingrow['id'];
    $mno = $billingrow['Mno'];
    $names = $billingrow['Names'];
    $prev = $billingrow['prevReading'];
    $cur = $billingrow['CurrentReading'];
    $total = $billingrow['TotalCollections'];
    $date = $billingrow['CollectionDate'];
    $totalcollections = $totalcollections+$total;
    echo '<tr><td>'.$mno.'</td><td>'.$names.'</td><td>'.$total.'</td><td>'.$date.'</td><td><a href="deletecollection.php?id='.$id.'&skey='.$searchkey.'"><img src="images/delete.ico" width="20" height="20"></a></td></tr>';
}
echo '<tr><td></td></td><td><b>Total</b></td><td><b>'.$totalcollections.'</b></td><td></td></tr>';
?>
</table>
</td></tr>
</table></form>
<?php echo $form ?>
</td></tr>
</table>
</td></tr>
</table>