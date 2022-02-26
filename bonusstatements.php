<?php
if($_POST['export']){
    $filename='bonus_statement';
    header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=\"$filename\"");
    exportData($bonusrow);
    exit();

}
include 'headers.php';
if($_POST['search']){
    $mno=$_POST['mnosearch'];
    $period=$_POST['period'];
    $_SESSION['period']=$period;
    $_SESSION['mno']=$mno;
    $bonusqry=mysqli_query($config,"SELECT * FROM bonus WHERE Mno='$mno' and period='$period'");
}
function exportData($data){
    $heading = false;
		if(!empty($data))
		  foreach($data as $row) {
			if(!$heading) {
			  // display field/column names as a first row
			  echo implode("\t", array_keys($row)) . "\n";
			  $heading = true;
			}
			echo implode("\t", array_values($row)) . "\n";
		  }
		exit;
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
            Bonus
       </td>
       
    </tr></table>
    <table width="78%" align="right">
        <tr><td>
            <form action="" method="POST">
            <table id="reportsheader" width="100%"><tr><th>
                Member Number:<input type="text" name="mnosearch" id="smallbutton" value="<?php echo $mno ?>"> Period: <select name="period" id="smallbutton">
                    <option selected><?php echo $period ?></option>
                    <option>2019</option>
                    <option>2020</option>
                    <option>2021</option>
                    <option>2022</option>
                </select>
                <input type="submit" name="search" value="Search" id="smallbutton">
            </th></tr></table>
            </form>
        <form method="POST"><table id="areaToPrint" width="100%">
            <tr><td><b>Mno</b></td><td><b>Names</b></td><td><b>Amount</b></td><td><b>Month</b></td><td><b>Period</b></td></tr>
            <?php
            $totalbonus=0;
            while(@$bonusrow=mysqli_fetch_assoc($bonusqry)){
                $mno=$bonusrow['Mno'];
                $names=$bonusrow['Names'];
                $amount=$bonusrow['Amount'];
                $bmonth=$bonusrow['BMonth'];
                $totalbonus=$totalbonus+$amount;
                echo '<tr><td>'.$mno.'</td><td>'.$names.'</td><td align="right">'.number_format($amount,2).'</td><td>'.$bmonth.'</td><td>'.$period.'</td></tr>';
            }
            echo '<tr><td></td><td><b>Total Bonus</b></td><td align="right"><b>'.number_format($totalbonus,2).'</b></td><td></td><td></td></tr>';
            ?>
            <button onclick="printDiv()" id="smallbutton">Print</button><form method="post"><input type="submit" id="smallbutton" value="Export" name="export"></form>
    </table></form>
        <?php echo $form ?>
        </td></tr>
    </table>
    </td></tr>
</table>